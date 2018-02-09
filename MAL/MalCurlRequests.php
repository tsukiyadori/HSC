<?php

//imports

//TODO: make this a singleton instead of static

/**
 * Functionality to get the data from the MAL via CURL
 *
 * @author Luna
 */
class MalCurlRequests {    

    /**
     * Gets the raw data from a given URL without authentication.
     * @param String $url : The request URL
     * @return type The data from the page
     */
    function getData($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $retValue = curl_exec($curl);

        curl_close($curl);

        return $retValue;
    }
   

    //TODO: make more specific methods
    
}

