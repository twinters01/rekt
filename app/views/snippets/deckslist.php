<div class='container'>
  <div class='col'>
    <h2 class='title'>Decks</h2>
      <?php if(empty($decks)): ?>
        <p> No decks found</p>
      <?php else:?>
          <?php foreach($decks as $deck):?>
            <div class='row mb-2'>
              <div class='col'>
                <?php require APPROOT.'/views/snippets/deckcard.php'; ?>
              </div>
            </div>
          <?php endforeach;?>
      <?php endif;?>
    <?php if(isset($data['isLoggedInProfile']) && $data['isLoggedInProfile']):?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#deckImportModal">Import Deck</button>
    <?php endif;?>
  </div>
</div>
