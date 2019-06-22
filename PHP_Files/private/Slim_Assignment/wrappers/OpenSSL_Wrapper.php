<?php
/**
 * Description of Encrypt:
 *      Purpose of this class is to facilitate and ease use of OpenSSL encryption
 *      The primary purpose of the class is to encrypt strings of potentially sensitive data 
 *          (address, phone number, soc, etc) for storage and provide a simple way to decrypt
 * 
 *      This class utilizes a 2 part key for security
 *          - one part is in a plain text (log) file outside of web root on the server
 *          - the third part is stored within the class here
 *      All 2 parts of the key are combined and hashed to create the true key
 * 
 * 
 *      IV is created by hashing a text string stored within the class
 *      It is then shrunk down to only 16 charactrers, as that is what the AES-256-CBC method requires
 * 
 * 
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 * 
 * 
 */
class OpenSSLEncr {
    
    /**
     *
     * @var type 
     */
    private $keyFile;
    private $keyPart;
    private $appliedMethod;
    private $mainKey;
    private $IV;
    private $fullIV;
    
    /** 
     * Constructor method
    **/
    public function __construct() {
        
        $this->keyPart = "RandomlyGen2039"; /* File which is encoded inside the class itself */
        $this->keyFile = 'mainEncryptionKeys.txt'; /* Second key - Comes from the file */
        $this->appliedMethod = "AES-256-CBC"; /* Encryption scheme */
        $this->fullIV = "rand0mt309182"; /* Initialization Vector */
        
        // encrypt method AES-256-CBC expects 16 bytes
        $this->IV = substr(hash('sha256', $this->fullIV), 0, 16);
        
        // Outputs the final key after combining all keys
        $this->mainKey = $this->get_key();   
    }
       
    /**
     * Simple encrypt method wrapper     
     * 
     * @param string $plain_text
     * @return string
     */
    public function encrypt($plain_text) {
        // Data, method, key, options, IV
        $output = openssl_encrypt($plain_text, $this->appliedMethod, $this->mainKey, 0, $this->IV);
        return base64_encode($output);
    }
    
    /**
     * Simple decrypt method wrapper
     * 
     * @param string $enc_string
     * @return string
     */
    public function decrypt($enc_string) {
        return openssl_decrypt(base64_decode($enc_string), $this->appliedMethod, $this->mainKey, 0, $this->IV);
    }
    
    /**
     * Private function that combines and hashes the key
     * 
     * @return string
     */
    private function get_key() {
        
        $finAddress = __DIR__."\\".$this->keyFile;
        $keyFromFile = file_get_contents($finAddress);
        // $keyFromFile = file_get_contents($currDir . '\' . $this->keyFile);
        $combine = $keyFromFile . " " . $this->keyPart;
        $finalKey = hash('sha256', $combine);
        
        return $finalKey;
    }

}


?>