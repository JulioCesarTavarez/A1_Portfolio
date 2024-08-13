-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema roadKillAllert
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema roadKillAllert
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `roadKillAllert` DEFAULT CHARACTER SET utf8 ;
USE `roadKillAllert` ;

-- -----------------------------------------------------
-- Table `roadKillAllert`.`animal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `roadKillAllert`.`animal` ;

CREATE TABLE IF NOT EXISTS `roadKillAllert`.`animal` (
  `animal_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `animal_type` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`animal_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `roadKillAllert`.`location`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `roadKillAllert`.`location` ;

CREATE TABLE IF NOT EXISTS `roadKillAllert`.`location` (
  `location_id` INT UNSIGNED NOT NULL,
  `langitude` DOUBLE NOT NULL,
  `longitude` DOUBLE NOT NULL,
  PRIMARY KEY (`location_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `roadKillAllert`.`time`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `roadKillAllert`.`time` ;

CREATE TABLE IF NOT EXISTS `roadKillAllert`.`time` (
  `time` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  PRIMARY KEY (`time`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `roadKillAllert`.`hit_animal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `roadKillAllert`.`hit_animal` ;

CREATE TABLE IF NOT EXISTS `roadKillAllert`.`hit_animal` (
  `animal_id` INT UNSIGNED NOT NULL,
  `location_id` INT UNSIGNED NOT NULL,
  `time` INT UNSIGNED NOT NULL,
  `picked_up` INT(1) NOT NULL,
  `hit_animal_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  INDEX `fk_animal_location_location1_idx` (`location_id` ASC) VISIBLE,
  INDEX `fk_animal_location_animal_idx` (`animal_id` ASC) VISIBLE,
  INDEX `fk_animal_location_time1_idx` (`time` ASC) VISIBLE,
  PRIMARY KEY (`hit_animal_id`),
  CONSTRAINT `fk_animal_location_animal`
    FOREIGN KEY (`animal_id`)
    REFERENCES `roadKillAllert`.`animal` (`animal_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_location_location1`
    FOREIGN KEY (`location_id`)
    REFERENCES `roadKillAllert`.`location` (`location_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_location_time1`
    FOREIGN KEY (`time`)
    REFERENCES `roadKillAllert`.`time` (`time`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
