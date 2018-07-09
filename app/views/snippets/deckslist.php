<div class='card'>
  <div class='card-body'>
    <h2 class='card-title'>Decks</h2>
    <div class='card-text'>
      <?php if(empty($decks)): ?>
        <p> No decks found</p>
      <?php else:?>
        <?php foreach($decks as $deck):?>
          <p>Placeholder for deck</p>
        <?php endforeach;?>
      <?php endif;?>
      <?php if(isset($data['isLoggedInProfile']) && $data['isLoggedInProfile']):?>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#deckImportModal">Import Deck</button>
      <?php endif;?>
    </div>
  </div>
</div>
