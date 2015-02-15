# Readme

## Query to create 'user' table
`CREATE TABLE user(id int NOT NULL AUTO_INCREMENT, name varchar(50) NOT NULL, username varchar(150) NOT NULL, email varchar(100) NOT NULL UNIQUE, password varchar(40) NOT NULL, gender bool, about text NOT NULL, image text, PRIMARY KEY(id));`
