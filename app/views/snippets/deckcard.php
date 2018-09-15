<?php $listId = 'cardlist-'.$deck->id; ?>
<div class='card'>
  <div class='card-body'>
    <h3 class='card-title'><?php echo $deck->title;?></h3>
    <p class='card-text'><?php echo $deck->description;?></p>
    <button class='btn btn-primary mb-2' type='button' data-toggle='collapse' data-target='#<?php echo $listId; ?>' aria-expanded='false' aria-controls='<?echo $listId;?>'>Show List</button>
    <div class='row'>
      <?php if($deck->white):?>
      <div class='col'>
        White
      </div>
      <?php endif;?>
      <?php if($deck->blue):?>
      <div class='col'>
        Blue
      </div>
      <?php endif;?>
      <?php if($deck->black):?>
      <div class='col'>
        Black
      </div>
      <?php endif;?>
      <?php if($deck->red):?>
      <div class='col'>
        Red
      </div>
      <?php endif;?>
      <?php if($deck->green):?>
      <div class='col'>
        Green
      </div>
      <?php endif;?>
    </div>
  </div>
  <div class='card-footer collapse' id='<?php echo $listId?>'>
    <?php echo $deck->list; ?>
  </div>
</div>
