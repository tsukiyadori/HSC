<?php

//imports
require_once("MAL/MalApiObjectClasses/MalUser.php");


/**
 * Functionality to get the data from the MAL API
 * See documentation here: https://myanimelist.net/modules.php?go=api
 *
 * @author Luna
 */
class MalAppInfoXmlParser {    
    

    /**
     * 
     * @param String $sXML: String as e.g. the data returned by a curl request 
     * @return MalUser Object or null, if the xml was faulty. 
     */
    static function getUserDataFromXml($sXML) {

        //This is to prevent warnings being printed out. 
        //It does so by converting an error into an exception, hence 
        //you can use catch handling. The handling here consists of 
        //returning NULL;
        set_error_handler(function($errno, $errstr) {
            throw new Exception($errstr, $errno);
        });

        try {
            $oXML = new SimpleXMLElement($sXML);   
        } catch (Exception $e) {
            restore_error_handler();
            return NULL;
        }

        $numNodes = $oXML->count();        
        if (1 >= $numNodes) {                      
            return NULL;
        }
        else {
            $user = new MalUser();
            $myinfo = $oXML->myinfo;
            $user->id = $myinfo->user_id;
            $user->username = $myinfo->user_name;
            return $user;       
        }        
    }
    
    /**
     * Get all completed media entries of a user list
     * @param String $sXML XML Data as a String
     * @param MediaType $mediaType either 'anime' or 'manga'     
     * @return List of MediaEntry objects.
     */
    static function getUserCompletedTitlesFromXml($sXML, $mediaType) {
        return self::getUserTitlesFromXml($sXML, $mediaType, '2');
    }
    
    /**
     * Get a list of MediaEntries fitting the given criteria.     
     * @param String $sXML XML Data as a String
     * @param MediaType $mediaType either 'anime' or 'manga'
     * @param String $status watching/ongoing/completed (2), ptw.
     * @return List of MediaEntry objects.
     */
    static function getUserTitlesFromXml($sXML, $mediaType, $status) {

        //This is to prevent warnings being printed out. 
        //It does so by converting an error into an exception, hence 
        //you can use catch handling. The handling here consists of 
        //returning NULL;
        set_error_handler(function($errno, $errstr) {
            throw new Exception($errstr, $errno);
        });

        try {
            $oXML = new SimpleXMLElement($sXML);   
        } catch (Exception $e) {
            restore_error_handler();
            return NULL;
        }

        $numNodes = $oXML->count();        
        if (1 >= $numNodes) {                      
            return NULL;
        }
        else {
            $mediaNodes = $oXML->xpath('(//myanimelist/'. $mediaType . '[my_status = "' . $status . '"])');             
            
            //TODO: result=new list of mediaEntry objects
            $result = $mediaNodes;
            
            foreach ($mediaNodes as $item)
               {
                   //TODO: Create MalMediaEntry objects and put them in the result list            
               }
               
               //TODO: Make an ordered list out of it.           

            return $result;       
        }        
    }
       
    
    

}

