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
     * Return a SimpleXMLElement repesentation from XML data.
     * @param String $sXML: String as e.g. the data returned by a curl request 
     * @return null if faulty xml or a SimpleXMLElement representation
     */
    static function getAllNodesFromXml($sXML) {
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
        return $oXML;
     }
        
 
    /**
     * Checks if the XML object has been faulty or has no data.
     * @param type $oXML SimpleXMLElement representation of the XML
     * @return boolean true if the $oXML is null or it has no nodes
     */
    static function isNullOrHasNoData($oXML) {
        $result = false;
        if (null == $oXML) {
            $result = true;
        } else {
            $numNodes = $oXML->count();        
            if (1 >= $numNodes) {                      
                $result = true;
            }  
        }        
        return $result;        
    }
    
    /**
     * 
     * @param String $sXML: String as e.g. the data returned by a curl request 
     * @return MalUser Object or null, if the xml was faulty. 
     */
    static function getUserDataFromXml($sXML) {

        $oXML = self::getAllNodesFromXml($sXML);

        if (!self::isNullOrHasNoData($oXML)) {
            $user = new MalUser();
            $myinfo = $oXML->myinfo;
            $user->id = $myinfo->user_id;
            $user->username = $myinfo->user_name;
            return $user;                   
        } else {
            return NULL;
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

        $oXML = self::getAllNodesFromXml($sXML);
        
        if (!self::isNullOrHasNoData($oXML)) {
            $mediaNodes = $oXML->xpath('(//myanimelist/'. $mediaType . '[my_status = "' . $status . '"])');             
            $result = self::extractToMediaTitles($mediaNodes);
            return $result;                   
        } else {
            return NULL;
        }                
    }
       

    /**
     * Get all titles from a list that the user has already started.
     * @param type $sXML
     * @param type $mediaType
     * @return type
     */
    static function getStartedUserTitleIdsFromXml($sXML, $mediaType) {

        $oXML = self::getAllNodesFromXml($sXML);                
        if (!self::isNullOrHasNoData($oXML)) {
            
            $path = ($mediaType == 'anime') ? 'my_watched_episodes' : 'my_read_volumes';
            $mediaNodes = $oXML->xpath('(//myanimelist/'. $mediaType . '[not(' . $path . ' = "0")])');                           
            $result = self::extractToIdList($mediaNodes, $mediaType);
            return $result;                   
        } else {
            return NULL;
        }                
    }      
    
    /**
     * Get all titles from a list that the user has already started.
     * @param type $sXML
     * @param type $mediaType
     * @return type
     */
    static function getStartedUserTitlesFromXml($sXML, $mediaType) {

        $oXML = self::getAllNodesFromXml($sXML);                
        if (!self::isNullOrHasNoData($oXML)) {
            
            $path = ($mediaType == 'anime') ? 'my_watched_episodes' : 'my_read_volumes';
            $mediaNodes = $oXML->xpath('(//myanimelist/'. $mediaType . '[not(' . $path . ' = "0")])');                           
            $result = self::extractToMediaTitles($mediaNodes);
            return $result;                   
        } else {
            return NULL;
        }                
    }    
   
    /**
     * creates an (unordered) list of MediaTypes from given XML nodes.
     * @param type $mediaNodes e.g. nodes returned after xpath filtering
     * @return type TODO
     */
    static function extractToMediaTitles($mediaNodes) {
        if (null == $mediaNodes) {
            return NULL;
        }
        else {
            $result = $mediaNodes;
            foreach ($mediaNodes as $item) {
                //TODO: Create MalMediaEntry objects and put them in the result list            
            }
            return $result;         
        }
        
    }
    
    
      /**
     * creates an (unordered) list of id from given media title XML nodes.
     * @param type $mediaNodes e.g. nodes returned after xpath filtering
     * @return Array of IDs as Strings, null if nodes were faulty
     */
    static function extractToIdList($mediaNodes, $mediaType) {
        if (null == $mediaNodes) {
            return NULL;
        }
        else {
            $result = [];
            $path = ($mediaType == 'anime') ? 'series_animedb_id' : 'series_mangadb_id';
            foreach ($mediaNodes as $item) {
                $result[] = $item->$path;                
            }
            return $result;         
        }
        
    }
    
    
}

