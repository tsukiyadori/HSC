<?php


//TODO: make this a singleton instead of static
class MalUrlBuilder {
    
    public static $rootUrl= 'https://myanimelist.net';


    static function malAppInfoUrl($username, $mediaType){
        $url= self::$rootUrl . '/malappinfo.php?u=' . $username . '&type=' . $mediaType . '&status=all';        
        return $url;
    }  

}