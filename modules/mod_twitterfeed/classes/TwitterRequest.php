<?php

/**
 * Class to connect and retrieve a Twitter feed
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2011 - 2015
 * @package    XirtCMS
 */
class TwitterRequest {

   /**
    * Indicates whether authentication was done or not
    * @var boolean
    */
   var $_authenticated = false;


   /**
    * Creates a new TwitterRequest instance (incl. access token)
    *
    * @param $consumerKey The consumer key to use
    * @param $consumerSecret The consumer secret to use
    */
   function __construct($consumerKey, $consumerSecret) {

      $this->_consumerKey = $consumerKey;
      $this->_consumerSecret = $consumerSecret;
      $this->_createToken();

   }


   /**
    * Creates a internal token based on the provides consumer key/secret
    */
   private function _createToken() {

      $key = urlencode($this->_consumerKey);
      $secret = urlencode($this->_consumerSecret);
      $this->_token = base64_encode($key . ":" . $secret);

   }


   /**
    * Performs a search on a Twitter feed with the given query
    *
    * @param String $query The query for the search
    * @return mixed|boolean The result on success, false otherwise
    */
   public function search($query) {

      if (!$this->_authenticated) {
         $this->_authenticate();
      }

      return $this->_request(
         "https://api.twitter.com/1.1/search/tweets.json?q=" . $query,
         array (
            "GET /1.1/search/tweets.json?q=" . urlencode($query) . " HTTP/1.1",
            "Host: api.twitter.com",
            "Authorization: Bearer " . $this->_accessCode
         )
      );

   }


   /**
    * Attempts to authenticate with Twitter
    */
   private function _authenticate() {

      $url = "https://api.twitter.com/oauth2/token";
      $headers = array (
         "POST /oauth2/token HTTP/1.1",
         "Host: api.twitter.com",
         "Authorization: Basic " . $this->_token,
         "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
      );

      $ch = curl_init();
      curl_setopt_array($ch, array(
         CURLOPT_HTTPHEADER => $headers,
         CURLOPT_POSTFIELDS => "grant_type=client_credentials",
         CURLOPT_USERPWD => $this->_consumerKey . ":" . $this->_consumerSecret,
         CURLOPT_HEADER => false,
         CURLOPT_POST => true,
         CURLOPT_RETURNTRANSFER => 1,
         CURLOPT_URL => $url
      ));

      $data = json_decode(curl_exec($ch));
      if (!$error = curl_error($ch)) {

         curl_close($ch);
         $this->_accessCode = $data->access_token;
         return ($this->_authenticated = true);

      }

      trigger_error("[cURL] " . curl_error($ch), E_USER_WARNING);

      curl_close($ch);
      return false;

   }


   /**
    * Attempts to connect to Twitter using cURL
    *
    * @param String $url The URL to connect to (e.g. the request target)
    * @param Array $headers The headers to send in the request
    * @return mixed|boolean The result on success, false otherwise
    */
   private function _request($url, $headers) {

      $ch = curl_init();
      curl_setopt_array($ch, array(
         CURLOPT_HTTPHEADER => $headers,
         CURLOPT_RETURNTRANSFER => 1,
         CURLOPT_URL => $url
      ));

      if ($json = curl_exec($ch)) {

         curl_close($ch);
         return json_decode($json);

      }

      curl_close($ch);
      return false;

   }

}
?>