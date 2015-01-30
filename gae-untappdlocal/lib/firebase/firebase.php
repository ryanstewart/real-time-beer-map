<?php 
    class Firebase {
        private $url = "<YOUR FIREBASE INSTANCE>";
        
        public function pushData($json_data) {
            $endpoint = "checkins.json";
            $context = [
                'http' => [
                    'method' => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $json_data
                ]
                
            ];
            
            $context = stream_context_create($context);
            return file_get_contents($this->url . $endpoint, false, $context);
        }

        public function pushUpdateTime() {
            $endpoint = "lastupdate/.json";
            $content = json_encode( array("lastupdate" => date("Y-m-d H:i:s")) );
            $context = [
                'http' => [
                    'method' => 'POST',
                    'header'  => ['Content-type: application/x-www-form-urlencoded', "X-HTTP-Method-Override: PATCH"],
                    'content' => $content
                ] 
            ];
            
            $context = stream_context_create($context);
            return file_get_contents($this->url . $endpoint, false, $context);
        }
    

        public function getUpdateTime() {
            $request_url = $this->url . "lastupdate.json";

            $result = json_decode(file_get_contents($request_url),true);
            
            return $result["lastupdate"];
        }
        
        public function deleteCheckins() {
            $endpoint = "checkins.json";
            $context = [
                'http' => [
                    'method' => 'POST',
                    'header'  => ['Content-type: application/x-www-form-urlencoded', "X-HTTP-Method-Override: DELETE"]
                ] 
            ];
            
            $context = stream_context_create($context);
            return file_get_contents($this->url . $endpoint, false, $context);
        }
        
    }
?>