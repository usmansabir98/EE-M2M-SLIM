<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * SendMessageModel.php
 *
 * One of the class files used by the system is the SendMessageModel.php file.
 *
 * This file sets a handle which then is used for retrieving the EE messages
 * which are stored on the SOAP Client and uses the getter methods to retrieve
 * the information that has been handled within this class. Other methods such as
 * setters and do'ers allows the intialising of the handles and message data as well
 * performing tasks to retrieve information from the SOAP client.
 *
 * @author CF Ingrams <cfi@dmu.ac.uk> - Modified by Users: P14184295 and P14166609
 * @copyright De Montfort University
 *
 * @package stock-quotes
 */

class SendMessageModel
{
    private $c_obj_soap_client_handle;
    private $c_arr_sent_message_data;
    private $c_message_id;
    private $c_error;

    /**
     * Default constructor initialises the values to null
     */

    public function __construct()
    {
        $this->c_obj_soap_client_handle = null;
        $this->c_arr_sent_message_data = array();
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
     * do_send_message() does the sending of the messages by connecting to
     * the SOAP client. The SOAP Client handle must be passed before connecting.
     *
     * @param - delivery report, message, and bearer
     * @return - None
     */

    public function do_send_message($f_delivery_report, $f_message_body, $f_msg_bearer)
    {
        $m_error=$this->c_error;
        if ($this->c_obj_soap_client_handle!= null)
        {
            if(!$this->do_send_message_data($f_delivery_report, $f_message_body, $f_msg_bearer))
            {
                return $this->verifyMessageSent();
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
     * do_get_message_data() connects to the SOAP Client and sends the message data
     *
     * @param - delivery report, message, and bearer
     * @return - returns the boolean value to indicate messages return success
     */

    private function do_send_message_data($f_delivery_report, $f_message_body, $f_msg_bearer)
    {
        $m_soap_server_send_message_result_error = true;
        // echo $f_message_body;
        // exit();

        $m_arr_messages = array();

        if ($this->c_obj_soap_client_handle)
        {
            try
            {
                if($this->c_message_id != -1)
                {
                    $m_arr_messages = $this->c_obj_soap_client_handle->sendMessage('19aus_P2503051', 'Junlinchriss8', $this->c_message_id , html_entity_decode($f_message_body), $f_delivery_report, $f_msg_bearer);
                }

                $m_soap_server_send_message_result_error = false;
            }
            catch (SoapFault $m_obj_exception)
            {
                // Error will already be true i.ie $m_soap_server_sent_message_result_error
            }

        }

        $this->c_arr_sent_message_data = $m_arr_messages;
        return $m_soap_server_send_message_result_error;

    }

    public function verifyMessageSent()
    {
        if($this->c_arr_sent_message_data)                            //checks to see if message data is empty or not
        {
            return true;
        }
        else {
            return false;
        }

    }

}
