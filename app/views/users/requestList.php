<?php require APPROOT.'/views/inc/header.php';?>
  <div class='row'>
    <div class='col-md-6 mx-auto'>
      <div id='test' class='card card-body bg-light mt-5'>
        <?php flash('feedback_flash');?>
        <h2>Pending Requests</h2>
        <?php if(empty($data['friendRequests'])): ?>
          <p> No Pending Requests </p>
        <?php else:?>
          <?php foreach($data['friendRequests'] as $request):?>
            <?php require APPROOT.'/views/snippets/friendRequest.php';?>
          <?php endforeach;?>
        <?php endif;?>
      </div>
    </div>
  </div>
<?php require APPROOT.'/views/inc/footer.php';?>
