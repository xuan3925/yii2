DROP TABLE IF EXISTS shop_admin;
CREATE TABLE IF NOT EXISTS shop_admin(
  adminId INT UNSIGNED NOT NULL AUTO_INCREMENT,
  adminUser VARCHAR(32) NOT NULL,
  adminPwd CHAR(32) not NULL ,
  adminMail VARCHAR(50) NOT NULL ,
  loginTime INT UNSIGNED NULL  ,
  loginIp INT UNSIGNED NULL ,
  createTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(adminId),
  UNIQUE shop_admin_adminUser_adminPwd(adminUser,adminPwd),
  UNIQUE shop_admin_adminUser_adminMail(adminUser,adminMail)
);
INSERT INTO shop_admin(adminUser,adminPwd,adminMail) VALUES('admin',md5('yiwangai'),'shop@qq.com');

DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE IF NOT EXISTS `shop_category`(
    `cateId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(32) UNIQUE NOT NULL DEFAULT '',
    `parentId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `createTime` INT UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY(`cateId`),
    KEY shop_category_parentId(`parentId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE IF NOT EXISTS `shop_product`(
    `productId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cateId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `title` VARCHAR(200) NOT NULL DEFAULT '',
    `descr` TEXT,
    `num` INT UNSIGNED NOT NULL DEFAULT '0',
    `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    `cover` VARCHAR(200) NOT NULL DEFAULT '',
    `pics` TEXT,
    `isSale` ENUM('0','1') NOT NULL DEFAULT '0',
    `isHot` ENUM('0','1') NOT NULL DEFAULT '0',
    `isTui` ENUM('0','1') NOT NULL DEFAULT '0',
    `saleprice` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    `isOn` ENUM('0','1') NOT NULL DEFAULT '1',
    `createTime` INT UNSIGNED NOT NULL DEFAULT '0',
    KEY shop_product_cateId(`cateId`),
    KEY shop_product_isOn(`isOn`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';
