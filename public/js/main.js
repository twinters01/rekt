/////////////////////////////////////////////////////////////////
//Deck Import Code
/////////////////////////////////////////////////////////////////

$(function(){
  //When the deck file gets uploaded, fill the text area with the file's contents
  $('#deckImportFileUpload').change(function(){
    //Define the file reader functionality
    let reader = new FileReader();
    reader.onload = function(progressEvent){
      document.getElementById("deckImportDecklist").innerText = this.result;
    }

    //Read the file
    let file = this.files[0];
    reader.readAsText(file);
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
      }
    }

    request.send(data);
  });
})
