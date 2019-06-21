<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 26/11/2016
 *
 * HTML_Wrapper.php
 *
 * Here the HTML_Wrapper acts as a container. Instead of creating individual
 * HTML markup in each class, this class provides a Wrapper for the EE Client
 * to be created instantenously. It is used with the Templates to create instant forms.
 */

class HTML_Wrapper
{

  private $c_path;                                //path of the folder location
  private $c_header;                              //header information in the markup
  private $c_authentication_page_form;            //authentication page form
  private $c_arr_login_form;                      //login page form
  private $c_arr_register_form;                   //register page form
  private $c_arr_homepage_page_form;              //homepage form
  private $c_arr_homepage_page_error_form;        //homepage error
  private $c_download_page;                       //download page form
  private $c_review_page;                         //review page form
  private $c_download_error_page;                 //download error page form
  private $c_review_error_page;                   //review error page form
  private $c_arr_login_field_empty_form;          //error login form
  private $c_arr_login_wrong_input_form;
  private $c_arr_register_field_empty_form;       //error register form
  private $c_arr_register_user_exists_form;
  private $c_display_page_processed;              //display information
  private $c_global_error_page;                   //display error when connection error happens with mysql/soap

  /**
   * Default Constructor initialises the values to null
   */

  public function __construct(){
    $this->c_path = $_SERVER["SCRIPT_NAME"];
    $this->c_header = null;
    $this->c_authentication_page_form = null;
    $this->c_arr_login_form = null;
    $this->c_arr_register_form = null;
    $this->c_arr_homepage_page_form = null;
    $this->c_arr_homepage_page_error_form = null;
    $this->c_download_page = null;
    $this->c_review_page = null;
    $this->c_download_error_page = null;
    $this->c_review_error_page = null;
    $this->c_arr_login_field_empty_form = null;
    $this->c_arr_login_wrong_input_form = null;
    $this->c_arr_register_field_empty_form = null;
    $this->c_arr_register_user_exists_form = null;
    $this->c_display_page_processed = null;
  }

  public function __destruct(){}

  /**
   * get_header() retrieves the header information to be used within the header tags in the Template.
   *
   * @param - None
   * @return - returns header information
   */

  public function get_header() {
    $this->do_header();
    return $this->c_header;
  }

  /**
   * get_authentication_page_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns authentication form information
   */

  public function get_authentication_page_form() {
    $this->do_authentication_page_form();
    return $this->c_authentication_page_form;
  }

  /**
   * get_login_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns login form information
   */

  public function get_login_form() {
    $this->do_login_form();
    return $this->c_arr_login_form;
  }

  /**
   * get_register_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns register form information
   */

  public function get_register_form() {
    $this->do_register_form();
    return $this->c_arr_register_form;
  }

  /**
   * get_homepage_page_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns homepage form information
   */

  public function get_homepage_page_form() {
    $this->do_homepage_page_form();
    return $this->c_arr_homepage_page_form;
  }

  /**
   * get_homepage_page_error_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns homepage error form information
   */

  public function get_homepage_page_error_form() {
    $this->do_homepage_page_error_form();
    return $this->c_arr_homepage_page_error_form;
  }

  /**
   * get_download_page() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns download page information
   */

  public function get_download_page() {
    $this->do_download_page();
    return $this->c_download_page;
  }

    /**
     * get_download_error_page() retrieves the form information that is used within tags in the Template.
     *
     * @param - None
     * @return - returns download error page information
     */

    public function get_download_error_page() {
        $this->do_download_error_page();
        return $this->c_download_error_page;
    }

  /**
   * get_review_page() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns review page information
   */

  public function get_review_page() {
    $this->do_review_page();
    return $this->c_review_page;
  }

  /**
   * get_review_error_page() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns review error page information
   */

   public function get_review_error_page() {
    $this->do_review_error_page();
    return $this->c_review_error_page;
   }

  /**
   * get_review_page() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns review page information
   */

  public function get_global_error_page() {
    $this->do_global_error_page();
    return $this->c_global_error_page;
  }

  /**
   * get_login_input_field_empty_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns login input error information
   */

  public function get_login_input_field_empty_form() {
    $this->do_login_input_field_empty_form();
    return $this->c_arr_login_field_empty_form;
  }

  /**
   * get_login_wrong_input_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns login wrong information error
   */

  public function get_login_wrong_input_form() {
    $this->do_login_wrong_input_form();
    return $this->c_arr_login_wrong_input_form;
  }

  /**
   * get_register_input_field_empty_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns register input error information
   */

  public function get_register_input_field_empty_form() {
    $this->do_register_input_field_empty_form();
    return $this->c_arr_register_field_empty_form;
  }

  /**
   * get_register_user_exists_form() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns user is registered form error
   */

  public function get_register_user_exists_form() {
    $this->do_register_user_exists_form();
    return $this->c_arr_register_user_exists_form;
  }

  /**
   * get_display_page_processed() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns information on the returned queries stored in database and displays it
   */

  public function get_display_page_processed() {
    return $this->c_display_page_processed;
  }

