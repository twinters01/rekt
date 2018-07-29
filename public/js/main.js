/////////////////////////////////////////////////////////////////
//Deck Import Code
/////////////////////////////////////////////////////////////////

$(function(){
  bootstrap_alert = function(message,c = "alert-success"){
      $('#alert_placeholder').html('<div class="alert '+c+'"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
  }

  //When the deck file gets uploaded, fill the text area with the file's contents
  $('#deckImportFileUpload').change(function(){
    //Define the file reader functionality
    let reader = new FileReader();
    reader.onload = function(progressEvent){
      //TODO find out how to clear the existing file after it is read
      document.getElementById("deckImportDecklist").value = '';
      document.getElementById("deckImportDecklist").value = this.result;
    }

    //Read the file
    let file = this.files[0];
    reader.readAsText(file);

    //Reset the input
    this.value = '';
  });

  $('#deckImportForm').submit(function(event){
    event.preventDefault();

    //Target
    let url = event.target.action;
    //Data
    let data = $('#deckImportForm').serialize();

    let request = new XMLHttpRequest();
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    request.onload = function(){
      if(this.status == 200){
        //TODO handle error messages
        console.log(JSON.parse(this.response));

        bootstrap_alert('Success!', "alert alert-success");

        document.getElementById('deckImportForm').reset();
        document.getElementById('deckImportDecklist').value='';
        $('#deckImportModal').modal('hide');
      }
    }

    request.send(data);
  });
})
