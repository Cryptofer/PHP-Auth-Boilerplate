<?php

class Account {

    protected $Username;
    protected $Password;

    public function __construct() {}

    public function Login($Username = null, $Password = null) {
        global $db;

        if(!$Username || !$Password || !$_SERVER['REMOTE_ADDR'])
            return false;

        $prep = $db->prepare("SELECT uid,password FROM users WHERE username = ?");
        $prep->bind_param("s", $username); 

        $username = escapeString($Username);

        $prep->execute();

        $result = $prep->get_result();
        while ($user = $result->fetch_assoc()) {
            if(!$user['uid'])
                return false;

            if(!password_verify($Password, $user['password'])) {
                return false;
            }

            $createSession = $this->createSession($user['uid']);

            if($createSession[0])
                return true;
            else 
                return false;
        }
    }

    public function Register($Username = null, $Password = null, $confirmPassword = null) {
        global $db;

        if(!$this->Username || !$this->Password || !$confirmPassword || !$_SERVER['REMOTE_ADDR'])
            return false;

        if($this->Password != $confirmPassword)
            return array(false, "Password's do not match.");

        $prep = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $prep->bind_param("ss", $username, $password);

        $username = escapeString($this->Username);
        $password = $this->hashPassword($this->Password);

        if($prep->execute())
            return array(true, "The user account has been created.");
        else
            return array(false, "Could not create the user account, please try again.");
    }

    protected function createSession($uid) {
        global $db;

        $prep = $db->prepare("INSERT INTO sessions (uid, token, useragent, ipaddress, dateline_expires) VALUES (?, ?, ?, ?, ?)");
        $prep->bind_param("issss", $uid, $token, $useragent, $ipaddress, $cookie_expire);

        $uid = (int)$uid;
        $token = randomString(50);
        $token = hash('sha256', $token);

        $useragent = escapeString($_SERVER['HTTP_USER_AGENT']);
        $ipaddress = escapeString($_SERVER['REMOTE_ADDR']);
        
        $cookie_expire = date("Y-m-d H:i:s", strtotime('+1 days'));

        if($prep->execute()) {
            setcookie('sessionkey', $token, time() + (86400 * 1), "/"); // 86400 = 1 day
            return array(true, $token);
        } else
            return array(false, "");
    }

    public function destroySession($token = null) {
        global $db;

        if(!$token && isset($_COOKIE['sessionkey']))
            $token = $_COOKIE['sessionkey'];

        if(!$token)
            return false;

        $prep = $db->prepare("DELETE FROM sessions WHERE token = ?");
        $prep->bind_param("s", $token);

        $token = escapeString($token);

        $prep->execute();

        return true;
    }

    protected function hashPassword($string) {
        return password_hash($string, PASSWORD_BCRYPT);
    }
}

?>