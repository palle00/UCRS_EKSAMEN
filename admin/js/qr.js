
var lastResult;
var qrArray;
var $err = 'Billetten er ugyldig';
$(function()
{
  
  let config = {
    fps: 10,
    qrbox: {width: 200, height: 200},
    rememberLastUsedCamera: true,
    // Only support camera scan type.
    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
  };
  
  let html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", config, /* verbose= */ false);
  html5QrcodeScanner.render(onScanSuccess);

  
  $('#search').on('input', function() {
    searchFor($(this).val().toLowerCase());
  });
  
  $('#sort').on('change', function() {
    DisplayList($(this).val());
  });

  $('#list').click(function() {
    DisplayList();
  });

  $('.repeat').click(function() {
    Swal.fire({
      title: "Er du sikker?",
      text: "Du er ved at Genåbne festen i 20 minutter",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuller",
      confirmButtonText: "Ja",
    }).then((result) => {
      if (result.isConfirmed) {
        Repeat();
       
        }
      } 
    );
  
  });



  $('#list-items').on("click", "tr", function()  {

   if($(this).find('td:nth-child(3)').text()== "Nej")
   {
    Swal.fire({
      title: "Er du sikker?",
      text: "Du er ved at registrere en elev som ankommet",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuller",
      confirmButtonText: "Ja",
    }).then((result) => {
      if (result.isConfirmed) {
         register($(this).find('td:first()').text(),$(this).find('td:nth-child(2)').text());
         DisplayClose();
         DisplayList();
        }
      } 
    );
  }
  });

   
   


  $('#list-close').click(function() {
    DisplayClose();
  });
  
$('#scan-another').click(function() {
  lastResult = null;
  $('#qr-reader-results').empty();
  $('#qr-reader').css('display', 'block')
});

});

function register(navn, klasse)
{
  
    let f = {
      navn: navn,
      klasse: klasse
    }
    $.ajax({
      url: 'ajax/qr-register-ajax.php',
      type: 'POST',
      data: f,
      dataType: 'json',
  
      //on success empty the tablebody and append all the new items
      success: function(data) {
        $fremmødt = 0;
        $total = 0;
          $('#list-items tbody').empty();
          $.each(data, function() {
            if (this.Deltog == 1) {
              $mødt = 'Ja';
              $fremmødt++;
            } else {
              $mødt = 'Nej';
            }
            $total++;
          $('#list-items tbody').append(
            $('<tr>').append(
              $('<td>').text(this.Elev_navn).attr("id", "navn"),
              $('<td>').text(this.Klasse),
              $('<td>').text($mødt),            
            )
          )
            })
            $('#list-view #amount').text(
              $fremmødt+"/"+$total);
      },
    });
  }



function onScanSuccess(decodedText) {

  if (decodedText !== lastResult) {
    lastResult = decodedText;
    qrArray = atob(decodedText).split(",");
    validate(qrArray);
    html5QrcodeScanner.clear();
  }
}

function validate(data)
{
  $.ajax({
    type: "POST",
    url: "ajax/qr-ajax.php",
    data: {data: data},
    success: function(data) {

      if(data.length != 0)
      {
      var parsedData = JSON.parse(data);
      if(parsedData[0].Deltog == 1)
      {
        $err = 'Billet er allerede brugt';
      }
    }

      if(data.length == 0 || parsedData[0].Deltog == 1)
      {
        $('#qr-reader').css('display', 'none');
        $('#qr-reader-results').empty();
        $('#qr-reader-results').append(
        $('<i>').attr("class", "fa-solid fa-circle-xmark"),   
        $('<p>').text($err)
      );

      setTimeout(function() {
        $('#qr-reader-results  i').css('color', '#bd3239');
      }, 1);
      }
      else
      {

        
      $('#qr-reader').css('display', 'none');
      $('#qr-reader-results').empty();
      $('#qr-reader-results').append(
        $('<i>').attr("class", "fa-solid fa-circle-check"),
        $('<p>').text('Navn: '+qrArray[1]),
        $('<p>').text('Klasse: '+qrArray[2]),
        $('<p>').text(qrArray[3])
      );

      setTimeout(function() {
        $('#qr-reader-results i').css('color', '#32bd76');
      }, 1);

      $.ajax({
        type: "POST",
        url: "ajax/ajax-fest-deltog.php",
        data: {data: qrArray}
      })

      }
       
  
    },
    error: function() {
      console.log('err');
    }
  })
};


function DisplayList(filters)
{
  
    let f = {
      data: filters
    }
    $.ajax({
      url: 'ajax/qr-list-ajax.php',
      type: 'POST',
      data: f,
      dataType: 'json',
  
      //on success empty the tablebody and append all the new items
      success: function(data) {
        $fremmødt = 0;
        $total = 0;
          $('#list-items tbody').empty();
          $.each(data, function() {
            if (this.Deltog == 1) {
              $mødt = 'Ja';
              $fremmødt++;
            } else {
              $mødt = 'Nej';
            }
            $total++;
          $('#list-items tbody').append(
            $('<tr>').append(
              $('<td>').text(this.Elev_navn).attr("id", "navn"),
              $('<td>').text(this.Klasse),
              $('<td>').text($mødt),            
            )
          )
            })
            $('#list-view #amount').text(
              $fremmødt+"/"+$total);
      },
    });
   

  $('#list-view').css('display', 'flex')

}

function DisplayClose()
{
  $('#list-view').css('display', 'none')
}


function searchFor(input) {

  //if #search is empty return
  if (input == '') {
      $('#list-items tbody').children().show();
      return;
  }

  //get the table aand tablebody and find all the children that contains the £navn id
  $('#list-items tbody').children().each(function () {
      let navn = $(this).children().filter('#navn').text().toLowerCase();

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



function Repeat()
{
    $.ajax({
      url: 'ajax/extend-ajax.php',
      type: 'POST',
    });
}