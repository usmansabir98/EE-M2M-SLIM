<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * MySQL_Wrapper.php
 *
 * Here the MySQL wrapper acts as a container. Instead of calling
 * indiviuals instances to connect to the database, a wrapper class is
 * provided to deal with the connection as well as providing means to
 * select querys safely.
 */

class MySQL_Wrapper
{
    private $c_obj_pdo;
    private $c_obj_stmt;
    private $c_arr_database_connection_messages;

    /**
     * Default Constructor sets the initial values to null
     */

    public function __construct()
    {
        $this->c_obj_pdo = null;
        $this->c_obj_stmt = null;
        $this->c_arr_database_connection_messages = array();
    }

    public function __destruct() { }

    /**
     * connect_to_database() uses predefined values provided within this Wrapper class
     * and sets up the connection to the remote database.
     *
     * @param - None
     * @return - returns the database connection PDO class
     */

    public function connect_to_database()
    {

        //Initialises the variables with the class method values

        $m_arr_db_connection_details = $this->get_user_database_connection_details();
        $m_user_name = $m_arr_db_connection_details['user_name'];
        $m_user_password = $m_arr_db_connection_details['user_password'];
        $m_host_details = $m_arr_db_connection_details['host_details'];
        $m_database_connection_error = true;

        $this->c_obj_pdo = null;       //current value is null
        try
        {

            /*
             * Uses default PHP class PDO to connect safely to a database with the parameters
             * gathered from the variables defined above. It initalises the attributes and the eror exceptions.
             */

            $this->c_obj_pdo = new PDO($m_host_details, $m_user_name, $m_user_password);
            $this->c_obj_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->c_arr_database_connection_messages['connection'] = 'Connected to the database.';
            $m_database_connection_error = false;
        }

            /*
             * If all failes then there is an error connecting to the database
             */

        catch (PDOException $exception_object)
        {
            $this->c_arr_database_connection_messages['connection'] = 'Cannot connect to the database.';
        }
        $this->c_arr_database_connection_messages['database-connection-error'] = $m_database_connection_error;
        return $this->c_obj_pdo;     //returns the current state of the PDO or null
    }

    public function get_connection_messages()
    {
        return $this->c_arr_database_connection_messages;
    }

    /**
     * safe_query($p_query_string, $p_arr_query_parameters = null) uses the parameters to set the query string
     * and additional parameters which are used for safe queries and helps from injections.
     *
     * @param - $p_query_string - is the query string that is used for searching up values from the database
     * @param - $p_arr_query_parameters - optional but can be used to set up safe query parameters
     * @return - None
     */

    public function safe_query($p_query_string, $p_arr_query_parameters = null)
    {
        $m_query_success = false;      //current value false
        try
        {
            $m_temp = array();          //initialised temporary array

            /* gets the PDO object and sets up the query string
             * if there are additional parameters passed they will be checked too and will be binded
             * the temporary array will be used as key/value storage, then string is executed
             * else the string is executed safely.
             */

            $this->c_obj_stmt = $this->c_obj_pdo->prepare($p_query_string);

            // bind the parameters
            if ($p_arr_query_parameters!=NULL && sizeof($p_arr_query_parameters) > 0)
            {
                foreach ($p_arr_query_parameters as $m_param_key => $m_param_value)
                {
                    $m_temp[$m_param_key] = $m_param_value;
                    $this->c_obj_stmt->bindParam($m_param_key, $m_temp[$m_param_key], PDO::PARAM_STR);
                }
            }
            // execute the query
            $m_query_success = $this->c_obj_stmt->execute();
        }

            /* if all fails then an error is thrown
             */

        catch (PDOException $exception_object)
        {
            $m_error_message  = 'PDO Exception caught. ';
            $m_error_message .= 'Error with the database access. ';
            $m_error_message .= 'SQL query: ' . $p_query_string;
            $m_error_message .= 'Error: ' . print_r($this->c_obj_stmt->errorInfo(), true) . "\n";
            $m_error_message .= $this->c_obj_stmt->errorInfo();
            // NB would usually output to file for sysadmin attention
            $m_query_success = $m_error_message;
        }
        return $m_query_success;     //returns the current state of the query string execution
    }

    /**
     * count_rows() returns the number of rows after counting them
     *
     * @param - None
     * @return - returns number of rows
     */

    public function count_rows()
    {
        $m_num_rows = $this->c_obj_stmt->rowCount();
        return $m_num_rows;
    }

    /**
     * count_columns() returns the number of columns after counting them
     *
     * @param - None
     * @return - returns number of columns
     */

    public function count_columns()
    {
        $m_num_columns = $this->c_obj_stmt->fetchColumn();
        return $m_num_columns;
    }

    /**
     * fetch_All() returns all the rows and columns of the searched query
     *
     * @param - None
     * @return - returns all number of rows and columns
     */

    public function fetch_All() {
        $m_arr_rows = $this->c_obj_stmt->fetchAll();
        return $m_arr_rows;
    }

    /**
     * safe_fetch_row() returns safely the row
     *
     * @param - None
     * @return - returns safely the row
     */

    public function safe_fetch_row()
    {
        $m_record_set = $this->c_obj_stmt->fetch(PDO::FETCH_NUM);
        return $m_record_set;
    }

    /**
     * safe_fetch_array() returns safely the array of values
     *
     * @param - None
     * @return - returns safely the array
     */

    public function safe_fetch_array()
    {
        $m_arr_row = $this->c_obj_stmt->fetch(PDO::FETCH_ASSOC);
        $this->c_obj_stmt->closeCursor();
        return $m_arr_row;
    }

    private function get_user_database_connection_details()
    {

        /*
         * Initialises the values which are used to connect to the database
         */

        $m_rdbms = 'mysql';
        $m_host = 'localhost';
        $m_db_name = 'assignment_db';
        $m_host_name = $m_rdbms . ':host=' . $m_host;
        $m_port_number = ';port=' . '3306';
        $m_user_name = 'p14166609_web';
        $m_user_password = 'sQuat=51';
        $m_user_database = ';dbname=' . $m_db_name;
        $m_host_details = $m_host_name . $m_port_number . $m_user_database;

        /*
         * The details are passed into an array and the array is returned as an array of configuration values
         * used to set up the connection with the PDO class
         */

        $m_arr_db_connect_details =
            [
                'host_details' => $m_host_details,
                'user_name' => $m_user_name,
                'user_password' => $m_user_password
            ];
        return $m_arr_db_connect_details;
    }

}
