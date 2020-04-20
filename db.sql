

CREATE TABLE user
(
    uid INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(25) NOT NULL,
    token_id VARCHAR(50)

);

CREATE TABLE chatlog
(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    sent_by VARCHAR(50),
    usr_id INT(11) NOT NULL,
    usr_name VARCHAR(25) NOT NULL,
    date_created INT(11)
);

    

   