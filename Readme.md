# Readme

## Query to create 'user' table
`CREATE TABLE user(id int NOT NULL AUTO_INCREMENT, name varchar(50) NOT NULL, username varchar(150) NOT NULL, email varchar(100) NOT NULL UNIQUE, password varchar(40) NOT NULL, gender varchar(10), about text NOT NULL, image text, PRIMARY KEY(id));`

## Query to create 'post' table
`CREATE TABLE post(pid int NOT NULL AUTO_INCREMENT, uid int NOT NULL, title text, post text, likes int, state varchar(10), PRIMARY KEY(pid));`
