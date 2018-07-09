$(function(){
  $('#deckImportFileUpload').change(function(){
    //Define the file reader functionality
    let reader = new FileReader();
    reader.onload = function(progressEvent){
      document.getElementById("deckImportDecklist").innerText = this.result;
    }

    //Read the file
    let file = this.files[0];
    reader.readAsText(file);
  })
})
