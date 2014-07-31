<?php
/* from:
* http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html
*/
/*
Based on:
https://github.com/ericterpstra/ci_sock/tree/master/part_one/application
http://ericterpstra.com/2013/03/a-sample-codeigniter-application-with-login-and-session/
*/
class Login extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper('form');
    $this->load->model('user_model');
  }

  public function index() {

      if( $this->session->userdata('isLoggedIn') ) {
          redirect('/');
      } else {
          $this->show_login(false);
      }
  }

  public function show_login($show_error = false ) {

    $page = 'login';
    // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), $page);
    $data['error'] = $show_error;

    // Display
    $data['content'] = $this->load->view('pages/login', $data, TRUE);
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

    }

    public function login_user() {
        // Silently clear file cache
        $this->wrapper_model->clearCache();

        // Grab the email and password from the form POST
        $username = $this->security->xss_clean($this->input->post('username'));
        $pass  = $this->security->xss_clean($this->input->post('password'));

        //Ensure values exist for username and pass, and validate the user's credentials
        if( ($username && $pass) && ($this->user_model->validate_user($username,$pass) == true)) {
            // If the user is valid, show to login success page
               redirect('/login/login_success');

        } else {
            // Otherwise show the login screen with an error message.
            $this->show_login(true);
        }
    }

    // TODO finish adding registration (if needed)
    public function register_user() {
      $this->load->library('form_validation');

      $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|md5');
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        $page = 'registration';
        // Defaults
        $data = $this->wrapper_model->pageDefaults(array(), $page);

        // Display Registration form
        $data['content'] = $this->load->view('pages/register', $data, TRUE);
        $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
        $this->load->view('templates/htmltpl', $data);
      } else {
        // TODO check and clean data. add new user to database.
      }
    }

    public function login_success() {
      $page = 'successful';
      // Defaults
      $data = $this->wrapper_model->pageDefaults(array(), $page);

      // Display
      $data['content'] = $this->load->view('pages/loginsuccess', $data, TRUE);
      $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
      $this->load->view('templates/htmltpl', $data);
    }

    public function logout_user() {
      $this->session->sess_destroy();
      $this->index();
    }

    public function showphpinfo() {
        echo phpinfo();
    }
}





