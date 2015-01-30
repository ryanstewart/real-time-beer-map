<?php

    class Untappd {
        private $_access_token = "";
        private $base_url = "https://api.untappd.com/";
        private $authenticate_uri = "https://untappd.com/oauth/authenticate/";
        private $authorize_uri = "https://untappd.com/oauth/authorize/";
        private $redirect_uri = "<YOUR REDIRECT URL>";
        
        private $client_id = "<YOUR CLIENT ID>";
        private $client_secret = "<YOUR CLIENT SECRET>";
        
        public $reubens = "36289";
        public $budweiser = "44";
        public $fremont = "1508";
        public $guinness = "49";
        public $heineken = "1400";
        public $asiapacific = "3097";
        
        private $code = "";
        
        function Untappd() {
            return $this;
        }
        
        public function getAccessTokenValue() {  
            return $this->_access_token;
        }
        
        public function setAccessToken($value) {
            $this->_access_token = $value;
        }
        
        public function getBreweryActivity($brewery_id) {
            $endpoint = "/v4/brewery/checkins/" . $brewery_id;
            
            $args = array(
                "client_id" => $this->client_id,
                "client_secret" => $this->client_secret,
            );
        
            $url = $this->base_url . $endpoint . "?" . http_build_query($args);
            
            $result = file_get_contents($url);
            
            return $result;
            
        }
        
        public function brewerySearch($search_string) {
            $endpoint = "/v4/search/brewery";
            
            $args = array(
                "client_id" => $this->client_id,
                "client_secret" => $this->client_secret,
                "q" => $search_string,
            );
            
            $request_url = $this->base_url . $endpoint . "?" . http_build_query($args);
            $result = file_get_contents($request_url);
            return $result;
            
        }
        
        public function getAuthUri() {
            $uri = $this->authenticate_uri .
                "?client_id=" . $this->client_id .
                "&response_type=code" .
                "&redirect_url=" . $this->redirect_uri;
            
            header("Location: " . $uri);
        }
        
        public function getAccessToken($code) {
            $uri = $this->authorize_uri . 
                "?client_id=" . $this->client_id .
                "&client_secret=" . $this->client_secret .
                "&response_type=code" .
                "&redirect_url=" . $this->redirect_uri .
                "&code=" . $code;
            
            $result = file_get_contents($uri);
            
            return $result;
            
        }
        
    }

