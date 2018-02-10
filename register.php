<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            if ($_GET['username']) {
                echo 'User ' . $_GET['username'] . ' could not be found. Please check the spelling and try again.'; 
                echo '<br> TODO: Prefilled form';
            } else {
                echo 'TODO empty register Form';                
            }
        
        ?>
    </body>
</html>
