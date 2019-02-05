<?php
/**
 * Created by PhpStorm.
 * User: maxence.millot
 * Date: 04/02/2019
 * Time: 14:10
 */

class Encryption
{

    private $secret_key;

    function __construct()
    {
        //auth
        //generate key (with setToken)
        //encrypt pass
        //generate iv = store in a session

        //reset key timeout(in checkcookie?)
    }

    function encrypt($pass) {

        // hash
        $key = hash('sha256', $this->secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $this->generateIv()), 0, 16);

        $_SESSION["iv"] = $iv; // Initialisation vector in session var (server side)

        $output = openssl_encrypt($pass, ENCRYPT_METHOD, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }

    function decrypt($pass){
        // hash key
        $key = hash('sha256', $_COOKIE['key']);
        $output = openssl_decrypt(base64_decode($pass), ENCRYPT_METHOD, $key, 0, $_SESSION['iv']);
        return $output;
    }

    function generateKey(){
        $this->secret_key = openssl_random_pseudo_bytes(8);
        if(setcookie("key",$this->secret_key,time()+60*20)){  // 20 minutes
            return true;
        }
        return false;
    }
    function resetKeyTimeout(){
        if(setcookie("key",$_COOKIE['key'],time()+60*20)){  // 20 minutes
            return true;
        }
        return false;
    }

    private function generateIv(){
        $secret_iv = openssl_random_pseudo_bytes(16);
        return $secret_iv;
    }
}