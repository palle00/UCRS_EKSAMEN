$(function()
{

    //Change 
    $click ="";
    $('#event_current').on('click', 'i', function () {
        $click = $(this);
        if($(this).closest("tr i").parent().attr("class") != "Active")
        {
            $(this).closest("tr").children().each(function(){
                    if($(this).attr("id") != "icon")
                    {
                        if($(this).attr("id") != "rolle")
                        {
                            let $input = $("<td>").append($("<input>").attr("value", $(this).text()))
                            $("<p style='display: none;'>").text( $(this).text()).appendTo($input); 
                            $(this).replaceWith($input);
                        }
                        else{
                            let $select = $("<td>").attr("id", "rolle").append($("<select>"));
                            $("<option>").text("Super").attr("value", "Super").appendTo($select.find("select")); 
                            $("<option>").text("Multi").attr("value", "Multi").appendTo($select.find("select")); 
                            $("<option>").text("QR").attr("value", "QR").appendTo($select.find("select")); 
                            $("<p style='display: none;'>").text($(this).text()).appendTo($select); 
                            $(this).replaceWith($select);
                        }
                    }
                    else{
                        $(this).attr("class", "Active");
                    }
            });
        }
        else
        {
            Swal.fire({
                title: "Er du sikker?",
                text: "Du er ved at ændre på en bruger",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ja",
                cancelButtonColor: "#d33",
                cancelButtonText: "Annuller",
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Ja was clicked");
                    change();
                } else {
                    console.log("Annuller was clicked");
                    annuller();
                }
            });
            
            }


            

            function change()
            {
               
            let values = [];
            let originalValues = [];
            $click.closest("tr").children().each(function(){
                if($(this).attr("id") != "icon")
                {
                    if($(this).attr("id") != "rolle")
                        {
                            let $input = $("<td>").text($(this).children().first().val());
                            originalValues.push($(this).children().last().text());
                            values.push($(this).children().first().val());
                            $(this).replaceWith($input);
                        }
                        else{
                            let $input = $("<td>").attr("id", "rolle").text($(this).children().first().val());
                            originalValues.push($(this).children().last().text());
                            values.push($(this).children().first().val());
                            $(this).replaceWith($input);
                        }
                }
                else{
                    $(this).removeClass();
                }
            }); 
            UpdateInfo(originalValues[0], values[0], values[1], values[2]);
        }
 
    })

    function annuller()
    {

    $click.closest("tr").children().each(function(){
        if($(this).attr("id") != "icon")
        {
            if($(this).attr("id") != "rolle")
            {
                console.log($(this));
                let $input = $("<td>").text($(this).children().first().val());
                $(this).replaceWith($input);
            }
            else{
                console.log($(this));
                let $input = $("<td>").attr("id", "rolle").text($(this).children().first().val());
                $(this).replaceWith($input);
            }
        }
        else{
            $(this).removeClass();
        }
    }); 

}



function UpdateInfo(origNavn, navn, kode, rolle) {
    let f = {
        origNavn: origNavn,
        navn: navn,
        kode: kode,
        rolle: rolle
    }
    console.log(f);
    $.ajax({
      url: 'ajax/kontoer-ajax.php',
      type: 'POST',
      data: f,
  
      success: function() {
      
      },
    });
  }
  


  //create
  function checkRequiredFields() {
    let requiredFields = $("input[required]");
    let valid = true;
    requiredFields.each(function() {
      if ($(this).val().trim() === "") {
        valid = false;
      }
    });
    return valid;
  }

  // Submit handler for the form
  $("form").submit(function(event) {
    // Prevent the form from submitting if required fields are empty
    if (!checkRequiredFields()) {
      event.preventDefault();
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Udfyld venligst alle felter",
      });
    }
  });
  // Click handler for the confirmation button
  $("#opret_bruger").click(function() {
    Swal.fire({
      title: "Er du sikker?",
      text: "Du er ved at oprette en bruger",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuller",
      confirmButtonText: "Ja",
    }).then((result) => {
      if (result.isConfirmed) {
        // Check if required fields are not empty before submitting the form
        if (checkRequiredFields()) {
          $("form").submit();
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Udfyld venligst alle felter",
          });
        }
      } 
    });
  });
})