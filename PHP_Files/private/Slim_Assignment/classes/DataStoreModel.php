<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * DataStoredModel.php
 *
 * One of the class files used by the system is the DataStoreModel.php file.
 *
 * This file sets a handle which then is used for retrieving the EE messages
 * which are stored on the SOAP Client and uses the getter methods setter methods
 * to set the required data as well as using do'er methods to store, filter, check
 * or add new messages from and to the database.
 *
 * @author CF Ingrams <cfi@dmu.ac.uk> - Modified by Users: P14184295 and P14166609
 * @copyright De Montfort University
 *
 * @package stock-quotes
 */

$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;               //requies path information and stores it in variable

require_once $f_wrapper_path . 'SQL_Wrapper.php';                       //variable information is then used for concatenating with the required
                                                                        //php files which are required_once and loaded
//include(__DIR__ . '/../wrappers/SQL_Wrapper.php');                 //these include is needed for testing purposes, comment above requires for testing

class DataStoreModel
{
    private $c_obj_database_handle;
    private $c_arr_download_message_data;
    private $c_arr_database_connection_messages;
    private $c_error;

    /**
     * Default constructor initialises the values to null
     */

    public function __construct()
    {
        $this->c_obj_database_handle = null;
        $this->c_arr_download_message_data = array();
        $this->c_arr_database_connection_messages = array();
        $this->c_error=0;
    }

    public function __destruct(){}

    /**
     * set_database_handle($p_obj_database_handle) sets the database handle provided by the user
     * and uses the database handle to connect to the database
     *
     * @param - $p_obj_database_handle - sets the database handle
     * @return - None
     */

    public function set_database_handle($p_obj_database_handle)
    {
        $this->c_obj_database_handle = $p_obj_database_handle;
    }

    /**
     * set_downloaded_message_data($p_arr_message_data) sets the downloaded message data
     *
     * @param - $p_obj_database_handle - sets the message data
     * @return - None
     */
    public function set_downloaded_message_data($p_arr_message_data)
    {
        $this->c_arr_download_message_data=$p_arr_message_data;

    }
    /**
     * do_get_database_connection_result gets the error message from mysql
     * and sets to local array
     *
     * @param - $p_obj_database_handle - sets the message data
     * @return - None
     */
    public function do_get_database_connection_result()
    {
        $this->c_arr_database_connection_messages = $this->c_obj_database_handle->get_connection_messages();
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
     * do_store_downloaded_message_data() this process filters out the messages and prepares
     * the configurations for storing the message data into the database
     *
     * @param - None
     * @return - None
     */
    public function do_store_downloaded_message_data()
    {
        $f_result=false;
        $this->do_filter_message();                                     //Filters infomration
        $this->do_prepare_message_data();                               //prepares the message format
        foreach ($this->c_arr_download_message_data as $key => $value)  //for each existing value, store the message into database
        {
            if(!$this->do_does_message_exist($value))
            {

                    $this->do_add_new_message($value);
                    $f_result=true;

            }
        }
        return $f_result;


    }

    /*
     * do_filter_message() filters out the messages from the rest of the messages
     * and stores the required messages into an array
     */

    private function do_filter_message()
    {
        $m_filtered_message=array();
        foreach ($this->c_arr_download_message_data as $key => $value)
        {
            foreach ($value as $key2 => $value2)
            {
                if(strtolower($value2) == '16-3110-ah')
                {
                    $m_filtered_message[]=$this->c_arr_download_message_data[$key];
                }
            }

        }
        $this->c_arr_download_message_data=$m_filtered_message;

    }

    /*
     * do_prepare_message_datae() modifys the message date and time (format of message)
     * and stores it into a multi-dimensional array which is used to store the right content
     * into the database
     */

    private function do_prepare_message_data()//adjust date-time
    {
        //modify date-time to comply with sql
        foreach ($this->c_arr_download_message_data as $key => $value)                        //gets key/value pair from message
            foreach ($value as $key2 => $value2)                                              //gets single value from multi diemnsional array
                if($key2 == 'RECEIVEDTIME'){                                                  //checks if value matches with the "RECIEVEDTIME"
                    $f_modified_date= str_replace("/","-",$value2);                           //if so then format the date into the correct order
                    $f_modified_date= "".date("Y-m-d H:i:s",strtotime($f_modified_date))."";  //store this into a multidimensional array which is used later
                    $f_modified_date= str_replace(array("-",":"," "),"",$f_modified_date);

                    $this->c_arr_download_message_data[$key][$key2] = $f_modified_date;
                }

    }


    /*
     * do_does_message_exist($p_arr_message_to_check) checks if the current message exists and returns a boolean value
     */

    private function do_does_message_exist($p_arr_message_to_check)
    {
        $m_error=$this->c_error;
        $m_message_exists = false;
        $m_wrapper_object=new SQL_Wrapper();
        $m_sql_query_string = $m_wrapper_object->check_message_exist();
        $m_arr_sql_query_parameters = array('sourceMSISDN' => $p_arr_message_to_check['SOURCEMSISDN'],'receivedDate' =>$p_arr_message_to_check['RECEIVEDTIME'] );
        if(!$this->c_arr_database_connection_messages['database-connection-error'])
        {
            $this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters);
            $m_number_of_rows = $this->c_obj_database_handle->count_rows();


            if ($m_number_of_rows > 0)
            {
                $m_message_exists = true;
            }
        }
        else
        {
            $m_error++;
        }

        $this->c_error=$m_error;
        return $m_message_exists;
    }

    /*
     * do_add_new_messaget($p_arr_message_to_add) adds a new message
     */

    private function do_add_new_message($p_arr_message_to_add)
    {
        $m_arr_database_execution_messages=false;
        $m_wrapper_object=new SQL_Wrapper();
        $m_sql_query_string = $m_wrapper_object->store_message();
        $m_arr_sql_query_parameters=$p_arr_message_to_add;
        if(!$this->c_arr_database_connection_messages['database-connection-error'])
        {
            $m_arr_database_execution_messages = $this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters);
        }

        if($m_arr_database_execution_messages===false)
            $this->c_error++;



    }

}
