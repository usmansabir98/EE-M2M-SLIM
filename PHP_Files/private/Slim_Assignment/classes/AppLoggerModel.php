<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 28/12/2016
 * Time: 20:13
 */

$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;               //requies path information and stores it in variable

require_once $f_wrapper_path . 'SQL_Wrapper.php';                       //variable information is then used for concatenating with the required
                                                                        //php files which are required_once and loaded
//include(__DIR__ . '/../wrappers/SQL_Wrapper.php');                 //these include is needed for testing purposes, comment above requires for testing

class AppLoggerModel
{
    private $c_obj_database_handle;
    private $c_arr_database_connection_messages;
    private $c_error;
    /**
     * Default constructor initialises the values to null
     */

    public function __construct()
    {
        $this->c_obj_database_handle = null;
        $this->c_arr_database_connection_messages = array();
        $this->c_error=0;
    }

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
     * do_logging() function that logs the message in the database
     *
     * @param - $p_user username of the user that generated the activity or null if none
     * @param - $p_message_to_log message to log
     * @return - true or false depending on the success of the storage;
     */
    public function do_logging($p_user,$p_message_to_log)
    {
        $m_error=$this->c_error;
        $m_success = false;
        if($this->c_obj_database_handle!=null)
        {
            if($p_user!==null)
            {
                $m_userID=$this->do_retrieve_userID($p_user);
            }
            else
            {
                $m_userID=null;
            }

            if($m_userID!==-1)
            {

                if($this->do_store_log($m_userID,$p_message_to_log))
                {
                    $m_success=true;
                }
            }

        }
        else
        {
            $m_error++;
        }


        $this->c_error=$m_error;
        return $m_success;
    }
    /**
     * do_retrieve_userID() function that retrieves user id given username
     *
     * @param - $p_user username of the user that generated the activity
     * @return - user id if present otherwise -1;
     */
    private function do_retrieve_userID($p_user)
    {
        $m_error=$this->c_error;
        $m_userID=-1;
        $m_wrapper_object=new SQL_Wrapper();
        $m_sql_query_string=$m_wrapper_object->get_userID();
        $m_arr_sql_query_parameters = array('username' => $p_user);

        if(!$this->c_arr_database_connection_messages['database-connection-error'])
        {
            $m_query =$this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters);
            if($m_query!=false)
            {
                $m_number_of_rows = $this->c_obj_database_handle->count_rows();


                if ($m_number_of_rows != 0)
                {
                    $m_row=$this->c_obj_database_handle->safe_fetch_row();
                    $m_userID=$m_row['0'];
                }
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
        return $m_userID;

    }
    /**
     * do_store_log() function that stores the  userid with the log message
     *
     * @param - $p_user userid of the user that generated the activity
     * @param - $p_msg message to store
     * @return - true or false based on success of storage;
     */
    private function do_store_log($p_user,$p_msg)
    {
        $m_error=$this->c_error;
        $m_success=false;
        $m_wrapper_object=new SQL_Wrapper();
        $m_sql_query_string=$m_wrapper_object->store_log();
        $m_arr_sql_query_parameters = array('userID' => $p_user,'msg' => $p_msg);
        if(!$this->c_arr_database_connection_messages['database-connection-error'])
        {
            $m_query =$this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters);
            if($m_query!=false)
            {
                $m_success=true;
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
        return $m_success;

    }
}