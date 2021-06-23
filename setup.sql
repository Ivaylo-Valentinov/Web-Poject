DROP DATABASE IF EXISTS `bookaloo`;

CREATE DATABASE `bookaloo`;

CREATE TABLE `bookaloo`.`users` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `username` VARCHAR(255) NOT NULL , 
  `password` VARCHAR(255) NOT NULL , 
  `email` VARCHAR(255) NOT NULL , 
  `checked_count` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`), 
  UNIQUE `username_unique` (`username`)
) ENGINE = InnoDB;

CREATE TABLE `bookaloo`.`books` ( 
  `id` INT NOT NULL AUTO_INCREMENT , 
  `title` VARCHAR(255) NOT NULL ,
  `author` VARCHAR(255) NOT NULL ,
  `description` TEXT NOT NULL ,
  `count` INT NOT NULL ,
  `type` VARCHAR(255) NOT NULL ,
  `link` VARCHAR(255) NOT NULL ,
  `checkout_amount` INT NOT NULL DEFAULT 0 ,
  `total_checkout_amount` INT NOT NULL DEFAULT 0 ,
  `image` VARCHAR(255) ,
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


INSERT INTO bookaloo.users(username, password, email) VALUES("default", "$2y$10$4TpX1PPWyjF2tVNlXLG6W.DVGwd3G9wSkJo9tm3clCOIMUfdLWObu", "default@email.com");
INSERT INTO bookaloo.users(username, password, email) VALUES("default2", "$2y$10$4TpX1PPWyjF2tVNlXLG6W.DVGwd3G9wSkJo9tm3clCOIMUfdLWObu", "default@email.com");
INSERT INTO bookaloo.books(title, author, description, count, type, link) VALUES("Book 1", "Book Author 1", "Book Description 1", 1, "book", "placeholder_link");
INSERT INTO bookaloo.books(title, author, description, count, type, link) VALUES("Book 2", "Book Author 2", "Book Description 2", 1, "book", "placeholder_link");
INSERT INTO bookaloo.books(title, author, description, count, type, link) VALUES("Book 3", "Book Author 3", "Book Description 3", 1, "book", "placeholder_link");

INSERT INTO bookaloo.books(title, author, description, count, type, link) VALUES("Ref 1", "Ref Author 1", "Ref Description 1", 1, "ref", "placeholder_link");
INSERT INTO bookaloo.books(title, author, description, count, type, link) VALUES("Ref 2", "Ref Author 2", "Ref Description 2", 1, "ref", "placeholder_link");
INSERT INTO bookaloo.books(title, author, description, count, type, link) VALUES("Ref 3", "Ref Author 3", "Ref Description 3", 1, "ref", "placeholder_link");
