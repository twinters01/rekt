<div class='card'>
  <div class='card-body'>
    <h5 class="card-title">
      <?php echo $request->sender_username;?>
    </h5>
    <div class='card-text'>
      <div class="row">
        <div class="col text-left">
          <p><?php echo $request->sender_name;?></p>
        </div>
        <div class="col text-right">
          <p><?php echo date_format(date_create($request->request_date), 'M/d/Y');?></p>
        </div>
      </div>
      <div class="row ml-1">
        <button class = "btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Respond
        </button>
        <div class='dropdown-menu'>
          <a class='dropdown-item' href="<?php echo URLROOT;?>/requests/acceptFriend/<?php echo $request->requestId;?>">Accept</a>
        </div>
      </div>
    </div>
  </div>
</div>
