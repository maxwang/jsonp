<?php

namespace Api;

class Controller_Address_Addressify extends \Controller_Rest
{
    static private $api_key;
    static private $url = 'http://api.addressify.com.au/address/';
    
    public function before()
    {
        parent::before();
        
        \Config::load('api::addressify','addressify');
        self::$api_key = \Config::get('addressify.api_key', '');
        
    }
    
        
   
    
    //jsonp server side
    public function get_autoCompleteP($term)
    {
        
        $this->response->set_header("Access-Control-Allow-Origin", "*");
        $this->response->set_header("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
        $this->response->set_header("Content-Type", "application/json");
        $this->format = 'jsonp';
        
        $url = self::$url.'autoComplete?api_key='.self::$api_key.'&term='.urlencode($term);
        
        return $this->response(json_decode($this->get_url_content($url)), 200);
        
    }
    
    
    private function get_url_content($url)
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        $result = curl_exec($ch);
        
        curl_close($ch);
        
        return $result;
    }
}
