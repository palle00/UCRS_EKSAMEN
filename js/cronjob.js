$(function()
{
   

    $.ajax({
        type: "POST",
        url: "ajax/cronjob.php",
        dataType: 'json',
        success: function(data) {

            
        
            var startDate = new Date(data[0]['Fest_start']).toDateString();
            console.log(startDate);

            var now = new Date();
            now.setDate(now.getDate() + 1);
            now = now.toDateString();
            console.log(now);

            if(now => startDate)
            {
                console.log("yes");
                window.location = "https://ucrs.implex.dk/cronjob-send-mail.php";
            }
        


        }
    })


});