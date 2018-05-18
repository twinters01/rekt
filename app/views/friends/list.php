<?php require APPROOT.'/views/inc/header.php';?>
  <div class='row'>
    <div class='col-md-6 mx-auto'>
      <div id='test' class='card card-body bg-light mt-5'>
        <?php flash('feedback_flash');?>
        <h2>Friends</h2>
        <?php if(empty($data['friends'])): ?>
          <p> No friends :( </p>
        <?php else:?>
          <?php foreach($data['friends'] as $friend):?>
            <?php require APPROOT.'/views/snippets/friendCard.php';?>
          <?php endforeach;?>
        <?php endif;?>
      </div>
      <form action = '<?php echo URLROOT;?>/friends/add' method='post'>
        <div class='input-group mt-1'>
          <input type='text' name='username' class='form-control' aria-describedby="basic-addon2">
          <div class='input-group-append'>
            <button type='submit' class='btn btn-success'>Add Friend</button>
          </div>
        </div>
      </form>
    </div>
  </div>

<?php require APPROOT.'/views/inc/footer.php';?>
