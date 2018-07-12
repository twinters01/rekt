<div class='card'>
  <div class='card-body'>
    <h1 class='card-title'><?php echo $presentingUser->username;?></h1>
    <div class='card-text'>
      <p>Name: <?php echo $presentingUser->name;?></p>
      <p>Email: <?php echo $presentingUser->email;?></p>
      <a href='<?php echo URLROOT;?>/views/users/editProfile' class='btn btn-primary' role='button'>Edit Profile</a>
    </div>
  </div>
</div>
