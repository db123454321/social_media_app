// application/models/Profile_model.php

class Profile_model extends CI_Model
{
    public function update_profile()
    {
        // Update the user's profile in the database
        $this->db->update('users', array('name' => $this->input->post('name')));
    }
}