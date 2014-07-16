<?php


class user_model extends CI_Model {

    var $details;

    public function validate_user($username, $password) {
        // Build a query to retrieve the user's details
        // based on the received username and password
        // Bindings are autoescaped by CI.

      $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
      $query = $this->db->query($sql, array($username, sha1($password)));

      if ($query->num_rows() > 0) {
            $login = $query->result_array();
            // Set the all of the users details into the $details property of this class
            $this->details = $login[0];
            // Call set_session to set the user's session vars via CodeIgniter
            $this->set_session();
            return true;
      }

    return false;
  }

    public function set_session() {
        // session->set_userdata is a CodeIgniter function that
        // stores data in CodeIgniter's session storage.  Some of the values are built in
        // to CodeIgniter, others are added.  See CodeIgniter's documentation for details.

        $this->session->set_userdata( array(
                'id'=>$this->details['id'],
                'username'=>$this->details['username'],
                'isAdmin'=>$this->details['isAdmin'],
                'isLoggedIn'=>true
            )
        );
    }

    public function create_new_user( $userData ) {
      $data['username'] = $userData['username'];
      $data['isAdmin'] = (int) $userData['isAdmin'];
      $data['password'] = sha1($userData['password1']);

      return $this->db->insert('user',$data);
    }

/*    public function update_tagline( $user_id, $tagline ) {
      $data = array('tagline'=>$tagline);
      $result = $this->db->update('user', $data, array('id'=>$user_id));
      return $result;
    }*/

}
