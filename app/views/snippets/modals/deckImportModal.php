<div class="modal fade" id="deckImportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Import a decklist!</h5>
      </div>
      <div class="modal-body">
        <form id="deckImportForm" action='<?php echo URLROOT; ?>/users/importDeck' method='post'>
          <div class="form-group">
            <label for="title">Title</label>
            <input class="form-control" id='title-input' type="text" name="title">
            <span class='invalid-feedback' id='title-feedback'></span>
          </div>
          <div class="form-group">
            <label for="decklist">Import .dec (DeckedBuilder) file OR manually enter list below</label>
            <input class="form-control" type="file" id="deckImportFileUpload" accept=".dec">
            <textarea class="form-control" id="decklist-input" name="decklist" rows="8" cols="80"></textarea>
            <span class='invalid-feedback' id='decklist-feedback'></span>
          </div>
          <div class="form-group">
            <label for="description">Deck description</label>
            <textarea class="form-control" id='description-input' name="description" rows="8" cols="80" placeholder="Enter a description for your deck"></textarea>
            <span class='invalid-feedback' id='description-feedback'></span>
          </div>
          <div class="form-group">
            <input name="white" type="checkbox" class="checkbox-inline"> White</input>
            <input name="blue" type="checkbox" class="checkbox-inline"> Blue</input>
            <input name="black" type="checkbox" class="checkbox-inline"> Black</input>
            <input name="red" type="checkbox" class="checkbox-inline"> Red</input>
            <input name="green" type="checkbox" class="checkbox-inline"> Green</input>
          </div>
          <input type='submit' value='Import' class='btn btn-success btn-block'>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
