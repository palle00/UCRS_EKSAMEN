$(function()
{
   

    $.ajax({
        type: "POST",
        url: "ajax/index-ajax.php",
        dataType: 'json',
        success: function(data) {

            console.log(data[1]['Navn']);
            var startDate = new Date(data[0]['Billet_start']);
            var slutDate = new Date(data[0]['Billet_slut']);
            var tilbudsDage = data[0]['Tilbuds_dage'];
            var festDate = new Date(data[0]['Fest_start']);
       

            //Convert the date to danish dd-MM-yyyy instead of USA MM-dd-yyyy
            var formattedStartDate = festDate.toLocaleDateString('da-DK', {day: '2-digit', month: '2-digit', year: 'numeric'});

            // Calculate what the end date of a sale would be
                 var now = new Date();
               
                 var totalMilliseconds = startDate.getTime() + (tilbudsDage * 24 * 60 * 60 * 1000);
                countdownDate = new Date(totalMilliseconds);

                var distance = countdownDate;

                //Display the correct information
                if (distance > now && slutDate > now) {
                    $('#pris').css('text-decoration', 'line-through')
                              .css('font-size','.8rem')
                              .css('color', '#363636').text(data[0]['Standard_pris']+'kr');
                    $('#sale').css('display','block').text(data[0]['Tilbuds_pris']+'kr');
                    $('#fest-type').text('Gymnasie fest');
                    $('#fest-dato').text(formattedStartDate);
                    $('#navn').html('Gymnasie fest <br> Med <br>'+data[0]['Navn']);
                    $('#img').css('background-image', 'url(Header/'+data[1]['Navn']+')');
                    startCountdown(); // Start countdown automatically
                
                }
                else if (startDate < now)
                {
                    $('#pris').text(data[0]['Standard_pris']+'kr');
                    $('#fest-type').text('Gymnasie fest');
                    $('#fest-dato').text(formattedStartDate);
                    $('#navn').html('Gymnasie fest <br> Med <br>'+data[0]['Navn']);
                    $('#img').css('background-image', 'url(Header/'+data[1]['Navn']+')');
                  
                }
                else
                {
                    $('#fest-type').text(' - ');
                    $('#fest-dato').text(' - ');
                
                }
                function startCountdown() {
      
                // Update countdown clock every second
                setInterval(function() {
                    now = new Date().getTime();
                    distance = countdownDate - now;
                    days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    $("#tid-tilbage").text('Tilbuds pris udløber om: '+days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
                }, 1000);
            }
            
        }
        
      
      })


});