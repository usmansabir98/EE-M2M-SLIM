<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 14/12/2016
 *
 * Soap_Wrapper.php
 *
 * Here the Soap_Wrapper acts as a container. Instead of manually making
 * calls to the SOAP Client, methods are provided to set WSDL's, get messages and handles
 * also allowing to setup a remote connection to the SOAP Client. This wrapper provides
 * convinence to anyone trying to connect to a particular SOAP Client.
 */

class Soap_Wrapper
{
    private $c_wsdl;
    private $c_obj_soap_client_handle;
    private $c_arr_downloaded_data;
    private $c_arr_soap_client_messages;

    /**
     * Default Constructor, sets up initial values. No value is contained
     * and are defined as nulls.
     */

    public function __construct()
    {
        $this->c_wsdl = null;
        $this->c_obj_soap_client_handle = null;
        $this->c_arr_downloaded_data = null;
        $this->c_arr_soap_client_messages = array();
    }

    public function __destruct(){}

    /**
     * set_wsdl($p_wsdl) sets up the wsdl file within this Wrapper. It can then be used to call
     * other functionalities once the set up is initialised.
     *
     * @param - $p_wsdl - parameter argument requires the passing of a wsdl file
     * @return - returns nothing
     */

    public function set_wsdl($p_wsdl)
    {
        $this->c_wsdl = $p_wsdl;
    }

    /**
     * get_soap_client_message() gets the SOAP Client Message.
     *
     * @param - none
     * @return - returns SOAP Client Messages
     */

    public function get_soap_client_messages()
    {
        return $this->c_arr_soap_client_messages;
    }

    /**
     * get_soap_client_handle() gets the SOAP Client Handle.
     *
     * @param - none
     * @return - returns SOAP Client Handle
     */

    public function get_soap_client_handle()
    {
        return $this->c_obj_soap_client_handle;
    }

    /**
     * get_remote_functions() gets the functions of the SOAP Client Handle
     *
     * @param - none
     * @return - returns functions of the SOAP Client Handle
     */

    public function get_remote_functions()
    {
        var_dump($this->c_obj_soap_client_handle->__getFunctions());
    }

    /**
     * make_soap_client() creates the connection to the remote SOAP Client.
     *
     * @param - none
     * @return - none
     */

    public function make_soap_client()
    {
        $m_soap_creation_error = true;

        $m_arr_soapclient_settings = $this->create_soap_connection_settings();

        if ($this->c_wsdl != null)  //checks to see if wsdl file
        {

            /* if so then the SOAPClient is setup using default PHP method SOAPClient
             * which initialises the WSDL file and the SOAP Client settings.
             */

            try
            {

                $this->c_obj_soap_client_handle = new SoapClient($this->c_wsdl, $m_arr_soapclient_settings);
                $m_soap_creation_error = false;
                $this->c_arr_soap_client_messages['soap'] = 'Created SOAP client.';
            }

                /*
                 * otherwise error is thrown
                 */

            catch (SoapFault $m_obj_exception)
            {

                $this->c_arr_soap_client_messages['soap'] = 'Cannot create SOAP client.';
            }
        }
        $this->c_arr_soap_client_messages['soap-error'] = $m_soap_creation_error; //keeps the state of the server in an array
        return $m_soap_creation_error;
    }

    private function create_soap_connection_settings()
    {

        //Initialises the values within the variables

        $m_arr_dmu_proxy_settings = array();
        $m_arr_soapclient = array('trace' => true, 'exceptions' => true);
        $m_dmu_network = '146.227';
        $m_host_ip_address = getHostByName(getHostName());

        $m_local_host_network = substr($m_host_ip_address, 0, 7);

        /* If all matches then the array of settings is configured and merged together and returned to
         * to make the SOAPClient() connection
         */

        if (strcmp($m_local_host_network, $m_dmu_network) == 0)
        {
            $m_arr_dmu_proxy_settings = array('proxy_host' => 'proxy.dmu.ac.uk', 'proxy_port' => 8080);
        }
        $m_arr_soapclient_settings = array_merge($m_arr_soapclient, $m_arr_dmu_proxy_settings);
        return $m_arr_soapclient_settings;
    }
}
