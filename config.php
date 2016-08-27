<?php
/**
 * This file contains all of the user configuration settings for the program.
 * Each type of log file has it's on configuration setting.
 * Column should be entered starting from 0 on the left and moving right.
 */


define('DB_NAME', 'test');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

// ** This section contains all conifguration settings for bro conn logs ** //
define("CONN_LOG_INSERT", "INSERT INTO bro_conn (CONN_TS, CONN_UID, CONN_ORIGH, CONN_ORIGP, CONN_RESPH, CONN_RESPP, CONN_PROTO, CONN_SERVICE, CONN_DURATION, CONN_ORIGBYTES, CONN_RESPBYTES, CONN_CONNSTATE, CONN_HISTORY, CONN_ORIGPKTS, CONN_ORIGIPBYTES, CONN_RESPPKTS, CONN_RESPIPBYTES) VALUES "); //Holds the overall SQL insert statement
define('CONN_TS', 0);  //Timestamp
define('CONN_UID', 1);  //UID
define('CONN_ORIGH', 2);  //Originating Host
define('CONN_ORIGP', 3);  //Originatin Port
define('CONN_RESPH', 4);  //Responding Host
define('CONN_RESPP', 5);  //Responding Port
define('CONN_PROTO', 6);  //Protocol
define('CONN_SERVICE', 7);  //Service
define('CONN_DURATION', 8);  //Duration
define('CONN_ORIGBYTES', 9);  //Originating Bytes
define('CONN_RESPBYTES', 10);  //Responding Bytes
define('CONN_CONNSTATE', 11);  //Connection State
define('CONN_HISTORY', 15);  //History
define('CONN_ORIGPKTS', 16);  //Originating Packets
define('CONN_ORIGIPBYTES', 17);  //Originating IP Bytes
define('CONN_RESPPKTS', 18);  //Responding Packets
define('CONN_RESPIPBYTES', 19);  //Responding IP Bytes

// ** This section contains all conifguration settings for bro HTTP logs ** //
define("HTTP_LOG_INSERT", "INSERT INTO bro_http (HTTP_UID, HTTP_METHOD, HTTP_HOST, HTTP_URI, HTTP_REFERRER, HTTP_USERAGENT, HTTP_REQLEN, HTTP_RESPLEN, HTTP_STATUSCODE) VALUES "); //Holds the overall SQL insert statement
define('HTTP_UID', 1);  //UID
define('HTTP_METHOD', 7);  //HTTP Request Verb
define('HTTP_HOST', 8);  //Value of the Host Header
define('HTTP_URI', 9);  //URI
define('HTTP_REFERRER', 10);  //Referer header
define('HTTP_USERAGENT', 11);  //User Agent String
define('HTTP_REQLEN', 12);  //Request Length
define('HTTP_RESPLEN', 13);  //Responding Length
define('HTTP_STATUSCODE', 14);  //Status Code
define('HTTP_STATUSMSG', 15);  //Status Message

// ** This section contains all conifguration settings for bro DNS logs ** //
define("DNS_LOG_INSERT", "INSERT INTO bro_dns (DNS_UID, DNS_TRANSID, DNS_QUERY, DNS_CLASSNAME, DNS_TYPENAME, DNS_ANSWERS) VALUES "); //Holds the overall SQL insert statement
define('DNS_UID', 1);  //UID
define('DNS_ORIGH', 2);  //Originating Host
define('DNS_ORIGP', 3);  //Originatin Port
define('DNS_RESPH', 4);  //Responding Host
define('DNS_RESPP', 5);  //Responding Port
define('DNS_PROTO', 6);  //Protocol
define('DNS_TRANSID', 7);  //Transaction ID
define('DNS_QUERY', 8);  //Query
define('DNS_CLASSNAME', 10);  //Class Name
define('DNS_TYPENAME', 12);  //Type Name
define('DNS_ANSWERS', 20);  //Query Answers

// ** This section contains all conifguration settings for bro DHCP logs ** //
define('DHCP_TS', 0);  //Timestamp
define('DHCP_UID', 1);  //UID
define('DHCP_ORIGH', 2);  //Originating Host
define('DHCP_ORIGP', 3);  //Originatin Port
define('DHCP_RESPH', 4);  //Responding Host
define('DHCP_RESPP', 5);  //Responding Port
define('DHCP_MAC', 6);  //MAC 
define('DHCP_ASNIP', 7);  //Assigned IP

// ** This section contains all conifguration settings for bro files logs ** //
define("FILE_LOG_INSERT", "INSERT INTO bro_file (FILE_FUID, FILE_UID, FILE_SOURCE, FILE_ANALYZERS,FILE_MIME, FILE_FILENAME, FILE_MD5, FILE_SHA1, FILE_SHA256, FILE_EXTRACTED) VALUES "); //Holds the overall SQL insert statement
define('FILE_TS', 0);  //Timestamp
define('FILE_FUID', 1);  //UID
define('FILE_TXH', 2);  //Transmit Host
define('FILE_RXH', 3);  //Recieving Host
define('FILE_UID', 4);  //Connection UID
define('FILE_SOURCE', 5);  //File Source
define('FILE_ANALYZERS', 7);  //File Analyzers
define('FILE_MIME', 8);  //MIME Type
define('FILE_FILENAME', 9);  //Source File Name
define('FILE_MD5', 19);  //MD5
define('FILE_SHA1', 20);  //SHA1
define('FILE_SHA256', 21);  //SHA265
define('FILE_EXTRACTED', 22);  //Local File Name if Extracted

