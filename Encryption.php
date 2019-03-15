<?php
/**
 * Created by PhpStorm.
 * User: maxence.millot
 * Date: 04/02/2019
 * Time: 14:10
 */

class Encryption
{

    private $secret_key = 'Kersia123Go';

    function __construct()
    {
        //auth
        //generate key (with setToken)
        //encrypt pass
        //generate iv = store in a session

        //reset key timeout(in checkcookie?)
    }

    function encrypt($pass, $iv) {
        // hash
        $key = hash('sha256', $this->secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $strongIv = substr(hash('sha256', $iv), 0, 16);
        $output = openssl_encrypt($pass, ENCRYPT_METHOD, $key, 0, $strongIv);
        $output = base64_encode($output);

        return $output;
    }

    function decrypt($pass, $iv){
        // hash key
        $key = hash('sha256', $this->secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $strongIv = substr(hash('sha256', $iv), 0, 16);
        $output = openssl_decrypt(base64_decode($pass), ENCRYPT_METHOD, $key, 0, $strongIv);
        return $output;
    }

    function generateIv(){
        $json = file_get_contents(ROOT_DIR."/config/data/enc-salt.json");
        if(!$json){
            writeErrorLog("could not read enc-salt.json");
        }
        $oCred = json_decode($json);

        if (empty($oCred) or !isset($oCred->salt)){
            writeErrorLog("Error: data.json file lacks credentials or JSON string can't be decoded.");
        }

        $salt = $oCred->salt;
        return  hash('sha256', $salt, true);
    }
}