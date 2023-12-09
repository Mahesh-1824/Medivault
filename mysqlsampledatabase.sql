CREATE DATABASE /*IF NOT EXISTS*/`healthcare`;
USE `healthcare`;

CREATE TABLE `healthcare`.`patient`(
  `userid`   VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL ,
  `phone` VARCHAR(30) NOT NULL ,
  `password` VARCHAR(255) 
  );
CREATE TABLE `healthcare`.`doctor`(
  `userid`   VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL ,
  `phone` VARCHAR(30) NOT NULL ,
  `password` VARCHAR(255) 
  );
CREATE TABLE `healthcare`.`docdoings`(
  `orgid` VARCHAR(50) NOT NULL ,
  `patientid` VARCHAR(50) NOT NULL ,
  `datapdf` MEDIUMBLOB NOT NULL ,
 `whenup` DATE DEFAULT CURRENT_TIMESTAMP,
  `priid` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY(priid)
  );
CREATE TABLE `healthcare`.`addrequests`(
  `orgid` VARCHAR(50) NOT NULL ,
  `orgname` VARCHAR(50) NOT NULL ,
  `patientid` VARCHAR(50) NOT NULL ,
  `requestedon` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `data` MEDIUMBLOB NOT NULL 
);
CREATE TABLE `healthcare`.`patdoings`(
  `patpriid` INT(11) NOT NULL AUTO_INCREMENT,
  `patwhenup` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `patdatapdf` MEDIUMBLOB NOT NULL,
  `patuserid` VARCHAR(50) NOT NULL,
  PRIMARY KEY(patpriid)
);
CREATE TABLE `healthcare`.`accepted_appointments`(
  `patientid` VARCHAR(50) NOT NULL,
  `orgid` VARCHAR(50) NOT NULL
);
CREATE TABLE `healthcare`.`rejected_appointments`(
  `patientid` VARCHAR(50) NOT NULL,
  `orgid` VARCHAR(50) NOT NULL
);
CREATE TABLE `healthcare`.`appointment_requests`(
  `patientname` VARCHAR(50) NOT NULL ,
  `patientid` VARCHAR(50) NOT NULL ,
  `orgid` VARCHAR(50) NOT NULL ,
  `appointment_date` DATE NOT NULL ,
  `priid` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY(priid)
);
INSERT INTO `patient`(`userid`,`username`, `phone`,`password`) VALUES
  ('guy123','guy',  '1234567890', '448ddd517d3abb70045aea6929f02367');

INSERT INTO `doctor`(`userid`,`username`, `phone`,`password`) VALUES
  ('ap123','apollo',  '1234567890', '448ddd517d3abb70045aea6929f02367');

INSERT INTO `appointment_requests`(`patientname`, `patientid`, `orgid`, `appointment_date`, `priid`) VALUES ('guy','guy123','ap123','2022-02-17','1');