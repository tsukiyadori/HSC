<?php

//imports
require_once("MAL/MalApiObjectClasses/MalUser.php");


//TODO: make this a singleton instead of static


/**
 * Functionality to get the data from the MAL API
 * See documentation here: https://myanimelist.net/modules.php?go=api
 *
 * @author Luna
 */
class MalAPIXmlParser {

    /**
     * 
     * @param String $sXML: String as e.g. the data returned by a curl request 
     * @return MalUser Object or null, if the xml was faulty. 
     */
    static function getUserDataFromXml($sXML ) {

        //This is to prevent warnings being printed out. 
        //It does so by converting an error into an exception, hence 
        //you can use catch handling. The handling here consists of 
        //returning NULL;
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            throw new Exception($errstr, $errno);
        });

        try {
            $oXML = new SimpleXMLElement($sXML);   
        } catch (Exception $e) {
            restore_error_handler();
            return NULL;
        }

        $numNodes = $oXML->count();
        if (2 != $numNodes) {            
            echo 'too many nodes!!';
            return NULL;
        }
        else {            
            $user = new MalUser();
            $user->id = $oXML->id;
            $user->username = $oXML->username;

            return $user;                        
        }
    }

}

