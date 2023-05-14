$(document).ready(function () {
  loadEvents();

  //Check the input of #search and #sort 
  //runs the corresponding function with the values from the form
  $('#search').on('input', function () {
    searchFor($(this).val().toLowerCase());
  });


  //check all the checkboxes 
  $(document).on('change', '#check-all', function () {
    if (this.checked) {
      $("input[type='checkbox']").prop('checked', true);
    } else {
      $("input[type='checkbox']").prop('checked', false);
    }
  });


  //on click push all the checkbox names to an array and give it to the delete_codes function
  $('#delete-selected').click(function () {
    var selected = [];

    Swal.fire({
      title: "Er du sikker?",
      text: "Du er ved at at slette elev-koder",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuller",
      confirmButtonText: "Ja",
    }).then((result) => {
      if (result.isConfirmed) {
        // Check if required fields are not empty before submitting the form
        $("input[type='checkbox']:checked").each(function () {
          selected.push($(this).attr('name'));
        });

        delete_codes(selected);

      }
    });



  });

  //Do an ajax call and reload the page when deleted
  function delete_codes(names) {
    $.ajax({
      type: "POST",
      url: "ajax/elev-delete.php",
      data: { selected: names },
      success: function () {

        // Reload the page after successful deletion
        window.location.href = window.location.href;
      },
      error: function () {
        // Handle error case
      }
    })
  };



  //Recieves value from #search 
  //check if it is set or empty
  function searchFor(input) {

    //if #search is empty return
    if (input == '') {
      $('#elev_kode tbody').children().show();
      return;
    }

    //get the table aand tablebody and find all the children that contains the £navn id
    $('#elev_kode tbody ').children().each(function () {
      let navn = $(this).children().filter('#Kode').text().toLowerCase();

      //if the child startsWith the input letter show the elemente
      //else hide it
      if (navn.startsWith(input)) {
        $(this).show();
      }
      else {
        $(this).hide();
      }
    })
  };

  //Use ajax to get the data from the database using a specific filter we get from #sort
  function loadEvents(filters) {
    let f = {
      filter: filters
    }
    $.ajax({
      url: 'ajax/elev-ajax.php',
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(f),
      dataType: 'json',

      //on success empty the tablebody and append all the new items
      success: function (data) {
        $('#delete-selected').css("display", "block");
        $('#elev_kode tbody').empty();
        $('#elev_kode tbody').append(
          $('<tr>').append(
            $('<input>').attr("id", "check-all").attr("type", "checkbox").attr("name", "all"),
          )
        );


        //display all the checkboxes, give them the name of the kode so when deleting we can just pull the name 
        $.each(data, function () {
          $('#elev_kode tbody').append(
            $('<tr>').append(
              $('<input>').attr("id", "delete").attr("type", "checkbox").attr("name", this.Kode),
              $('<td>').text(this.Kode).attr("id", "Kode"),
            )
          );
        });
      },
    });
  }

});
