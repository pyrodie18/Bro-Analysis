
DROP TABLE IF EXISTS `bro_conn`;
CREATE TABLE IF NOT EXISTS `bro_conn` (
  `CONN_ID` bigint(20) unsigned NOT NULL,
  `CONN_TS` timestamp(6) NOT NULL,
  `CONN_UID` varchar(20) NOT NULL,
  `CONN_ORIGH` varbinary(16) NOT NULL,
  `CONN_ORIGP` smallint(5) unsigned NOT NULL,
  `CONN_RESPH` varbinary(16) NOT NULL,
  `CONN_RESPP` smallint(5) unsigned NOT NULL,
  `CONN_PROTO` varchar(10) NOT NULL,
  `CONN_SERVICE` varchar(7) NOT NULL,
  `CONN_DURATION` decimal(11,6) NOT NULL,
  `CONN_ORIGBYTES` int(10) unsigned NOT NULL,
  `CONN_RESPBYTES` int(10) unsigned NOT NULL,
  `CONN_CONNSTATE` varchar(10) NOT NULL,
  `CONN_HISTORY` varchar(10) NOT NULL,
  `CONN_ORIGPKTS` int(10) unsigned NOT NULL,
  `CONN_ORIGIPBYTES` int(10) unsigned NOT NULL,
  `CONN_RESPPKTS` int(10) unsigned NOT NULL,
  `CONN_RESPIPBYTES` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `bro_conn`
  ADD PRIMARY KEY (`CONN_ID`),
  ADD KEY `CONN_ORIGH` (`CONN_ORIGH`),
  ADD KEY `CONN_ORIGP` (`CONN_ORIGP`),
  ADD KEY `CONN_RESPH` (`CONN_RESPH`),
  ADD KEY `CONN_RESPP` (`CONN_RESPP`);

ALTER TABLE `bro_conn`
  MODIFY `CONN_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
  
DROP TABLE IF EXISTS `bro_dns`;
CREATE TABLE IF NOT EXISTS `bro_dns` (
  `DNS_ID` bigint(20) unsigned NOT NULL,
  `DNS_UID` varchar(20) NOT NULL,
  `DNS_TRANSID` varchar(20) NOT NULL,
  `DNS_QUERY_SUBDOMAIN` varchar(255) NOT NULL,
  `DNS_QUERY_TLD` varchar(255) NOT NULL,
  `DNS_CLASSNAME` varchar(255) NOT NULL,
  `DNS_TYPENAME` varchar(255) NOT NULL,
  `DNS_RESPONSECODENAME` varchar(255) NOT NULL,
  `DNS_ANSWERS` varchar(255) NOT NULL,
  `DNS_TTL` int unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `bro_dns`
  ADD PRIMARY KEY (`DNS_ID`),
  ADD KEY `DNS_UID` (`DNS_UID`),
  ADD KEY `DNS_QUERY_SUBDOMAIN` (`DNS_QUERY_SUBDOMAIN`),
  ADD KEY `DNS_QUERY_TLD` (`DNS_QUERY_TLD`);

ALTER TABLE `bro_dns`
  MODIFY `DNS_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT;  
  
DROP TABLE IF EXISTS `bro_file`;
CREATE TABLE IF NOT EXISTS `bro_file` (
  `FILE_ID` bigint(20) unsigned NOT NULL,
  `FILE_FUID` varchar(20) NOT NULL,
  `FILE_TXHOST` varbinary(16) NOT NULL,
  `FILE_RXHOST` varbinary(16) NOT NULL,
  `FILE_UID` varchar(20) NOT NULL,
  `FILE_SOURCE` varchar(254) NOT NULL,
  `FILE_ANALYZERS` varchar(50) NOT NULL,
  `FILE_MIME` varchar(50) NOT NULL,
  `FILE_FILENAME` varchar(100) NOT NULL,
  `FILE_MD5` varchar(32) NOT NULL,
  `FILE_SHA1` varchar(40) NOT NULL,
  `FILE_SHA256` varchar(64) NOT NULL,
  `FILE_EXTRACTED` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `bro_file`
  ADD PRIMARY KEY (`FILE_ID`),
  ADD KEY `FILE_FUID` (`FILE_FUID`),
  ADD KEY `FILE_TXHOST` (`FILE_TXHOST`),
  ADD KEY `FILE_RXHOST` (`FILE_RXHOST`),
  ADD KEY `FILE_UID` (`FILE_UID`);

ALTER TABLE `bro_file`
  MODIFY `FILE_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT;  
  
DROP TABLE IF EXISTS `bro_http`;
CREATE TABLE IF NOT EXISTS `bro_http` (
  `HTTP_ID` bigint(20) unsigned NOT NULL,
  `HTTP_UID` varchar(20) NOT NULL,
  `HTTP_METHOD` varchar(10) NOT NULL,
  `HTTP_HOST` varchar(255) NOT NULL,
  `HTTP_URI` varchar(255) NOT NULL,
  `HTTP_REFERRER` varchar(255) NOT NULL,
  `HTTP_USERAGENT` varchar(255) NOT NULL,
  `HTTP_REQLEN` smallint(5) unsigned NOT NULL,
  `HTTP_RESPLEN` smallint(5) unsigned NOT NULL,
  `HTTP_STATUSCODE` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `bro_http`
  ADD PRIMARY KEY (`HTTP_ID`);

ALTER TABLE `bro_http`
  MODIFY `HTTP_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT;  
  
DROP TABLE IF EXISTS `bro_ssl`;
CREATE TABLE IF NOT EXISTS `bro_ssl` (
  `SSL_ID` bigint(20) unsigned NOT NULL,
  `SSL_UID` varchar(20) NOT NULL,
  `SSL_VERSION` varchar(15) NOT NULL,
  `SSL_CIPHER` varchar(255) NOT NULL,
  `SSL_SERVER` varchar(255) NOT NULL,
  `SSL_SUBJECT` varchar(255) NOT NULL,
  `SSL_ISSUER` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `bro_ssl`
  ADD PRIMARY KEY (`SSL_ID`),
  ADD KEY `SSL_UID` (`SSL_UID`);

ALTER TABLE `bro_ssl`
  MODIFY `SSL_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT;  
  
DROP TABLE IF EXISTS `bro_x509`;
CREATE TABLE IF NOT EXISTS `bro_x509` (
  `X509_ID` bigint(20) unsigned NOT NULL,
  `X509_FUID` varchar(20) NOT NULL,
  `X509_VERSION` tinyint unsigned NOT NULL,
  `X509_SERIAL` varchar(255) NOT NULL,
  `X509_SUBJECT` varchar(255) NOT NULL,
  `X509_ISSUER` varchar(255) NOT NULL,
  `X509_NOTVALIDBEFORE` timestamp NOT NULL,
  `X509_NOTVALIDAFTER` timestamp NOT NULL,
  `X509_KEYALG` varchar(255) NOT NULL,
  `X509_SIGALG` varchar(255) NOT NULL,
  `X509_KEYTYPE` varchar(255) NOT NULL,
  `X509_KEYLENGTH` smallint unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `bro_x509`
  ADD PRIMARY KEY (`X509_ID`),
  ADD KEY `X509_FUID` (`X509_FUID`);  
  
ALTER TABLE `bro_x509`
  MODIFY `X509_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT; 

DROP TABLE IF EXISTS `passive_dns`;
CREATE TABLE IF NOT EXISTS `passive_dns` (
  `PASSIVE_QUERY` varchar(255) NOT NULL,
  `PASSIVE_ANSWER` varbinary(16) NOT NULL,
  `PASSIVE_FIRSTFOUND` timestamp NOT NULL,
  `PASSIVE_LASTFOUND` timestamp NULL,
  `PASSIVE_COUNT` int unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `passive_dns`
  ADD PRIMARY KEY (`PASSIVE_QUERY`, `PASSIVE_ANSWER`);

CREATE TABLE `test`.`Alexa` ( `Alexa_site` VARCHAR(30) NOT NULL , PRIMARY KEY (`Alexa_site`)) ENGINE = MyISAM;

CREATE TABLE `test`.`exempt_ips` ( `exempt_address` VARBINARY(16) NOT NULL , `exempt_reason` VARCHAR(255) NOT NULL , PRIMARY KEY (`exempt_address`)) ENGINE = MyISAM;
