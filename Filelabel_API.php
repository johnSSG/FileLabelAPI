<?php
class Filelabel_API {
    function __construct($apiKey, $token = false) {
        $this->loggedIn = false;
        $this->session();
        $this->url = 'https://filelabel.co/api/?';
        $this->apiKey = $apiKey;
        if($token) $_SESSION['fileLabelAPIToken'] = $token;
        $this->token = (isset($_SESSION['fileLabelAPIToken']) ? $_SESSION['fileLabelAPIToken'] : false);
        if($this->token) :
            if($this->checkSession()) :
                $this->loggedIn = true;
            else :
                $this->auth();
            endif;
        else :
            $this->auth();
        endif;
    }
    
    public function auth() {
        $response = $this->getResponse(array(
            'action' => 'auth',
            'apiKey' => $this->apiKey            
        ));
        if($response) :
            $_SESSION['fileLabelAPIToken'] = $response->user->token;
            $this->loggedIn = true;
        endif;
    }
    
    public function checkSession() {
        $response = $this->getResponse(array(
            'action' => 'getSession',
            'token' => $this->token
        ));
        return ($response ? true : false);
    }
    
    private function curl($url, $utf8 = true) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, null);
        curl_setopt($curl, CURLOPT_POST, FALSE);
        curl_setopt($curl, CURLOPT_HTTPGET, TRUE);        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $return = curl_exec($curl);
        curl_close($curl);
        return ($utf8) ? json_decode(utf8_encode($return))->output : json_decode($return)->output;        
    }
    
    private function getResponse($params = false) {
        if($params) :
            $url = $this->url.http_build_query($params);
            $response = $this->curl($url);
            return (empty($response) ? false : $response);
        endif;
        return false;
    }
    
    public function session() {
        if(!isset($_SESSION)) :
            session_start();
        endif;
    }
}
?>
