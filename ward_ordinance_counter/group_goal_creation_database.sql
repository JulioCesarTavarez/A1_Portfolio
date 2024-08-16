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
CREATE SCHEMA IF NOT EXISTS `group_goal` DEFAULT CHARACTER SET utf8 ;
USE `group_goal` ;

-- -----------------------------------------------------
-- Table `group_goal`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `group_goal`.`user` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `phone_number` INT(10) NULL,
  `name` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `group_goal`.`group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `group_goal`.`group` (
  `group_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_name` VARCHAR(45) NOT NULL,
  `group_code` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`group_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `group_goal`.`goal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `group_goal`.`goal` (
  `group_id` INT UNSIGNED NOT NULL,
  `goal_name` VARCHAR(45) NOT NULL,
  `times_done` INT NOT NULL,
  INDEX `fk_goal_group1_idx` (`group_id` ASC) VISIBLE,
  CONSTRAINT `fk_goal_group1`
    FOREIGN KEY (`group_id`)
    REFERENCES `group_goal`.`group` (`group_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `group_goal`.`goal_completions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `group_goal`.`goal_completions` (
  `user_id` INT UNSIGNED NOT NULL,
  `goal_completions_id` VARCHAR(45) NOT NULL,
  INDEX `fk_goal_completions_user1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`goal_completions_id`),
  CONSTRAINT `fk_goal_completions_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `group_goal`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `group_goal`.`user_group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `group_goal`.`user_group` (
  `user_to_group_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `group_id` INT UNSIGNED NOT NULL,
  INDEX `fk_user_group_group1_idx` (`group_id` ASC) VISIBLE,
  INDEX `fk_user_group_user1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`user_to_group_id`),
  CONSTRAINT `fk_user_group_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `group_goal`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_group1`
    FOREIGN KEY (`group_id`)
    REFERENCES `group_goal`.`group` (`group_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
