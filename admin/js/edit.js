
$(function() {
    const urlSearchParams = new URLSearchParams(window.location.search);
    const params = Object.fromEntries(urlSearchParams.entries()); 
    const fest = params['fest'];
    loadData(fest);

    


  $("#næste").click(function () {

    $(".form-2").css("display", "flex");
    $(".form-1").css("display", "none");
  })


  $("#tilbage").click(function () {

    $(".form-1").css("display", "flex");
    $(".form-2").css("display", "none");
  })

  function checkRequiredFields() {
    let requiredFields = $("#create_party input[required]");
    let valid = true;
    requiredFields.each(function () {
      if ($(this).val().trim() === "") {
        valid = false;
      }
    });
    return valid;

  }

  

function UpdateInfo() {
   
    let formData = $('#create_party').serializeArray();
     let jsonData = {};
     $.each(formData, function(index, field) {
    jsonData[field.name] = field.value;
  });

    $.ajax({
      url: 'ajax/edit-ajax-post.php',
      type: 'POST',
      contentType: 'application/json',
      data:  JSON.stringify(jsonData),


      
      success: function (data) {
        location.reload();
    },
    });
  }
  

  $("#confirm").click(function () {
    Swal.fire({
      title: "Er du sikker?",
      text: "Du er ved at opdatere den aktive fest",
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
            UpdateInfo();
      
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

  $("#slet").click(function () {
    Swal.fire({
      title: "Er du sikker?",
      text: "Du er ved at slette festen",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuller",
      confirmButtonText: "Ja",
    }).then((result) => {
      if (result.isConfirmed) {
        // Check if required fields are not empty before submitting the form
       
            slet();
      
       
      }
    });
  });


  $("#tilføj").click(function () {
    Swal.fire({
      title: "Er du sikker?",
      text: "Du er ved at tilføje en elev til festen",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuller",
      confirmButtonText: "Ja",
    }).then((result) => {
      if (result.isConfirmed) {
        // Check if required fields are not empty before submitting the form
        AddStudent();
    
      }
    });
  });

})



function slet() {
   
    $.ajax({
      url: 'ajax/edit-slet-ajax.php',
      type: 'POST',
    
      success: function (data) {
        
    },
    
    });
  }


function AddStudent() {
   
    let formData = $('#add_student').serializeArray();
     let jsonData = {};
     $.each(formData, function(index, field) {
    jsonData[field.name] = field.value;
  });
  console.log(formData);

    $.ajax({
      url: 'ajax/send-mail.php',
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(jsonData),
    
      success: function (data) {
        location.reload();
    },
    
    });
  }

function loadData(filters) {
    let f = {
      filter: filters
    }
    $.ajax({
      url: 'ajax/edit-ajax.php',
      type: 'POST',
      data: f,
      dataType: 'json',
   
      //on success empty the tablebody and append all the new items
      success: function (data) {
        console.log(data);
        // Check if data is empty
       $('#create_party #navn').attr('value', filters);
       $('#create_party #dato').attr('value', data[0]['Fest_start']);
       $('#create_party #drink').attr('value', data[0]['Drink_billetter']);
       $('#create_party #bstart').attr('value', data[0]['Billet_start']);
       $('#create_party #bslut').attr('value',  data[0]['Billet_slut']);
       $('#create_party #pris').attr('value',  data[0]['Standard_pris']);
       $('#create_party #tpris').attr('value',  data[0]['Tilbuds_pris']);
       $('#create_party #tdage').attr('value',  data[0]['Tilbuds_dage']);

        
      }
    })
}