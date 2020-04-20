# CPSC431 Assignment 3 php-chat-app

Alex Tran CWID#891297442 quyen137@csu.fullerton.edu

Huy Ho CWID#889427381 hho114@csu.fullerton.edu

## Overview

This is simple chat application which implement php, mysql and ajax to show basic knowledges and practices for web developement

## How to use

### Create database

Use sql script in db.sql to create database in mysql

```sql
CREATE TABLE user
(
    uid INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(25) NOT NULL,
    token_id VARCHAR(50)

);

CREATE TABLE chatlog
(
    id INT(11)
    AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    sent_by VARCHAR(50),
    usr_id INT(11) NOT NULL,
    usr_name VARCHAR(25) NOT NULL,
    date_created INT(11)
);
```

Note: This is simple database, remodify to enhance your security and better structure


### Edit link route

Modify route for application base on your server link, there are total three files need to be modified: index.php, chat.php, and logout.php

For example: In index.php you can change header location to http://your_server_name/application_directory/chat.html

```php

	header("Location: http://ecs.fullerton.edu/~cs431s42/assignment3/chat.html");

```


