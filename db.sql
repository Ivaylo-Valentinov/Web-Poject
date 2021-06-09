DROP DATABASE IF EXISTS `bookaloo`;

CREATE DATABASE `bookaloo`;

CREATE TABLE `bookaloo`.`users` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `username` VARCHAR(255) NOT NULL , 
  `password` VARCHAR(255) NOT NULL , 
  `email` VARCHAR(255) NOT NULL , 
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `bookaloo`.`books` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `title` VARCHAR(255) NOT NULL ,
  `author` VARCHAR(255) NOT NULL ,
  `description` TEXT NOT NULL ,
  `count` INT NOT NULL ,
  `type` VARCHAR(255) NOT NULL ,
  `link` VARCHAR(255) NOT NULL ,
  `cover` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `bookaloo`.`taken_books` (
  `id` INT NOT NULL AUTO_INCREMENT , 
  `user_id` INT NOT NULL , 
  `book_id` INT NOT NULL , 
  `expiration_date` DATE NOT NULL , 
  `checkout_date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`book_id`) REFERENCES books(`id`)
) ENGINE = InnoDB;

CREATE TABLE `bookaloo`.`tokens` (
  `id` INT NOT NULL AUTO_INCREMENT , 
  `user_id` INT NOT NULL , 
  `token`  VARCHAR(255) NOT NULL ,
  `expiration_date` DATE NOT NULL , 
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE = InnoDB;


INSERT INTO bookaloo.users(username, password, email) VALUES("default", "default", "default@email.com")
