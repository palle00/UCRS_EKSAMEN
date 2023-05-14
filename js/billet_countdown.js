//gets the date from the server, using json as a storage medium
$.ajax({
  url: "ajax/getdata.php",
  dataType: "json",
  success: function(data) {
    
    if(data == 0)
    { 
      $(".ticket").hide();
      $(".countdown-section").css('display', 'flex');
      $("#wrapper").css('display', 'flex');
      $(".countdown-section p").text('Der er på nuværende tidspunkt ingen billetter til salg');
      return;
    }
  
      var lastSaleDate = new Date(data[0]['Billet_slut']);
      var countdownDate = new Date(data[0]['Billet_start']);
      function startCountdown() {
          // Calculate time remaining until countdown date and time
          var now = new Date().getTime();
          var distance = countdownDate - now;
          var distanceLast = lastSaleDate - now;
       
   			console.log(distance);

          if (distance > 0) {
              $(".ticket").css('display', 'none');
              $(".countdown-section").css('display', 'flex');
              $("#wrapper").css('display', 'flex');
              $(".countdown-section p").text('Billet salg åbner om');
          } else if(distanceLast < 0) {
            $(".ticket").hide();
            $(".countdown-section").css('display', 'flex');
            $("#wrapper").css('display', 'flex');
            $(".countdown-section p").text('Der er på nuværende tidspunkt ingen billetter til salg');
            return;
          }
          else
          {
            $(".ticket").css('display', 'flex');
              return;
          }
          // Calculate days, hours, minutes, and seconds remaining
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

          // Update countdown clock
          var countdown = $("#countdown");
          countdown.text(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");

          // Update countdown clock every second
          setInterval(function() {
              now = new Date().getTime();
              distance = countdownDate - now;
              days = Math.floor(distance / (1000 * 60 * 60 * 24));
              hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              seconds = Math.floor((distance % (1000 * 60)) / 1000);
              countdown.text(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
          }, 1000);
      }
      startCountdown(); // Start countdown automatically
  }
});