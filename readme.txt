# CPSC431 Assignment 3 php-chat-app

Alex Tran CWID#891297442 quyen137@csu.fullerton.edu

Huy Ho CWID#889427381 hho114@csu.fullerton.edu

## Work distribution
Alex   
    - Comment, Documentation, Deployment and Testing
Huy 
    - Creating logout function for User
    - Successfully implement visible function to all other user, randomly assigned colorr as background
    - Implement user identified by name

## Function
    - Huy implemented a Logout function which will logout a user that inputed his/her name
    - It will redirect user to fullerton.edu website once user logout.

## Problem
    - None
---------------------------------------------------------------------------------------
			                chat.php file contents
---------------------------------------------------------------------------------------

<?php
session_start();
ob_start();
header("Content-type: application/json");
date_default_timezone_set('UTC');
//connect to database
$db = mysqli_connect('mariadb', 'cs431s41', 'Haiph1ch' ,'cs431s41');

if (mysqli_connect_errno()) {
    echo '<p>Error: Could not connect to database.<br/>
   Please try again later.</p>';
    exit;
}

//Implement session based on user input name
if (!isset($_SESSION['name'])) {

    header("Location: http://ecs.fullerton.edu/~cs431s41/assignment3/index.php");
}

//helper funtion to replace get_results() if without mysqlnd 
function get_result($Statement)
{
    $RESULT = array();
    $Statement->store_result();
    for ($i = 0; $i < $Statement->num_rows; $i++) {
        $Metadata = $Statement->result_metadata();
        $PARAMS = array();
        while ($Field = $Metadata->fetch_field()) {
            $PARAMS[] = &$RESULT[$i][$Field->name];
        }
        call_user_func_array(array($Statement, 'bind_result'), $PARAMS);
        $Statement->fetch();
    }
    return $RESULT;
}

try {
    $currentTime = time();

    $session_id = session_id();
    $lastPoll = isset($_SESSION['last_poll']) ? $_SESSION['last_poll'] : $currentTime;
    $action = isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST') ? 'send' : 'poll';
    switch ($action) {
        case 'poll':
            $query = "SELECT id, message, sent_by, usr_id ,usr_name, date_created FROM chatlog WHERE date_created >= " . $lastPoll;
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($id, $message, $sent_by, $usr_id, $usr_name, $date_created);
            $result = get_result($stmt);
            $newChats = [];
            while ($chat = array_shift($result)) {

                if ($session_id == $chat['sent_by']) {
                    $chat['sent_by'] = 'self';
                } else {
                    $chat['sent_by'] = 'other';
                }

                $newChats[] = $chat;
            }

            $_SESSION['last_poll'] = $currentTime;

            print json_encode([
                'success' => true,
                'messages' => $newChats
            ]);
            exit;
        case 'send':
            $message = isset($_POST['message']) ? $_POST['message'] : '';
            $message = strip_tags($message);
            $query = "INSERT INTO chatlog (message, sent_by, usr_id, usr_name, date_created) VALUES(?, ?, ?, ?,?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('ssisi', $message,  $session_id, $_SESSION['uid'], $_SESSION['name'], $currentTime);
            $stmt->execute();
            print json_encode(['success' => true]);
            exit;
    }
} catch (Exception $e) {
    print json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

?>