-- MySQL Script generated by MySQL Workbench
-- Thu Sep 21 11:22:24 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`user` ;

CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `USERNAME` VARCHAR(25) NOT NULL,
  `USER_PWD` VARCHAR(50) NOT NULL,
  `IS_ACTIVATED` TINYINT(1) NOT NULL,
  `IS_ADMIN` TINYINT(1) NOT NULL,
  `USER_CREATED` DATE NOT NULL,
  `USER_BIO` VARCHAR(500) NULL DEFAULT NULL,
  `USER_LAST_CONNECTION` DATE NOT NULL,
  `USER_DISPLAY_NAME` VARCHAR(25) NULL,
  PRIMARY KEY (`USERNAME`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mydb`.`post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`post` ;

CREATE TABLE IF NOT EXISTS `mydb`.`post` (
  `ID` INT NOT NULL,
  `TITLE` VARCHAR(100) NULL DEFAULT NULL,
  `CONTENT` VARCHAR(1000) NULL DEFAULT NULL,
  `USER_ID` VARCHAR(25) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_0900_ai_ci' NOT NULL,
  `DATE_POSTED` DATE NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `FK1_POST` (`USER_ID` ASC) VISIBLE,
  CONSTRAINT `FK1_POST`
    FOREIGN KEY (`USER_ID`)
    REFERENCES `mydb`.`user` (`USERNAME`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mydb`.`topic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`topic` ;

CREATE TABLE IF NOT EXISTS `mydb`.`topic` (
  `ID` INT NOT NULL,
  `NAME` VARCHAR(25) NOT NULL,
  `INFO` INT NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mydb`.`belongs_to`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`belongs_to` ;

CREATE TABLE IF NOT EXISTS `mydb`.`belongs_to` (
  `POST_ID` INT NOT NULL,
  `TOPIC_ID` INT NOT NULL,
  PRIMARY KEY (`POST_ID`, `TOPIC_ID`),
  INDEX `FK2_BELONGS_TO` (`TOPIC_ID` ASC) VISIBLE,
  CONSTRAINT `FK1_BELONGS_TO`
    FOREIGN KEY (`POST_ID`)
    REFERENCES `mydb`.`post` (`ID`),
  CONSTRAINT `FK2_BELONGS_TO`
    FOREIGN KEY (`TOPIC_ID`)
    REFERENCES `mydb`.`topic` (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mydb`.`comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`comment` ;

CREATE TABLE IF NOT EXISTS `mydb`.`comment` (
  `COMMENT_ID` INT NOT NULL,
  `CONTENT` VARCHAR(500) NOT NULL,
  `DATE_POSTED` DATE NOT NULL,
  `POST_ID` INT NOT NULL,
  `USER_ID` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`COMMENT_ID`),
  INDEX `FK1_COMMENT` (`POST_ID` ASC) VISIBLE,
  INDEX `FK2_COMMENT` (`USER_ID` ASC) VISIBLE,
  CONSTRAINT `FK1_COMMENT`
    FOREIGN KEY (`POST_ID`)
    REFERENCES `mydb`.`post` (`ID`),
  CONSTRAINT `FK2_COMMENT`
    FOREIGN KEY (`USER_ID`)
    REFERENCES `mydb`.`user` (`USERNAME`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mydb`.`favorites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`favorites` ;

CREATE TABLE IF NOT EXISTS `mydb`.`favorites` (
  `POST_ID` INT NOT NULL,
  `USER_ID` VARCHAR(25) NOT NULL,
  `DATE_FAV` DATE NOT NULL,
  PRIMARY KEY (`POST_ID`, `USER_ID`),
  INDEX `FK2_FAVORITES` (`USER_ID` ASC) VISIBLE,
  CONSTRAINT `FK1_FAVORITES`
    FOREIGN KEY (`POST_ID`)
    REFERENCES `mydb`.`post` (`ID`),
  CONSTRAINT `FK2_FAVORITES`
    FOREIGN KEY (`USER_ID`)
    REFERENCES `mydb`.`user` (`USERNAME`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mydb`.`follows`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`follows` ;

CREATE TABLE IF NOT EXISTS `mydb`.`follows` (
  `UN_FOLLOWER` VARCHAR(25) NOT NULL,
  `UN_FOLLOWED` VARCHAR(25) NOT NULL,
  `SINCE_WHEN` DATE NOT NULL,
  PRIMARY KEY (`UN_FOLLOWER`, `UN_FOLLOWED`),
  INDEX `FK2_FOLLOWS` (`UN_FOLLOWED` ASC) VISIBLE,
  CONSTRAINT `FK1_FOLLOWS`
    FOREIGN KEY (`UN_FOLLOWER`)
    REFERENCES `mydb`.`user` (`USERNAME`),
  CONSTRAINT `FK2_FOLLOWS`
    FOREIGN KEY (`UN_FOLLOWED`)
    REFERENCES `mydb`.`user` (`USERNAME`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mydb`.`likes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`likes` ;

CREATE TABLE IF NOT EXISTS `mydb`.`likes` (
  `POST_ID` INT NOT NULL,
  `USER_ID` VARCHAR(25) NOT NULL,
  `DATE_LIKE` DATE NOT NULL,
  PRIMARY KEY (`POST_ID`, `USER_ID`),
  INDEX `FK2_LIKES` (`USER_ID` ASC) VISIBLE,
  CONSTRAINT `FK1_LIKES`
    FOREIGN KEY (`POST_ID`)
    REFERENCES `mydb`.`post` (`ID`),
  CONSTRAINT `FK2_LIKES`
    FOREIGN KEY (`USER_ID`)
    REFERENCES `mydb`.`user` (`USERNAME`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