  /**
   * do_display_page_processing($p_metadata, $p_messages) sets meta and message information and does display processing which
   * is shown through the getter method as the results.
   *
   * @param - $p_metadata - passes the meta information
   * @param - $p_messages - passes the message information
   * @return - None
   */

  public function do_display_page_processing($p_metadata, $p_messages) {

      if(empty($p_messages))
      {
          $m_string = 'There are no message stored';
      }
      else
      {
          $i = 0;
          $arr[] = array();
          foreach ($p_metadata as $key1 => $value1) {
              $arr[$i] = $value1;
              $i++;
          }

          $i = 0;
          $m_string = '';
          foreach ($p_messages as $key => $value) {
              $m_string .= '<div class="messageContainer">';
              foreach ($value as $key2 => $value2){
                  $m_string .= '<p class="messages">' . $arr[$i] . ' ' . $value2 . '</p>';
                  $i++;
              }
              $m_string .= '</div> <br />';
              $i = 0;
          }
      }


      $this->c_display_page_processed = $m_string;

  }

  /*
   * Everything below are the content that makes up the HTML markup and is used within the getter methods
   */

  private function do_header() {
    $m_header = '';
    $m_header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $m_header .= '<meta http-equiv="Content-Language" content="en-gb" />';
    $m_header .= '<meta name="author" content="P14184295 P14166609" />';
    $m_header .= '<link rel=stylesheet href=' . $this->c_path . '/../css/reset.css type=text/css />';
    $m_header .= '<link rel=stylesheet href=' . $this->c_path . '/../css/style.css type=text/css />';
    $this->c_header = $m_header;
  }

  private function do_authentication_page_form() {
    $m_html_output = '';
    $m_html_output .= '<form method=' . 'get' . ' action=' . $this->c_path .'/process' . '>';
    $m_html_output .= '<h1>EE Client</h1>';
    $m_html_output .= '<p><button name="feature" value="login" autcomplete="off">Login</button></p> &nbsp;&nbsp;';
    $m_html_output .= '<p><button name="feature" value="register" autcomplete="off">Register</button></p>';
    $m_html_output .= '</form>';
    $this->c_authentication_page_form = $m_html_output;
  }

