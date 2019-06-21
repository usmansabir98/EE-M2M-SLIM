<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 26/11/2016
 *
 * SQL_Wrapper.php
 *
 * Here the SQL_Wrapper acts as a container. Instead of calling
 * individual querys, they are defined here in this class and called by a
 * simple method call.
 */

class SQL_Wrapper
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * get_admin_id() returns all of the different user_id's of the registered users
     * from the database - assignmentdb.
     *
     * @param - None
     * @return - returns the results of the users user_id's
     */

    public function get_admin_id()
    {
        $m_sql_query_string  = "SELECT User_ID ";
        $m_sql_query_string .= "FROM users;";
        return $m_sql_query_string;
    }

    /**
     * get_admin_credintials() returns all of the credintials of the registered users
     * (Username and Password) from the database - assignmentdb.
     *
     * @param - None
     * @return - returns the results of the usernames and passwords of the users
     */

    public function get_admin_credintials()
    {
        $m_sql_query_string  = "SELECT Username, Password ";
        $m_sql_query_string .= "FROM users ";
        $m_sql_query_string .= "ORDER BY User_ID;";
        return $m_sql_query_string;
    }

    /**
     * get_stored_username_and_email() returns the information such as Username and Email of the users
     * from the database - assignmentdb.
     *
     * @param - None
     * @return - returns the results of the usernames and emails of the users
     */

    public function get_stored_username_and_email()
    {
        $m_sql_query_string  = "SELECT Username, Email ";
        $m_sql_query_string .= "FROM users ";
        return $m_sql_query_string;
    }

    /**
     * set_user_and_credintials() sets the User_ID, Username, Password and Email of the users
     * to the database - assignmentdb.
     *
     * @param - None
     * @return - returns the results of the query
     */

    public function set_user_credintials()
    {
        $m_sql_query_string  = "INSERT INTO users (User_ID, Username, Password, Email) ";
        $m_sql_query_string .= "VALUES (:ID, :Username, :Password, :Email);";
        return $m_sql_query_string;
    }

    /**
     * store_message() sets the downloaded message from the EE Server
     * to the database - assignmentdb.
     *
     * @param - None
     * @return - returns the results of the query
     */

    public function store_message()
    {
        $m_sql_query_string = "INSERT INTO message (srcMSISDN ,destMSISDN,receivedDate,
                                                 bearer, messageRef, id, switch1,
                                                 switch2, switch3, switch4, fan,
                                                 forward, reverse, heater, temperature, keypad)";
        $m_sql_query_string .= "VALUES (:SOURCEMSISDN,:DESTINATIONMSISDN,:RECEIVEDTIME,
                                    :BEARER,:MESSAGEREF,:ID,:S1,:S2,:S3,:S4,
                                    :FAN,:FRW,:REV,:H,:TEMP,:KEY);";
        return $m_sql_query_string;
    }

    /**
     * check_message_exist() gets the downloaded message source and destination MSISDN
     * from the database - assignmentdb and confirms the existence of the message
     * (whether the message has been downloaded)
     *
     * @param - None
     * @return - returns the results of the downloaded message
     */

    public function check_message_exist()
    {
        $m_sql_query_string  = "SELECT srcMSISDN, receivedDate ";
        $m_sql_query_string .= "FROM message ";
        $m_sql_query_string .= "WHERE srcMSISDN = :sourceMSISDN ";
        $m_sql_query_string .= "AND receivedDate = :receivedDate ";
        $m_sql_query_string .= "LIMIT 1";
        return $m_sql_query_string;
    }

    /**
     * get_message_data() gets the entire stored downloaded message from the database - assignmentdb
     * based on the matching source MSISDN.
     *
     * @param - None
     * @return - returns the results of the matching MSISDN query
     */

    public function get_message_data()
    {
        $m_sql_query_string  = "SELECT srcMSISDN, destMSISDN, receivedDate,
                                               bearer, messageRef, id, switch1,
                                               switch2, switch3, switch4, fan,
                                               forward, reverse, heater, temperature, keypad ";
        $m_sql_query_string .= "FROM message ";
        $m_sql_query_string .= "WHERE srcMSISDN = :sourceMSISDN ";
        $m_sql_query_string .= "ORDER BY receivedDate";
        return $m_sql_query_string;
    }

    /**
     * get_message_data() gets the entire stored downloaded message from the database - assignmentdb
     *
     * @param - None
     * @return - returns the results of the  query
     */
    public function get_message_data_all()
    {
        $m_sql_query_string  = "SELECT srcMSISDN, destMSISDN, receivedDate,
                                               bearer, messageRef, id, switch1,
                                               switch2, switch3, switch4, fan,
                                               forward, reverse, heater, temperature, keypad ";
        $m_sql_query_string .= "FROM message ";
        $m_sql_query_string .= "ORDER BY receivedDate";
        return $m_sql_query_string;
    }

    /**
     * get_metadata() gets the information of the meta data of the stored downloaded messages
     * from the database - assignmentdb.
     *
     * @param - None
     * @return - returns the results of the meta data
     */

    public function get_metadata(){
        $m_sql_query_string  = "SHOW columns ";
        $m_sql_query_string .= "FROM message ";
        return $m_sql_query_string;

    }


    public function get_userID(){
        $m_sql_query_string  = "SELECT User_ID ";
        $m_sql_query_string .= "FROM users ";
        $m_sql_query_string .= "WHERE Username = :username ";
        return $m_sql_query_string;
    }

    public function store_log(){
        $m_sql_query_string  = "INSERT INTO log (date, userID, msg) ";
        $m_sql_query_string .= "VALUES ( NOW(), :userID, :msg);";
        return $m_sql_query_string;
    }

}
