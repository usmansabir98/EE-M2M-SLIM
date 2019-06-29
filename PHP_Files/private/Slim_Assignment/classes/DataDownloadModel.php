<?php

/**
 * 
 *
 * DataDownloadModel.php
 *
 * One of the class files used by the system is the DataDownloadModel.php file.
 *
 * This file sets a handle which then is used for retrieving the EE messages
 * which are stored on the SOAP Client and uses the getter methods to retrieve
 * the information that has been handled within this class. Other methods such as
 * setters and do'ers allows the intialising of the handles and message data as well
 * performing tasks to retrieve information from the SOAP client.
 *
 * 
 */


//$f_class_path = $app->config('classes.path') . DIRSEP;                //requies path information and stores it in variable

//require_once $f_class_path . 'XMLparserModel.php';                    //variable information is then used for concatenating with the required
                                                                      //php files which are required_once and loaded
include(__DIR__ . '/../classes/XMLparserModel.php');                 //these include is needed for testing purposes, comment above requires for testing

class DataDownloadModel
{
    private $c_obj_soap_client_handle;
    private $c_arr_download_message_data;
    private $c_message_id;
    private $c_error;

    /**
     * Default constructor initialises the values to null
     */

    public function __construct()
    {
        $this->c_obj_soap_client_handle = null;
        $this->c_arr_download_message_data = array();
        $this->c_message_id = '';
        $this->c_error=0;
    }

    public function __destruct(){}

    /**
     * set_soap_client_handle($p_soap_client_handle) sets the SOAP client handle
     *
     * @param - $p_soap_client_handle - sets SOAP client handle
     * @return - None
     */

    public function set_soap_client_handle($p_soap_client_handle)
    {
        $this->c_obj_soap_client_handle = $p_soap_client_handle;
    }

    /**
     * set_message_id($p_sanitised_input_id) sets the message id which is used for
     * referencing to other information within this class
     *
     * @param - $p_sanitised_input_id - sets the sanitised metadata id information
     * @return - None
     */

    public function set_message_id($p_sanitised_input_id)
    {
        $this->c_message_id=$p_sanitised_input_id;

    }

    /**
     * do_error_exist() function check if there are errors
     *
     * @param - None
     * @return - true or false depending on the presence of errors;
     */
    public function do_error_exist()
    {
        if($this->c_error>0)
        {
            return true;
        }

        else
        {
            return false;
        }
    }

    /**
     * do_download_message() does the downloading of the messages by connecting to
     * the SOAP client. The SOAP Client handle must be passed before connecting.
     *
     * @param - None
     * @return - None
     */

    public function do_download_message()
    {
        $m_error=$this->c_error;
        if ($this->c_obj_soap_client_handle!= null)
        {
            if(!$this->do_get_message_data())
            {
                $this->do_parse_downloaded_message_data();
            }
            else
            {
                $m_error++;
            }


        }
        else
        {
            $m_error++;
        }

        $this->c_error=$m_error;
    }

    /**
     * get_download_message_data() retrieves the downloaded messages, need to be
     * downloaded before they can be retireved.
     *
     * @param - None
     * @return - returns the downloaded messages
     */

    public function get_downloaded_message_data()
    {
        return $this->c_arr_download_message_data;
    }

    /**
     * set_download_message_data($p_arr_message_data) sets the download message data
     *
     * @param - sets the downloaded message
     * @return - None
     */

    public function set_downloaded_message_data($p_arr_message_data)
    {
        $this->c_arr_download_message_data=$p_arr_message_data;
    }

    /**
     * do_get_message_data() connects to the SOAP Client and downloads the message data
     *
     * @param - None
     * @return - returns the boolean value to indicate messages return success
     */

    private function do_get_message_data()
    {
        $m_soap_server_get_message_result_error = true;

        $m_arr_messages = array();

        if ($this->c_obj_soap_client_handle)
        {
            try
            {
                if($this->c_message_id != -1)
                {
                    $m_arr_messages = $this->c_obj_soap_client_handle->peekMessages('19aus_P2503051','Junlinchriss8',100, 447817814149,$this->c_message_id);
                }
                else
                {
                    $m_arr_messages = $this->c_obj_soap_client_handle->peekMessages('19aus_P2503051','Junlinchriss8',100, 447817814149);
                }

                $m_soap_server_get_message_result_error = false;

            }
            catch (SoapFault $m_obj_exception)
            {

                //nothing to do as error will be true
            }
        }

        $this->c_arr_download_message_data = $m_arr_messages;
        return $m_soap_server_get_message_result_error;

    }

    /**
     * do_parse_downloaded_message_data() parses the downloaded messages into XML format
     *
     * @param - None
     * @return - None
     */

    private function do_parse_downloaded_message_data()
    {
        if(!empty($this->c_arr_download_message_data))                              //checks to see if message data is empty or not
        {
            $m_obj_parser = new XmlParserModel();                                   //if not then the parse it to XML format
            foreach ($this->c_arr_download_message_data as $key => $value)
            {
                $m_obj_parser->set_xml_string_to_parse($value);
                $m_obj_parser->do_parse_the_xml_string();
                $this->c_arr_download_message_data[$key] = $m_obj_parser->get_parsed_message_data();
            }
        }

    }

}
