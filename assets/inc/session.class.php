<?php

class Session {

    protected $Token;
    protected $Active = false;

    public function __construct($token = null) {

        if(!$token && isset($_COOKIE['sessionkey'])) {
            $token = escapeString($_COOKIE['sessionkey']);
        }

        if($token) {
            $this->Token = $token;

            if($this->validateToken())
                $this->Active = true;
        }
    }

    protected function validateToken() {
        global $db;

        if(!$this->Token || !$_SERVER['REMOTE_ADDR'])
            return false;

        $currentTimestamp = strtotime(date("Y-m-d H:i:s"));

        $prep = $db->prepare("SELECT uid FROM sessions WHERE token = ? AND useragent = ? AND ipaddress = ? AND UNIX_TIMESTAMP(dateline_expires) > $currentTimestamp");
        $prep->bind_param("sss", $token, $useragent, $ipaddress); 

        $token = escapeString($this->Token);
        $useragent = escapeString($_SERVER['HTTP_USER_AGENT']);
        $ipaddress = escapeString($_SERVER['REMOTE_ADDR']);

        $prep->execute();
        $prep->store_result();

        if($prep->num_rows)
            return true;

        return false;

    }

    public function isActive() {
        return $this->Active;
    }

}

?>