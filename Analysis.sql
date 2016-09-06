/*1A.  Are there unusual user agent strings?
Filter BRO_CONN and BRO_HTTP for connections originating from internal hosts.  Show count of times each user agent is used
and the number of hosts using that user agent.  Sort by number of hosts using the user agent*/
SELECT bro_http.HTTP_USERAGENT, COUNT(bro_http.HTTP_USERAGENT) as SumOfAgent, COUNT(DISTINCT(bro_conn.CONN_ORIGH)) as SumOfHosts
FROM bro_http
LEFT JOIN bro_conn
ON bro_http.HTTP_UID = bro_conn.CONN_UID
WHERE bro_conn.CONN_ORIGH >= INET6_ATON('10.0.0.0') AND bro_conn.CONN_ORIGH <= INET6_ATON('10.255.255.255')
GROUP BY bro_http.HTTP_USERAGENT
ORDER BY SumOfHosts DESC;

/*1B.  Are there unusual user agent strings?
Filter BRO_CONN and BRO_HTTP for connections originating from internal hosts.  Show count of times each user agent is used
and the number of hosts using that user agent.  Sort by number of hosts using the user agent*/
SELECT bro_http.HTTP_USERAGENT, COUNT(bro_http.HTTP_USERAGENT) as SumOfAgent, COUNT(DISTINCT(bro_conn.CONN_ORIGH)) as SumOfHosts
FROM bro_http
LEFT JOIN bro_conn
ON bro_http.HTTP_UID = bro_conn.CONN_UID
WHERE bro_conn.CONN_ORIGH >= INET6_ATON('10.0.0.0') AND bro_conn.CONN_ORIGH <= INET6_ATON('10.255.255.255')
GROUP BY bro_http.HTTP_USERAGENT
ORDER BY SumOfAgent DESC;


/*2.  Are there any SMB connections that don't go to/from a domain controller?
Filter BRO_CONN files with a destination port of 445 (SMB).  Display source and destination IP address and destination port number and a count of the uniq grouping*/
SELECT INET6_NTOA(bro_conn.CONN_ORIGH) as src_ip, INET6_NTOA(bro_conn.CONN_RESPH) as dst_ip, bro_conn.CONN_RESPP, COUNT(bro_conn.CONN_RESPH) AS total_connections
FROM bro_conn
WHERE bro_conn.CONN_RESPP = 445
/*Add line about exclude domain controllers*/
GROUP BY bro_conn.CONN_ORIGH, bro_conn.CONN_RESPH
ORDER BY total_connections DESC


/*3.  Are there any external originating connections to unexpected hosts?
Filter BRO_CONN for all connections originating from outside the network that complete (state of SF).  Remove expected connections (DNS, web servers, SMTP, etc)*/
SELECT bro_conn.CONN_TS AS TIME, INET6_NTOA(bro_conn.CONN_ORIGH) AS SRC_IP, bro_conn.CONN_ORIGP AS SRC_PORT, INET6_NTOA(bro_conn.CONN_RESPH) AS DST_IP, bro_conn.CONN_RESPP AS DST_PORT, bro_conn.CONN_PROTO AS PROTOCOL, bro_conn.CONN_ORIGIPBYTES AS SRC_BYTES, bro_conn.CONN_RESPIPBYTES AS DST_BYTES, bro_conn.CONN_UID AS UID
FROM bro_conn
WHERE bro_conn.CONN_CONNSTATE = "SF" AND
(bro_conn.CONN_ORIGH < INET6_ATON('10.0.0.0') OR bro_conn.CONN_ORIGH > INET6_ATON('10.255.255.255'))
/*Add line about exclude DNS, web servers, and email*/
ORDER BY bro_conn.CONN_TS


/*4.  Are there any connections from internal hosts to external hosts without a corresponding DNS request
CREATE TEMP TABLE WITH ALL IPS IDENTIFIED FROM PASSIVE_DNS AND EXEMPT_IPS*/
CREATE TABLE IF NOT EXISTS tmp_known_ips AS (SELECT distinct(PASSIVE_ANSWER) AS ip_address 
FROM passive_dns);

/*FIND ALL DESINATION ADDRESSES THAT DIDN'T HAVE A CORRESPONDING DNS ANSWER
Filter out DNS traffic*/
SELECT DISTINCT(INET6_NTOA(bro_conn.CONN_RESPH)) AS missing_address
FROM bro_conn
LEFT JOIN tmp_known_ips ON tmp_known_ips.ip_address = bro_conn.CONN_RESPH
WHERE tmp_known_ips.ip_address IS NULL AND 
(bro_conn.CONN_RESPH < INET6_ATON('10.3.0.0') OR bro_conn.CONN_RESPH > INET6_ATON('10.3.255.255')) AND NOT 
(bro_conn.CONN_ORIGH = inet6_aton('10.3.58.4') AND bro_conn.CONN_RESPP = 53) 
ORDER BY CONN_ORIGH, CONN_RESPH, CONN_RESPP
