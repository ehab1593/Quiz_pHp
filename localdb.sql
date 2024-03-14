-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema localdb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema localdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `localdb` DEFAULT CHARACTER SET utf8 ;
USE `localdb` ;

-- -----------------------------------------------------
-- Table `localdb`.`student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `localdb`.`student` (
  `id` INT NOT NULL,
  `fname` VARCHAR(45) NULL,
  `lname` VARCHAR(45) NULL,
  `pass_hash` VARCHAR(255) NULL,
  `is_admin` TINYINT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`quiz`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `localdb`.`quiz` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `n_questions` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `localdb`.`question` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(4095) NULL,
  `quiz_id` INT NULL,
  `answer_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_question_1_idx` (`quiz_id` ASC),
  CONSTRAINT `fk_question_1`
    FOREIGN KEY (`quiz_id`)
    REFERENCES `localdb`.`quiz` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`answer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `localdb`.`answer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `answer` VARCHAR(4095) NULL,
  `question_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_answer_1_idx` (`question_id` ASC),
  CONSTRAINT `fk_answer_1`
    FOREIGN KEY (`question_id`)
    REFERENCES `localdb`.`question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`student_question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `localdb`.`student_question` (
  `student_id` INT NOT NULL,
  `question_id` INT NOT NULL,
  `answer_id` INT NOT NULL,
  INDEX `fk_student_question_1_idx` (`student_id` ASC),
  INDEX `fk_student_question_2_idx` (`question_id` ASC),
  CONSTRAINT `fk_student_question_1`
    FOREIGN KEY (`student_id`)
    REFERENCES `localdb`.`student` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_question_2`
    FOREIGN KEY (`question_id`)
    REFERENCES `localdb`.`question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`student_quiz`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `localdb`.`student_quiz` (
  `student_id` INT NOT NULL,
  `quiz_id` INT NOT NULL,
  `score` INT NOT NULL,
  INDEX `fk_student_quiz_2_idx` (`quiz_id` ASC),
  CONSTRAINT `fk_student_quiz_1`
    FOREIGN KEY (`student_id`)
    REFERENCES `localdb`.`student` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_quiz_2`
    FOREIGN KEY (`quiz_id`)
    REFERENCES `localdb`.`quiz` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO quiz (name, n_questions) VALUES
('Math', 10),
('Football', 10);