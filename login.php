<?php
    require_once("Includes/DatabaseRepository.php");

    //if user is already logged in redirect to index page
    session_start();
    if ($_SESSION['user_id'] ) {
        header('Location: index.php');
        exit;  
    } 
        
    $userIdentified = false;
    // verify user's credentials
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $userIdentified = (Database::getInstance()->get_user_id_by_name($_POST['user']));
        echo $userIdentified ;
        if ($userIdentified == true) {
            session_start();
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['id'] = $userIdentified["id"];        
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Identify with your MAL User</title>
    </head>
    <body>
        
        <form action="identify.php" method="GET" name="username">
            Your MAL Username: <input type="text" name="username"/>
            <input type="submit" value="Go" />
        </form>        
    </body>
</html>
