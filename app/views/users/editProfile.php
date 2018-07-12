<?php require APPROOT.'/views/inc/header.php';?>
  <div class='row'>
    <div class='col-md-6 mx-auto'>
      <div class='card card-body bg-light mt-5'>
        <h2>Edit Profile</h2>

        <form action = '<?php echo URLROOT; ?>/users/editProfile' method='post'>
          <div class='form-group'>
            <label for='username'>Username: <sup>*</sup></label>
            <input type='text' name='username' class='form-control form control-lg <?php echo (!empty($data['username_err']))?'is-invalid':'';?>'>
            <span class='invalid-feedback'><?php echo $data['username_err']; ?></span>
          </div>
          <div class='form-group'>
            <label for='name'>Name: </label>
            <input type='text' name='name' class='form-control form control-lg <?php echo (!empty($data['name_err']))?'is-invalid':'';?>'>
            <span class='invalid-feedback'><?php echo $data['name_err']; ?></span>
          </div>
          <div class='form-group'>
            <label for='email'>Email: <sup>*</sup></label>
            <input type='email' name='email' class='form-control form control-lg <?php echo (!empty($data['email_err']))?'is-invalid':'';?>'>
            <span class='invalid-feedback'><?php echo $data['email_err']; ?></span>
          </div>
          <div class='form-group'>
            <label for='name'>Password: <sup>*</sup></label>
            <input type='password' name='password' class='form-control form control-lg <?php echo (!empty($data['password_err']))?'is-invalid':'';?>'>
            <span class='invalid-feedback'><?php echo $data['password_err']; ?></span>
          </div>
          <div class='form-group'>
            <label for='name'>Confirm password: <sup>*</sup></label>
            <input type='password' name='confirm_password' class='form-control form control-lg <?php echo (!empty($data['confirm_password_err']))?'is-invalid':'';?>'>
            <span class='invalid-feedback'><?php echo $data['confirm_password_err']; ?></span>
          </div>

          <div class='row'>
            <div class='col'>
              <input type='submit' value='Register' class='btn btn-success btn-block'>
            </div>
            <div class='col'>
              <a href='<?php echo URLROOT;?>/users/profile' class='btn btn-light btn-block'>Update Profile</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require APPROOT.'/views/inc/footer.php';?>
