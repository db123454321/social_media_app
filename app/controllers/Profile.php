class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Profile_model');
    }

    public function edit()
    {
        // Load the profile edit view
        $this->load->view('profiles/edit');
    }

    public function update()
    {
        // Update the user's profile
        $this->Profile_model->update_profile();
        redirect('profile/edit');
    }
}