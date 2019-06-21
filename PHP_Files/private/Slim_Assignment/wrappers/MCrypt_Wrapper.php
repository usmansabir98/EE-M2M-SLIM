<?php

 /**
  * Created by PhpStorm and Atom Editors.
  * Users: P14184295 and P14166609
  * Date: 20/11/2016
  *
  * MySQL_Wrapper.php
  *
  * Here the Mycrypt_Wrapper acts as a container. Instead of calling
  * indiviuals instances to encrypt/decrypt, a wrapper class is
  * provided to deal with it all.
  *
  * @author CF Ingrams <cfi@dmu.ac.uk> - Modified by Users: P14184295 and P14166609
  * @copyright De Montfort University
  */

  class MCrypt_Wrapper
  {
    private $c_td;
    private $c_key;
    private $c_iv;
    private $c_algorythm;
    private $c_mode;

    /**
     * Default constructor initialises the values
     *
     */

    public function __construct()
    {
      $this->c_td = '';
      $this->c_key = 'RandomText-max24chars';
      $this->c_algorythm = 'tripledes';
      $this->c_mode = 'ecb';
    }

    /**
     * initialise_mcrypt_encryption() initialises the encryption by configuring the
     * necessary values and sets it up for future encryption.
     *
     * @param - None
     * @return - None
     */

    public function initialise_mcrypt_encryption()
    {
      // set mcrypt cypher and mode
      $this->c_td = mcrypt_module_open($this->c_algorythm, '', $this->c_mode, '') ;

      // seed the pseudo random number generator
      $m_random_seed = MCRYPT_RAND;

      // find the size of the iv
      $m_iv_size = mcrypt_enc_get_iv_size($this->c_td);

      // set initialization vector - can be public and/or constant
      $this->c_iv = mcrypt_create_iv($m_iv_size, $m_random_seed);

      // find the size of the key based on cypher and mode
      $m_key_size = mcrypt_enc_get_key_size($this->c_td);

      // Don't need to know the real key, just need to be able to create a hashed version
      substr(md5($this->c_key), 0, $m_key_size);

      // initialize mcrypt library with mode/cipher, encryption key, and random initialization vector
      mcrypt_generic_init($this->c_td, $this->c_key, $this->c_iv);
    }

    /**
     * encrypt($p_string_to_encrypt) encrypts the current value passed to it and returns it
     *
     * @param - $p_string_to_encrypt - is the value that will get encrypted
     * @return - returns the encrypted value
     */

    public function encrypt($p_string_to_encrypt)
    {
      $m_encrypted_string = mcrypt_generic($this->c_td, $p_string_to_encrypt);
      return $m_encrypted_string;
    }

    /**
     * decrypt($p_string_to_decrypt) decrypts the current value passed to it and returns it
     *
     * @param - $p_string_to_decrypt - is the value that will get decrypted
     * @return - returns the decrypted value
     */

    public function decrypt($p_string_to_decrypt)
    {
      $m_decrypted_string = mdecrypt_generic($this->c_td, $p_string_to_decrypt);
      $m_decrypted_string = trim($m_decrypted_string);
      return $m_decrypted_string;
    }

  }
