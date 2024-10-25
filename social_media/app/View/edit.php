// application/views/profiles/edit.php

<h1>Edit Profile</h1>
<form method="post" action="<?php echo site_url('profile/update'); ?>">
    <!-- Form fields for editing personal details -->
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $this->session->userdata('name'); ?>">
    </div>
    <!-- ... -->
    <