  private function do_login_form() {
    $m_html_output = '';
    $m_html_output = '<p id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output2 .= '<form method=post action=login enctype=multipart/form-data>';
    $m_html_output2 .= '<h1>Login</h1>';
    $m_html_output2 .= '<p>Username: <input type="text" name="username" /></p> <br />';
    $m_html_output2 .= '<p>Password: <input type="password" name="password" /></p> <br /><br />';
    $m_html_output2 .= '<p><input type="submit" name="submit" value="Submit" /></p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_login_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_register_form() {
    $m_html_output = '';
    $m_html_output = '<p id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output2 .= '<form method=post action=register enctype=multipart/form-data>';
    $m_html_output2 .= '<h1>EE Register</h1>';
    $m_html_output2 .= '<p>Username: <input type="text" name="reg_username"></p>  <br />';
    $m_html_output2 .= '<p>Password: <input type="password" name="reg_password"></p> <br />';
    $m_html_output2 .= '<p>E-mail: <input type="text" name="reg_email"></p> <br /><br />';
    $m_html_output2 .= '<p><input type="submit" value="Submit" name="submit"></p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_register_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_homepage_page_form() {
    $m_html_output = '';
    $m_html_output .= '<form method=get action=logout>';
    $m_html_output .= '<input type="submit" value="Logout">';
    $m_html_output .= '</form>';
    $m_html_output2 = '';
    $m_html_output2 .= '<form method=get action=process>';
    $m_html_output2 .= '<h1>Welcome to EE Client</h1>';
    $m_html_output2 .= '<h2>Select the below options so you can: </h2>';
    $m_html_output2 .= '<button name="feature" value="download_ee_form">Download EE Server Content</button> &nbsp;&nbsp;';
    $m_html_output2 .= '<h2> or </h2>';
    $m_html_output2 .= '<button name="feature" value="review_ee_form">Review EE Server Content</button>';
    $m_html_output2 .= '</form>';
    $this->c_arr_homepage_page_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_homepage_page_error_form() {
    $m_html_output = '';
    $m_html_output .= '<form method=get action=logout>';
    $m_html_output .= '<input type="submit" value="Logout">';
    $m_html_output .= '</form>';
    $m_html_output2 = '';
    $m_html_output2 .= '<p id=warning>Could not log you out, please try again !</p>';
    $m_html_output2 .= '<form method=get action=process>';
    $m_html_output2 .= '<h1>Welcome to EE Client</h1>';
    $m_html_output2 .= '<h2>Select the below options so you can: </h2>';
    $m_html_output2 .= '<button name="feature" value="download_ee_form">Download EE Server Content</button> &nbsp;&nbsp;';
    $m_html_output2 .= '<h2> or </h2>';
    $m_html_output2 .= '<button name="feature" value="review_ee_form">Review EE Server Content</button>';
    $m_html_output2 .= '</form>';
    $this->c_arr_homepage_page_error_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_download_page() {
    $m_html_output = '';
    $m_html_output .= '<form method=get action=downloaddata>';
    $m_html_output .= '<h1>Enter MSISDN:</h1>';
    $m_html_output .= '<p><input name="message-id" type="text" id="message-id" size="12" value="" maxsize="12"/></p>';
    $m_html_output .= '<p><input type="submit" /></p>';
    $m_html_output .= '</form>';
    $this->c_download_page = $m_html_output;
  }

  private function do_review_page() {
    $m_html_output = '';
    $m_html_output .= '<form method=get action=displayinformation>';
    $m_html_output .= '<h1>Enter MSISDN:</h1>';
    $m_html_output .= '<p><input name="message-id" type="text" id="message-id" size="12" value="" maxsize="12"/></p>';
    $m_html_output .= '<p><input type="submit" /></p>';
    $m_html_output .= '</form>';
    $this->c_review_page = $m_html_output;
  }

    private function do_download_error_page() {
        $m_html_output = '';
        $m_html_output .= '<p id=warning>Number entered is not correct, please try again !</p>';
        $m_html_output .= '<form method=get action=downloaddata>';
        $m_html_output .= '<h1>Enter MSISDN:</h1>';
        $m_html_output .= '<p><input name="message-id" type="text" id="message-id" size="12" value="" maxsize="12"/></p>';
        $m_html_output .= '<p><input type="submit" /></p>';
        $m_html_output .= '</form>';
        $this->c_download_error_page = $m_html_output;
    }

    private function do_review_error_page() {
        $m_html_output = '';
        $m_html_output .= '<p id=warning>Number entered is not correct, please try again !</p>';
        $m_html_output .= '<form method=get action=displayinformation>';
        $m_html_output .= '<h1>Enter MSISDN:</h1>';
        $m_html_output .= '<p><input name="message-id" type="text" id="message-id" size="12" value="" maxsize="12"/></p>';
        $m_html_output .= '<p><input type="submit" /></p>';
        $m_html_output .= '</form>';
        $this->c_review_error_page = $m_html_output;
    }

  private function do_global_error_page() {
    $m_html_output = '';
    $m_html_output .= '<p id="warning">Oops... Something went wrong, Please retry later</p>';
    $this->c_global_error_page = $m_html_output;
  }

  private function do_login_input_field_empty_form() {
    $m_html_output = '';
    $m_html_output = '<p id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output2 .= '<p id=warning>One of the input fields is empty, please try again !</p>';
    $m_html_output2 .= '<form method=post action=login enctype=multipart/form-data>';
    $m_html_output2 .= '<h1>Login</h1>';
    $m_html_output2 .= '<p>Username: <input type="text" name="username" /></p> <br />';
    $m_html_output2 .= '<p>Password: <input type="password" name="password" /></p> <br /><br />';
    $m_html_output2 .= '<p><input type="submit" name="submit" value="Submit" /></p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_login_field_empty_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_login_wrong_input_form() {
    $m_html_output = '';
    $m_html_output = '<p id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output2 .= '<p id=warning>Your information entered is wrong, please try again !</p>';
    $m_html_output2 .= '<form method=post action=login enctype=multipart/form-data>';
    $m_html_output2 .= '<h1>Login</h1>';
    $m_html_output2 .= '<p>Username: <input type="text" name="username" /></p> <br />';
    $m_html_output2 .= '<p>Password: <input type="password" name="password" /></p> <br /><br />';
    $m_html_output2 .= '<p><input type="submit" name="submit" value="Submit" /></p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_login_wrong_input_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_register_input_field_empty_form() {
    $m_html_output = '';
    $m_html_output = '<p id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output2 .= '<p id=warning>One of the fields is left empty, try again !</p>';
    $m_html_output2 .= '<form method=post action=register enctype=multipart/form-data>';
    $m_html_output2 .= '<h1>EE Register</h1>';
    $m_html_output2 .= '<p>Username: <input type="text" name="reg_username"></p>  <br />';
    $m_html_output2 .= '<p>Password: <input type="password" name="reg_password"></p> <br />';
    $m_html_output2 .= '<p>E-mail: <input type="text" name="reg_email"></p> <br /><br />';
    $m_html_output2 .= '<p><input type="submit" value="Submit" name="submit"></p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_register_field_empty_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_register_user_exists_form() {
    $m_html_output = '';
    $m_html_output = '<p id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output2 .= '<p id=warning>The information you entered is already being used, try again !</p>';
    $m_html_output2 .= '<form method=post action=register enctype=multipart/form-data>';
    $m_html_output2 .= '<h1>EE Register</h1>';
    $m_html_output2 .= '<p>Username: <input type="text" name="reg_username"></p>  <br />';
    $m_html_output2 .= '<p>Password: <input type="password" name="reg_password"></p> <br />';
    $m_html_output2 .= '<p>E-mail: <input type="text" name="reg_email"></p> <br /><br />';
    $m_html_output2 .= '<p><input type="submit" value="Submit" name="submit"></p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_register_user_exists_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

}
