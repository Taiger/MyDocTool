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

  function index() {

      if( $this->session->userdata('isLoggedIn') ) {
          redirect('/');
      } else {
          $this->show_login(false);
      }
  }

  function show_login($show_error = false ) {

    $data['error'] = $show_error;

    //print_r($this->session->all_userdata());

    $this->load->helper(array('form', 'url'));

      $page = 'login';
      $data['current_page'] = $page;
      $data['body_class'] = $page . '-page';
      $data['body_class'] .= ' form-page';
      $data['title'] = ucfirst($page); // Capitalize the first letter

      // Display
      //$this->load->view('login', $data);
/**/      $data['content'] = $this->load->view('login', $data, TRUE);
      $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
      $this->load->view('templates/htmltpl', $data);
     
    }

    function login_user() {
      //die('login_user');
        // Create an instance of the user model
        $this->load->model('user_model');

        // Grab the email and password from the form POST
        $username = $this->input->post('username');
        $pass  = $this->input->post('password');

        //Ensure values exist for username and pass, and validate the user's credentials
        if( ($username && $pass) && ($this->user_model->validate_user($username,$pass) == true)) {
            // If the user is valid, show to login success page
               redirect('/login/login_success');
     
        } else {
            // Otherwise show the login screen with an error message.
            $this->show_login(true);
        }
    }

    // TODO add registeration
    function register_user() {
      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');

      $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|md5');
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run() == FALSE) {
        $page = 'registeration';
        $data['current_page'] = $page;
        $data['body_class'] = $page . '-page';
        $data['body_class'] .= ' form-page';
        $data['title'] = ucfirst($page); // Capitalize the first letter

        // Display Registration form
        $data['content'] = $this->load->view('login', $data, TRUE);
        $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
        $this->load->view('templates/htmltpl', $data);
      } else {
        // TODO add new user
      }
    }

    function login_success() {
      $page = 'successful';
      $data['current_page'] = $page;
      $data['body_class'] = $page . '-page';
      $data['body_class'] .= ' form-page';
      $data['title'] = ucfirst($page); // Capitalize the first letter
      //$data['styles'] = array('login'=> '/css/login.css');

      // Display
      $data['content'] = $this->load->view('loginsuccess', $data, TRUE);
      $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
      $this->load->view('templates/htmltpl', $data);
    }

    function logout_user() {
      $this->session->sess_destroy();
      $this->index();
    }

    function showphpinfo() {
        echo phpinfo();
    }
}





