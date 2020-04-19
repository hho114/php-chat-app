



CREATE TABLE chatlog
(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    sent_by VARCHAR(50),
    date_created INT(11)
    );

    CREATE TABLE relational_user_chat
    (
        chat_id INT(11),
        user_id INT(11)

    );

    CREATE TABLE user
    (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nickname VARCHAR(25) NOT NULL
    );    