// ** This section contains all conifguration settings for bro FTP logs ** //
define("FTP_LOG_INSERT", "INSERT INTO bro_dns (uid, command, arg, mime, size, replycode, fuid) VALUES "); //Holds the overall SQL insert statement
define('FTP_TS', 0);  //Timestamp
define('FTP_UID', 1);  //UID
define('FTP_ORIGH', 2);  //Originating Host
define('FTP_ORIGP', 3);  //Originatin Port
define('FTP_RESPH', 4);  //Responding Host
define('FTP_RESPP', 5);  //Responding Port
define('FTP_COMMAND', 8);  //Command
define('FTP_ARG', 9);  //Command Arguments
define('FTP_MIME', 10);  //MIME Type
define('FTP_SIZE', 11);  //File Size
define('FTP_RPLYCODE', 12);  //Reply Code
define('FTP_FUID', 15);  //File UID

// ** This section contains all conifguration settings for bro SMTP logs ** //
define('SMTP_TS', 0);  //Timestamp
define('SMTP_UID', 1);  //UID
define('SMTP_ORIGH', 2);  //Originating Host
define('SMTP_ORIGP', 3);  //Originatin Port
define('SMTP_RESPH', 4);  //Responding Host
define('SMTP_RESPP', 5);  //Responding Port
define('SMTP_STATUS', 6);  //SMTPection Status

// ** This section contains all conifguration settings for bro SSL logs ** //
define("SSL_LOG_INSERT", "INSERT INTO bro_ssl (SSL_UID, SSL_VERSION, SSL_CIPHER, SSL_SERVER, SSL_SUBJECT, SSL_ISSUER, SSL_CLIENT_SUBJECT, SSL_CLIENT_ISSUER) VALUES "); //Holds the overall SQL insert statement
define('SSL_TS', 0);  //Timestamp
define('SSL_UID', 1);  //UID
define('SSL_ORIGH', 2);  //Originating Host
define('SSL_ORIGP', 3);  //Originatin Port
define('SSL_RESPH', 4);  //Responding Host
define('SSL_RESPP', 5);  //Responding Port
define('SSL_VERSION', 6);  //SSL Version
define('SSL_CIPHER', 7);  //Cipher Suite
define('SSL_SERVER', 9);  //Certificate Server Name
define('SSL_CHAIN_FUID', 14);  //Certificate Chain File UIDs
define('SSL_CLIENT_CHAIN_FUID', 15);  //Client Certificate Chain File UIDs
define('SSL_SUBJECT', 16);  //X.509 Subject
define('SSL_ISSUER', 17);  //Certificate Issuer
define('SSL_CLIENT_SUBJECT', 18);  //Subject of X.509 Client
define('SSL_CLIENT_ISSUER', 19);  //Subject of X.509 Issuer

// ** This section contains all conifguration settings for bro X509 logs ** //
define("X509_LOG_INSERT", "INSERT INTO bro_x509 (X509_FUID, X509_VERSION, X509_SERIAL, X509_SUBJECT, X509_ISSUER, X509_NOTVALIDBEFORE, X509_NOTVALIDAFTER, X509_KEYALG, X509_SIGALG, X509_KEYTYPE, X509_KEYLENGTH, X509_SANDNS, X509_SANURI, X509_SANEMAIL, X509_SANIP, X509_CA) VALUES "); //Holds the overall SQL insert statement
define('X509_TS', 0);  //Timestamp
define('X509_FUID', 1);  //File UID
define('X509_VERSION', 2);  //Version Number
define('X509_SERIAL', 3);  //Serial Number
define('X509_SUBJECT', 4);  //Subject
define('X509_ISSUER', 5);  //Issuer
define('X509_NOTVALIDBEFORE', 6);  //Not Valid Before Date
define('X509_NOTVALIDAFTER', 7);  //Not Valid After Date
define('X509_KEYALG', 8);  //Key Algorithim
define('X509_SIGALG', 9);  //Signature Algorithim
define('X509_KEYTYPE', 10);  //Key Type
define('X509_KEYLENGTH', 11);  //Key Length
define('X509_SANDNS', 14);  //SAN DNS
define('X509_SANURI', 15);  //SAN URI
define('X509_SANEMAIL', 16);  //SAN Email
define('X509_SANIP', 17);  //SAN IP
define('X509_CA', 18);  //Certificate Authorityy
define('X509_PATHLEN', 19);  //Certificate Path Length

?>

