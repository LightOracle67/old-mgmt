/* DATABASE STORE FOR ADEM+ UI WEB MGMT*/
DROP DATABASE IF EXISTS store;
DROP user IF EXISTS 'store'@'localhost';
DROP user IF EXISTS 'store'@'%';
CREATE USER `store`@`localhost` IDENTIFIED VIA mysql_native_password USING '*D44415B0880D91F2E9836ADD091D50E3E4B7D8A2';
GRANT SELECT,
    INSERT,
    UPDATE,
    DELETE,
    FILE ON *.* TO 'store' @'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
CREATE DATABASE IF NOT EXISTS `store`;
USE store;
GRANT ALL PRIVILEGES ON `store`.* TO 'store' @'%';
/*LOCALES TABLE*/
DROP TABLE IF EXISTS locales;
CREATE TABLE `store`.`locales` (
    localeid INT UNSIGNED NOT NULL AUTO_INCREMENT,
    localetextid varchar(10) not null,
    `localecountry` VARCHAR(100) NOT NULL,
    storename varchar(100) not null,
    currency varchar(1) not null,
    selected boolean unique,
    PRIMARY KEY (localeid)
) ENGINE = InnoDB;
INSERT INTO `locales` (
        `localeid`,
        `localetextid`,
        `localecountry`,
        `storename`,
        `currency`,
        `selected`
    )
VALUES ('', 'en-GB', 'Britain', 'Store Name', '£', '1'),
(
        '',
        'es-ES',
        'España',
        'Nombre del Negocio',
        '€',
        '0'
    );
/*USERS TABLE*/
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `userid` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(20) NOT NULL UNIQUE,
    `realname` varchar(50) NOT NULL,
    `password` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
INSERT INTO users
VALUES (
        '',
        'administrator',
        'System Administrator for Web Management',
        '136673bea9d4d1134c0258388a5eb56b2afbf56b149aae4fc77805e2f7adf48a072ebeb735a477ec5968f7504b25a560a6f5f270e8d97f6665f49ba28170ab76'
    );
/*PRODUCTS TABLE*/
DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products(
    prodid int UNSIGNED not null auto_increment PRIMARY KEY,
    realid int not null unique,
    prodname varchar(30) not null,
    fullname varchar(70) not null,
    proddesc varchar(200) not null,
    dateadded date not null,
    price float (10, 2) not null,
    class int UNSIGNED not null,
    type int UNSIGNED not null,
    image varchar(50)
);
/*CLASSLIST TABLE*/
DROP TABLE IF EXISTS classlist;
CREATE TABLE IF NOT EXISTS classlist(
    classid int UNSIGNED not null auto_increment PRIMARY KEY,
    classname varchar(30) UNIQUE,
    ivaperclass int UNSIGNED not null
);
/*TYPELIST TABLE*/
DROP TABLE IF EXISTS typelist;
CREATE TABLE IF NOT EXISTS typelist(
    typeid int UNSIGNED not NULL auto_increment PRIMARY KEY,
    typename varchar(50) not null UNIQUE
);
/*IVAS TABLE*/
DROP TABLE IF EXISTS ivas;
CREATE TABLE IF NOT EXISTS ivas(
    ivaid int UNSIGNED not null auto_increment PRIMARY KEY,
    ivatype varchar(30) not null UNIQUE,
    ivaperc int not null
);
INSERT INTO ivas
VALUES ('', 'General', 21),
    ('', 'Reduced', 10),
    ('', 'Reduced+', 4),
    ('', 'Exempt', 0);
/*INVOICES TABLE*/
DROP TABLE IF EXISTS invoices;
CREATE TABLE IF NOT EXISTS invoices(
    invoiceid int UNSIGNED AUTO_INCREMENT not null PRIMARY KEY,
    invoicedate datetime not null,
    userid int UNSIGNED not null
);
/*DETAILINVOICE TABLE*/
DROP TABLE IF EXISTS detailinvoice;
CREATE TABLE IF NOT EXISTS detailinvoice(
    invoiceid int UNSIGNED not null,
    prodid int UNSIGNED not null,
    price float(10, 2),
    quantity int not null,
    checkout float(10, 2) not null,
    checkoutplusiva float(10, 2) not null
);
alter table detailinvoice drop constraint if EXISTS PK_detailinvoice;
alter table detailinvoice
add constraint PK_detailinvoice PRIMARY KEY (invoiceid, prodid);
/*DISCOUNTVOUCHERS TABLE*/
DROP TABLE IF EXISTS discountvouchers;
CREATE TABLE IF NOT EXISTS discountvouchers(
    vouchid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    voucher TEXT NOT NULL UNIQUE,
    vouchpercent FLOAT NOT NULL,
    creationdate DATE NOT NULL,
    finaldate DATE NOT NULL
);
DELETE FROM discountvouchers;
alter table discountvouchers AUTO_INCREMENT = 0;
/*INVOICEDISCOUNT TABLE*/
DROP TABLE IF EXISTS invoicediscount;
CREATE TABLE IF NOT EXISTS invoicediscount(
    invoiceid int UNSIGNED not null PRIMARY KEY,
    vouchid int UNSIGNED null UNIQUE
);
/*FOREIGN KEYS*/
ALTER TABLE detailinvoice DROP constraint IF EXISTS FK_DINV_INVID_INVS_INVID;
ALTER TABLE detailinvoice DROP constraint IF EXISTS FK_DINV_PRID_PRDCTS_PRID;
ALTER TABLE detailinvoice
add constraint FK_DINV_INVID_INVS_INVID FOREIGN KEY (invoiceid) REFERENCES invoices(invoiceid) ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE detailinvoice
ADD constraint FK_DINV_PRID_PRDCTS_PRID FOREIGN KEY (prodid) REFERENCES PRODUCTS(prodid) ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE PRODUCTS DROP constraint IF EXISTS FK_PRDCTS_CLSS_CLSSS_CLSSID;
ALTER TABLE PRODUCTS DROP constraint IF EXISTS FK_PRDCTS_TYPE_TYPES_TYPEID;
ALTER TABLE classlist DROP constraint IF EXISTS FK_IVAID_IVAS_IVAID;
ALTER TABLE PRODUCTS
ADD constraint FK_PRDCTS_CLSSID_CLSSS_CLSSID FOREIGN KEY (class) REFERENCES classlist(classid) ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE PRODUCTS
ADD constraint FK_PRDCTS_TYPEID_TYPES_TYPEID FOREIGN KEY (type) REFERENCES typelist(typeid) ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE classlist
ADD constraint FK_IVAID_IVAS_IVAID FOREIGN KEY (ivaperclass) REFERENCES ivas(ivaid) ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE invoices DROP constraint IF EXISTS FK_USRID_USRS_USRID;
ALTER TABLE invoices
ADD constraint FK_USRID_USRS_USRID FOREIGN KEY (userid) REFERENCES users(userid) ON UPDATE CASCADE ON DELETE NO ACTION;