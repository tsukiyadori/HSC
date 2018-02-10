<?php    
    require_once("MAL/MalUrlBuilder.php");    
    require_once("MAL/MalCurlRequests.php");    
    require_once("MAL/MalAppInfoXmlParser.php");    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
<?php
    
    ///////////////////////////////////
    //// fetch user data demo
    ///////////////////////////////////
    
    $username = 'shina_luna';
    $type='anime';
    $url= MalUrlBuilder::malAppInfoUrl($username, $type);
    $xml = MalCurlRequests::getData($url);   
    $user = MalAppInfoXmlParser::getUserDataFromXml($xml);
    
    //test output
    echo 'test output user data from malappinfo: <br>' ;
    if (NULL !== $user) {
        echo $user->id;
        echo '<br>';
        echo $user->username;    
    }
    else {
        echo 'faulty xml!';
    }
    
    
    $mediaType='anime';
    
    echo '<br><br><br>' ;
    ///////////////////////////////////
    //// fetch started ids from user list entries demo
    ///////////////////////////////////
    
    
    $result1 = MalAppInfoXmlParser::getStartedUserTitleIdsFromXml ($xml, $mediaType); 
    
    echo 'test output started entries from malappinfo: <br>' ;   
    echo '$result1->count = ' . count($result1);
    echo '<pre>'; print_r($result1); echo '</pre>';
    
    
    echo '<br><br><br>' ;
    ///////////////////////////////////
    //// fetch started ids from user list entries demo
    ///////////////////////////////////
    
    
    $result2 = MalAppInfoXmlParser::getStartedUserTitlesFromXml($xml, $mediaType); 
    
    echo 'test output unstarted entries from malappinfo: <br>' ;    
    echo '<pre>'; print_r($result2); echo '</pre>';
    
    
    echo '<br><br><br>' ;            
    ///////////////////////////////////
    //// fetch completed user list entries demo
    ///////////////////////////////////
    
    
    $resultC = MalAppInfoXmlParser::getUserCompletedTitlesFromXml ($xml, $mediaType); 
    
    echo 'test output complete anime entries from malappinfo: <br>' ;    
    echo '<pre>'; print_r($resultC); echo '</pre>';

?>        
        
        
    </body>
</html>
