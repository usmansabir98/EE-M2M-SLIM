<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * DataDisplayModel.php
 *
 * One of the class files used by the system is the DataDisplayModel.php file.
 *
 * This file sets a handle which then is used for retrieving the EE downloaded messages
 * which are stored on the local database and use the get methods to display the individual
 * information. The metadata id is also set in this class.
 */

$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;           //requies path information and stores it in variable

require_once $f_wrapper_path . 'SQL_Wrapper.php';                   //variable information is then used for concatenating with the required
//include(__DIR__ . '/../wrappers/SQL_Wrapper.php');                 //these include is needed for testing purposes, comment above requires for testing
                                                                    //php files which are required_once and loaded

class DataDisplayModel
{
    private $c_obj_database_handle;
    private $c_arr_stored_message_data;
    private $c_arr_metadata;
    private $c_arr_database_connection_messages;
    private $c_message_id;
    private $c_error;


    /**
     * Default constructor initialises the values to null
     */

    public function __construct()
    {
        $this->c_obj_database_handle = null;
        $this->c_arr_database_connection_messages = array();
        $this->c_arr_stored_message_data = array();
        $this->c_arr_metadata=array();
        $this->c_message_id='';
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
     * do_get_database_connection_result() gets the error messages from the mysql wrapper and sets to
     * local array
     *
     * @param - None
     * @return - None
     */
    public function do_get_database_connection_result()
    {
        $this->c_arr_database_connection_messages = $this->c_obj_database_handle->get_connection_messages();
    }

    /**
     * get_stored_message_data() gets the stored messages that were stored on the database
     *
     * @param - None
     * @return - returns stored messages
     */

    public function get_stored_message_data()
    {
        return $this->c_arr_stored_message_data;
    }

    /**
     * set_metadata() gets the stored metadata information from the database
     *
     * @param - None
     * @return - returns metadata information
     */

    public function get_metadata()
    {
        return $this->c_arr_metadata;
    }

    /**
     * set_message_id($p_sanitised_input_id) sets the message id passed as a parameter
     * and is initialised within this class for further referencing when using other methods
     * in this class.
     *
     * @param - $p_sanitised_input_id - sets message id
     * @return - None
     */

    public function set_message_id($p_sanitised_input_id)
    {
        $this->c_message_id=$p_sanitised_input_id;

    }

    /**
     * do_retrieve_stored_message_data() retrieves message data from the database and loads it within this class
     * other getter methods are used to retrieve the data provided by this method.
     *
     * @param - None
     * @return - returns the state of the message in boolean, indicating the existence of the message
     */

    public function do_retrieve_stored_message_data()
    {
        $m_obj_SQL = new SQL_Wrapper();

        if($this->c_message_id==-1)
        {
            $m_arr_sql_query_parameters = array();
            $m_sql_query_string = $m_obj_SQL->get_message_data_all();
        }
        else
        {
            $m_arr_sql_query_parameters = array('sourceMSISDN'=>$this->c_message_id);
            $m_sql_query_string = $m_obj_SQL->get_message_data();
        }
        //

        $m_message_data_exist=false;
        $m_error=$this->c_error;
        if(!$this->c_arr_database_connection_messages['database-connection-error'])
        {
            $m_result = $this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters);
            if($m_result!=false)
            {
                $m_message_count = $this->c_obj_database_handle->count_rows();

                if ($m_message_count != 0)
                {
                    $m_message_data_exist=true;
                    $m_message_list = array();
                    $m_lcv = 0;
                    while ($m_row = $this->c_obj_database_handle->safe_fetch_row())
                    {
                        $m_message_list[$m_lcv] = $m_row;
                        $m_lcv++;

                    }

                    $this->c_arr_stored_message_data = $m_message_list;

                    /*foreach ($this->c_arr_stored_message_data as $key => $value){
                        foreach ($value as $key2 => $value2)
                            echo $value2 . '</br>';
                        echo '</br>';
                    }*/


                }
            }



        }
        else
        {
            $m_error++;
        }

        $this->c_error=$m_error;
        return $m_message_data_exist;

    }

    /**
     * do_retrieve_metadata() retrieves metadata from the database and loads it within this class
     * other getter methods are used to retrieve the data provided by this method.
     *
     * @param - None
     * @return - returns the state of the metadata in boolean, indicating the existence of the metadata
     */

    public function do_retrieve_metadata()
    {
        $m_obj_SQL = new SQL_Wrapper();
        $m_sql_query_string = $m_obj_SQL->get_metadata();
        $m_arr_sql_query_parameters = array();
        $m_data_exist=false;
        $m_error=$this->c_error;
        if(!$this->c_arr_database_connection_messages['database-connection-error']) {
            $m_result = $this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters);
            if($m_result!=false)
            {
                $m_columns_count = $this->c_obj_database_handle->count_rows();
                if ($m_columns_count != 0) {
                    $m_data_exist = true;
                    $m_column_list = array();
                    while ($m_row = $this->c_obj_database_handle->safe_fetch_row()) {

                        $m_column_list[] = $m_row['0'];

                    }
                    $this->c_error=false;
                    $this->c_arr_metadata = $m_column_list;

                }
            }

        }
        else
        {
            $m_error++;
        }

        $this->c_error=$m_error;
        return $m_data_exist;
    }

}
