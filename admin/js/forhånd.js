$(function() {
    var params = new URLSearchParams(window.location.search);
    console.log(params);
    
    $('#navn').html("Gymnasie Fest <br> Med <br>"+params.get("navn"));
    $('#fest-type').text("Gymnasie fest");
    $('#fest-dato').text(params.get("Fest_start"));
    $('#pris').text(params.get("Standard_pris")+"kr");
    $('#img').css("background-image", "url("+params.get("Image")+")")
  
   
  });