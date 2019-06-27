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
   * get_send_messgae_page() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns review page information
   */

  public function get_send_message_page() {
    $this->do_send_message_page();
    return $this->c_send_page;
  }

    /**
   * get_circuit_board_page() retrieves the form information that is used within tags in the Template.
   *
   * @param - None
   * @return - returns review page information
   */

  public function get_circuit_board_page() {
    $this->do_circuit_board_page();
    return $this->c_send_page;
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
          $m_string = 'No messages are stored.';
      }
      else
      {
          $i = 0;
          $arr[] = array();
          $tab_output = '
            <table class="table table-dark table-responsive table-hover">
              <thead>
                <tr>
          ';
          foreach ($p_metadata as $key1 => $value1) {
              $arr[$i] = $value1;
              $tab_output .= '<th scope="col">'. $value1 .'</th>';
              $i++;
          }

          $tab_output .= '</tr></thead><tbody>';
          $i = 0;
          // $m_string = '';

          foreach ($p_messages as $key => $value) {
              $tab_output .= '<tr>';
              foreach ($value as $key2 => $value2){
                  $tab_output .= '<td>' . $value2 . '</td>';
                  $i++;
              }
              $tab_output .= '</tr>';
              $i = 0;
          }
          $tab_output .= '</tbody></table><br /><br />';
      }


      $this->c_display_page_processed = $tab_output;

  }

  /*
   * Everything below are the content that makes up the HTML markup and is used within the getter methods
   */

  private function do_header() {
    $m_header = '';
    $m_header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $m_header .= '<meta http-equiv="Content-Language" content="en-gb" />';
    // $m_header .= '<link rel=stylesheet href=' . $this->c_path . '/../css/reset.css type=text/css />';
    // $m_header .= '<link rel=stylesheet href=' . $this->c_path . '/../css/style.css type=text/css />';
    $this->c_header = $m_header;
  }

  private function do_authentication_page_form() {
    $m_html_output = '';
    $m_html_output .= '<form method=' . 'get' . ' action=' . $this->c_path .'/process' . '>';
    $m_html_output .= '<h1 class="display-1">EE Client</h1><br>';
    $m_html_output .= '<p class="lead">Choose an option: </p>';
    $m_html_output .= '<p class="lead"><button class="btn btn-success" name="feature" value="login" autcomplete="off">Login</button></p> &nbsp;&nbsp;';
    $m_html_output .= '<p class="lead"><button class="btn btn-primary" name="feature" value="register" autcomplete="off">Register</button></p>';
    $m_html_output .= '</form>';
    $this->c_authentication_page_form = $m_html_output;
  }

  private function do_login_form() {
    $m_html_output = '';
    $m_html_output = '<p class="lead" id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output2 .= '<form method=post action=login enctype=multipart/form-data>';
    $m_html_output2 .= '<h1 class="display-4">Login</h1>';
    $m_html_output2 .= '<p class="lead">Username: <input class="form-control" type="text" name="username" /></p> <br />';
    $m_html_output2 .= '<p class="lead">Password: <input class="form-control" type="password" name="password" /></p> <br /><br />';
    $m_html_output2 .= '<button type="submit" class="btn btn-primary" name="submit" value="Submit">Log In</button>';
    $m_html_output2 .= '</form>';
    $this->c_arr_login_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_register_form() {
    $m_html_output = '';
    $m_html_output = '<p class="lead" id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output2 .= '<form method=post action=register enctype=multipart/form-data>';
    $m_html_output2 .= '<h1 class="display-4">EE Register</h1>';
    $m_html_output2 .= '<p class="lead">Username: <input class="form-control" type="text" name="reg_username"></p>  <br />';
    $m_html_output2 .= '<p class="lead">Password: <input class="form-control" type="password" name="reg_password"></p> <br />';
    $m_html_output2 .= '<p class="lead">E-mail: <input class="form-control" type="text" name="reg_email"></p> <br /><br />';
    $m_html_output2 .= '<button type="submit" class="btn btn-success" value="Submit" name="submit">Register</button>';
    $m_html_output2 .= '</form>';
    $this->c_arr_register_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_homepage_page_form() {
    $m_html_output = '';
    $m_html_output .= '<form method=get action=logout>';
    $m_html_output .= '<p class="lead" class="lead">Do you wish to log out?</p>';
    $m_html_output .= '<button class="btn btn-danger" type="submit" value="Logout">Logout</button>';
    $m_html_output .= '</form>';
    $m_html_output .= '<br><br>';

    $m_html_output2 = '';
    $m_html_output2 .= '<form method=get action=process>';
    $m_html_output2 .= '<h5 class="display-4">Welcome to the  EE-M2M Connect Client!</h5>';
    $m_html_output2 .= '<p class="lead">There are three options presented below. Kindly select one: </p>';
    $m_html_output2 .= '<button class="btn btn-success extend" name="feature" value="download_ee_form">Download content from the EE-Connect Server</button> &nbsp;&nbsp;';
    $m_html_output2 .= '<p class="lead">OR</p>';
    $m_html_output2 .= '<button class="btn btn-success extend"  name="feature" value="review_ee_form">Review Content from the EE-Connect Server</button>';
    $m_html_output2 .= '<p class="lead">OR </p>';
    $m_html_output2 .= '<button class="btn btn-success extend"  name="feature" value="send_ee_message">Send Message VIA EE-Connect</button>';
    $m_html_output2 .= '</form>';
    $this->c_arr_homepage_page_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_homepage_page_error_form() {
    $m_html_output = '';
    $m_html_output .= '<form method=get action=logout>';
    $m_html_output .= '<p class="lead" class="lead">Do you wish to log out?</p>';
    $m_html_output .= '<button class="btn btn-danger" type="submit" value="Logout">Logout</button>';
    $m_html_output .= '</form>';
    $m_html_output .= '<br><br>';
    $m_html_output2 = '';
    $m_html_output2 .= '<div class="alert alert-danger" role="alert">
    Couldn\'t log you out. Apologies, try again.
    </div>';
    $m_html_output2 .= '<form method=get action=process>';
    $m_html_output2 .= '<h5 class="display-4">Welcome to the  EE-M2M Connect Client!</h5>';
    $m_html_output2 .= '<p class="lead">There are three options presented below. Kindly select one: </p>';
    $m_html_output2 .= '<button class="btn btn-success extend" name="feature" value="download_ee_form">Download content from the EE-Connect Server</button> &nbsp;&nbsp;';
    $m_html_output2 .= '<p class="lead">OR</p>';
    $m_html_output2 .= '<button class="btn btn-success extend"  name="feature" value="review_ee_form">Review Content from the EE-Connect Server</button>';
    $m_html_output2 .= '<p class="lead">OR </p>';
    $m_html_output2 .= '<button class="btn btn-success extend"  name="feature" value="send_ee_message">Send Message VIA EE-Connect</button>';
    $m_html_output2 .= '</form>';
    $this->c_arr_homepage_page_error_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_download_page() {
    $m_html_output = '';
    $m_html_output .= '<form method=get action=downloaddata>';
    $m_html_output .= '<h1 class="display-4">Download Messages</h1>';
    $m_html_output .= '<p class="lead">Enter MSISDN: </p>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="message-id" type="text" id="message-id" size="12" value="" maxsize="12"/></p>';
    $m_html_output .= '<button  type="submit" class="btn btn-success">Download Messages</button</p>';
    $m_html_output .= '</form>';
    $this->c_download_page = $m_html_output;
  }

  private function do_review_page() {
    $m_html_output = '';
    $m_html_output .= '<form method=get action=displayinformation>';
    $m_html_output .= '<h1 class="display-4">Enter MSISDN:</h1>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="message-id" type="text" id="message-id" size="12" value="" maxsize="12"/></p>';
    $m_html_output .= '<p class="lead"><button class="btn btn-success" type="submit" class="btn btn-primary">Review Downloaded Messages</button</p>';
    $m_html_output .= '</form>';
    $this->c_review_page = $m_html_output;
  }

  private function do_send_message_page() {
    $m_html_output = '<div class="container">';
    $m_html_output .= '<form method=get action=sendMessage>';
    $m_html_output .= '<h1 class="display-4">Enter the following information correctly to send a message: </h1>';
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter MSISDN:</p>';
    $m_html_output .= '<input class="form-control" class="form-control" name="message-id" type="text" id="message-id" size="12" value="447817814149" maxsize="12"/>';
    $m_html_output .= '</div>';

    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of S1:</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="s1-val" type="text" id="s1-val"/></p>';
    $m_html_output .= '</div>';

    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of S2:</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="s2-val" type="text" id="s2-val"/></p>';
    $m_html_output .= '</div>';
    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of S3:</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="s3-val" type="text" id="s3-val"/></p>';
    $m_html_output .= '</div>';
    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of S4:</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="s4-val" type="text" id="s4-val"/></p>';
    $m_html_output .= '</div>';
    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of "Fan":</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="fan-val" type="text" id="fan-val"/></p>';
    $m_html_output .= '</div>';
    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of FRW:</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="frw-val" type="text" id="frw-val"/></p>';
    $m_html_output .= '</div>';
    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of REV:</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="rev-val" type="text" id="rev-val"/></p>';
    $m_html_output .= '</div>';
    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of H:</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="h-val" type="text" id="h-val"/></p>';
    $m_html_output .= '</div>';
    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of Temp:</h5>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="temp-val" type="text" id="temp-val"/></p>';
    $m_html_output .= '</div>';
    
    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Enter the value of Key:</p>';
    $m_html_output .= '<p class="lead"><input class="form-control" name="key-val" type="text" id="key-val"/></p>';
    $m_html_output .= '</div>';
    
    // $m_html_output .= '<p class="lead"><input class="form-control" name="main-message" type="text" id="main-message"/></p>';


    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<div class="input-group mb-3">';
    $m_html_output .= '<p class="lead" class="lead">Select your delivery report status: </h5>';
    $m_html_output .= '<div class="input-group-text">';
    $m_html_output .= '<input type="checkbox" id="delivery-report" name="deliver-report" >';
    $m_html_output .= '</div>';
    $m_html_output .= '</div>';
    $m_html_output .= '</div>';


    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<p class="lead" class="lead">Message Bearer: </h5>';
    $m_html_output .= '<select class="custom-select" name="msg-bearer" id="msg-bearer"><option value="" selected>Default</option><option value="SMS">SMS</option><option value="GPRS">Non-urgent GPRS</option><option value="UGRPS">Urgent GPRS</option></select>';
    $m_html_output .= '</div>';

    $m_html_output .= '<div class="form-group">';
    $m_html_output .= '<button type="submit" class="btn btn-success">Submit</button';
    $m_html_output .= '</div>';

    $m_html_output .= '</form>';
    $m_html_output .= '</div>';
    $this->c_send_page = $m_html_output;
  }


  private function do_circuit_board_page() {
    $m_html_output = '';
    $m_html_output .= '<table id="circuit" style="width:100%">';
    $m_html_output .= '<tr><th>Board Option</th><th>Status</th></tr>';
    $m_html_output .= '<tr><td>Device MSISDN</td><td id="DESTINATIONMSISDN"></td></tr>';
    $m_html_output .= '<tr><td>Last Updated At</td><td id="RECEIVEDTIME"></td></tr>';

    $m_html_output .= '<tr><td>Switch 1</td><td id="S1"></td></tr>';
    $m_html_output .= '<tr><td>Switch 2</td><td id="S2"></td></tr>';
    $m_html_output .= '<tr><td>Switch 3</td><td id="S3"></td></tr>';
    $m_html_output .= '<tr><td>Switch 4</td><td id="S4"></td></tr>';

    $m_html_output .= '<tr><td>Fan</td><td id="F"></td></tr>';
    $m_html_output .= '<tr><td>Direction</td><td id="D"></td></tr>';
    $m_html_output .= '<tr><td>Heater</td><td id="H"></td></tr>';
    $m_html_output .= '<tr><td>Temperature</td><td id="P"></td></tr>';
    $m_html_output .= '<tr><td>Last Key Pressed</td><td id="K"></td></tr>';


    $m_html_output .= '</table>';

    $m_html_output .= '<div id="btn-wrapper"><button id="btn" class="btn btn-warning">Update Circuit</button></div>';

    $m_html_output .= '<div id="chart"></div>';

    $m_html_output .= '<div id="message-form"></div>';

    
    $this->c_send_page = $m_html_output;
  }

    private function do_download_error_page() {
        $m_html_output = '';
        $m_html_output .= '<div class="alert alert-danger" role="alert">
        Couldn\'t download the messages!
        </div>';
        $m_html_output .= '<form method=get action=downloaddata>';
        $m_html_output .= '<h1 class="display-4">Enter MSISDN:</h1>';
        $m_html_output .= '<p class="lead"><input class="form-control" name="message-id" type="text" id="message-id" size="12" value="" maxsize="12"/></p>';
        $m_html_output .= '<p class="lead"><button class="btn btn-success" type="submit" class="btn btn-primary">Download Messages</button</p>';
        $m_html_output .= '</form>';
        $this->c_download_error_page = $m_html_output;
    }

    private function do_review_error_page() {
        $m_html_output = '';
        $m_html_output .= '<div class="alert alert-danger" role="alert">
        Incorrect number was added. Try doing that again?
      </div>';
      $m_html_output .= '<form method=get action=displayinformation>';
      $m_html_output .= '<h1 class="display-4">Enter MSISDN:</h1>';
      $m_html_output .= '<p class="lead"><input class="form-control" name="message-id" type="text" id="message-id" size="12" value="" maxsize="12"/></p>';
      $m_html_output .= '<p class="lead"><button class="btn btn-success" type="submit" class="btn btn-primary">Review Downloaded Messages</button</p>';
      $m_html_output .= '</form>';
        $this->c_review_error_page = $m_html_output;
    }

  private function do_global_error_page() {
    $m_html_output = '';
    $m_html_output .= '<div class="alert alert-danger" role="alert">
        Something bad just happened and the system couldn\'t figure it out. Retry please.
        </div>';
    $this->c_global_error_page = $m_html_output;
  }

  private function do_login_input_field_empty_form() {
    $m_html_output = '';
    $m_html_output = '<p class="lead" id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output .= '<div class="alert alert-danger" role="alert">
    One of the login fields is empty. Please try again!
    </div>';
    $m_html_output2 .= '<form method=post action=login enctype=multipart/form-data>';
    $m_html_output2 .= '<h1 class="display-4">Login</h1>';
    $m_html_output2 .= '<p class="lead">Username: <input class="form-control" type="text" name="username" /></p> <br />';
    $m_html_output2 .= '<p class="lead">Password: <input class="form-control" type="password" name="password" /></p> <br /><br />';
    $m_html_output2 .= '<p class="lead"><button class="btn btn-success" type="submit" name="submit" value="Submit">Login</button</p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_login_field_empty_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_login_wrong_input_form() {
    $m_html_output = '';
    $m_html_output = '<p class="lead" id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output .= '<div class="alert alert-danger" role="alert">
    No such user found. Did you enter the right credentials? Try registering otherwise.
    </div>';    
    $m_html_output2 .= '<form method=post action=login enctype=multipart/form-data>';
    $m_html_output2 .= '<h1 class="display-4">Login</h1>';
    $m_html_output2 .= '<p class="lead">Username: <input class="form-control" type="text" name="username" /></p> <br />';
    $m_html_output2 .= '<p class="lead">Password: <input class="form-control" type="password" name="password" /></p> <br /><br />';
    $m_html_output2 .= '<p class="lead"><button class="btn btn-success" type="submit" name="submit" value="Submit">Login</button</p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_login_wrong_input_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_register_input_field_empty_form() {
    $m_html_output = '';
    $m_html_output = '<p class="lead" id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output .= '<div class="alert alert-danger" role="alert">
    One of the register fields are empty. Please fill all fields.
    </div>';    
    $m_html_output2 .= '<form method=post action=register enctype=multipart/form-data>';
    $m_html_output2 .= '<h1 class="display-4">EE Register</h1>';
    $m_html_output2 .= '<p class="lead">Username: <input class="form-control" type="text" name="reg_username"></p>  <br />';
    $m_html_output2 .= '<p class="lead">Password: <input class="form-control" type="password" name="reg_password"></p> <br />';
    $m_html_output2 .= '<p class="lead">E-mail: <input class="form-control" type="text" name="reg_email"></p> <br /><br />';
    $m_html_output2 .= '<p class="lead"><button class="btn btn-success" type="submit" value="Submit" name="submit">Register</button</p>';
    $m_html_output2 .= '</form>';
    $this->c_arr_register_field_empty_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

  private function do_register_user_exists_form() {
    $m_html_output = '';
    $m_html_output = '<p class="lead" id="ret_home"><a href="' . $this->c_path . '">&#8592; Return Home</a></p>';
    $m_html_output2 = '';
    $m_html_output .= '<div class="alert alert-danger" role="alert">
    A user with the same credentials already exists. Try registering yourself again.
    </div>';      $m_html_output2 .= '<form method=post action=register enctype=multipart/form-data>';
    $m_html_output2 .= '<h1 class="display-4">EE Register</h1>';
    $m_html_output2 .= '<p class="lead">Username: <input class="form-control" type="text" name="reg_username"></p>  <br />';
    $m_html_output2 .= '<p class="lead">Password: <input class="form-control" type="password" name="reg_password"></p> <br />';
    $m_html_output2 .= '<p class="lead">E-mail: <input class="form-control" type="text" name="reg_email"></p> <br /><br />';
    $m_html_output2 .= '<p class="lead"><button class="btn btn-success" type="submit" value="Submit" name="submit">Register</button</p>';
    $m_html_output2 .= '</form>';
    
    $this->c_arr_register_user_exists_form = array('html_output' => $m_html_output, 'html_output2' => $m_html_output2);
  }

}
