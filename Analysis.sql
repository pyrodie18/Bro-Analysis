/*CREATE TEMP TABLE WITH ALL IPS IDENTIFIED FROM PASSIVE_DNS AND EXEMPT_IPS*/
CREATE TABLE IF NOT EXISTS tmp_known_ips AS (SELECT distinct(PASSIVE_ANSWER) AS ip_address 
FROM passive_dns);
INSERT INTO tmp_known_ips (ip_address) SELECT exempt_address FROM exempt_ips;


/*1A.  Are there unusual user agent strings?
Filter BRO_CONN and BRO_HTTP for connections originating from internal hosts.  Show count of times each user agent is used
and the number of hosts using that user agent.  Sort by number of hosts using the user agent*/
SELECT bro_http.HTTP_USERAGENT, COUNT(bro_http.HTTP_USERAGENT) as SumOfAgent, COUNT(DISTINCT(bro_conn.CONN_ORIGH)) as SumOfHosts
FROM bro_http
LEFT JOIN bro_conn
ON bro_http.HTTP_UID = bro_conn.CONN_UID
where bro_conn.CONN_ORIGH >= INET6_ATON('10.0.0.0') AND bro_conn.CONN_ORIGH <= INET6_ATON('10.255.255.255')
GROUP BY bro_http.HTTP_USERAGENT
ORDER BY SumOfHosts DESC;

/*1B.  Are there unusual user agent strings?
Filter BRO_CONN and BRO_HTTP for connections originating from internal hosts.  Show count of times each user agent is used
and the number of hosts using that user agent.  Sort by number of hosts using the user agent*/
SELECT bro_http.HTTP_USERAGENT, COUNT(bro_http.HTTP_USERAGENT) as SumOfAgent, COUNT(DISTINCT(bro_conn.CONN_ORIGH)) as SumOfHosts
FROM bro_http
LEFT JOIN bro_conn
ON bro_http.HTTP_UID = bro_conn.CONN_UID
where bro_conn.CONN_ORIGH >= INET6_ATON('10.0.0.0') AND bro_conn.CONN_ORIGH <= INET6_ATON('10.255.255.255')
GROUP BY bro_http.HTTP_USERAGENT
ORDER BY SumOfAgent DESC;
