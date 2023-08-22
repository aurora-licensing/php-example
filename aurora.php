<?php

class AuroraAPI {
    private $baseUrl;
    private $name;
    private $secret;
    private $hash;
    private $version;
    
    public function __construct($name, $secret, $hash, $version, $baseUrl) {
        $this->name = $name;
        $this->secret = $secret;
        $this->hash = $hash;
        $this->version = $version;
        $this->baseUrl = $baseUrl;
    }
    
    private function sendRequest($action, $params) {
        $url = $this->baseUrl . '?action=' . $action . '&' . http_build_query($params);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
    
    public function initializeAPI() {
        $params = array(
            'name' => $this->name,
            'secret' => $this->secret,
            'hash' => $this->hash,
            'version' => $this->version
        );
        return $this->sendRequest('init', $params);
    }
    
    public function checkLicense($license) {
        $params = array(
            'name' => $this->name,
            'secret' => $this->secret,
            'hash' => $this->hash,
            'version' => $this->version,
            'license' => $license
        );
        return $this->sendRequest('check', $params);
    }
    
    public function checkExpiry($license) {
        $params = array(
            'name' => $this->name,
            'secret' => $this->secret,
            'hash' => $this->hash,
            'version' => $this->version,
            'license' => $license
        );
        return $this->sendRequest('check_expiry', $params);
    }
    
    public function getHWID($license) {
        $params = array(
            'name' => $this->name,
            'secret' => $this->secret,
            'hash' => $this->hash,
            'version' => $this->version,
            'license' => $license
        );
        return $this->sendRequest('get_hwid', $params);
    }
    
    public function checkSub($license) {
        $params = array(
            'name' => $this->name,
            'secret' => $this->secret,
            'hash' => $this->hash,
            'version' => $this->version,
            'license' => $license
        );
        return $this->sendRequest('get_license_sub', $params);
    }
    
    public function usedDate($license) {
        $params = array(
            'name' => $this->name,
            'secret' => $this->secret,
            'hash' => $this->hash,
            'version' => $this->version,
            'license' => $license
        );
        return $this->sendRequest('get_used_date', $params);
    }
    
    public function getVar($varSecret) {
        $params = array(
            'name' => $this->name,
            'secret' => $this->secret,
            'hash' => $this->hash,
            'version' => $this->version,
            'varSecret' => $varSecret
        );
        return $this->sendRequest('getvar', $params);
    }
}

?>