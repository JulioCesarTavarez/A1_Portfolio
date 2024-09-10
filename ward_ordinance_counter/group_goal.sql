-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema group_goal
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema group_goal
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `group_goal` DEFAULT CHARACTER SET utf8mb3 ;
USE `group_goal` ;

-- -----------------------------------------------------
-- Table `group_goal`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `group_goal`.`user` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `group_goal`.`ordinance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `group_goal`.`ordinance` (
  `ordinance_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `amount` INT NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`ordinance_id`),
  INDEX `fk_ordinance_user_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_ordinance_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `group_goal`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
