CREATE DATABASE registration;

CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT, 
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255),
    address VARCHAR (255)
);