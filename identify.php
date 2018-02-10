<!DOCTYPE html>
<html>
    <body>
        
        <?php
        require_once("Includes/DatabaseRepository.php");

        $userID = DatabaseRepository::getInstance()->get_user_id_by_name($_GET['username']);
        if (!$userID) {
            header('Location: register.php?username=' . $_GET['username']);            
        } else {
            session_start();
            $_SESSION['user_id'] = $userID;
            $_SESSION['user_name'] = $_GET['username'];
            header('Location: index.php');
        }
        
        ?>
    </body>
</html>