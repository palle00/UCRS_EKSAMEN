$(document).ready(function() {

  const urlSearchParams = new URLSearchParams(window.location.search);
  const params = Object.fromEntries(urlSearchParams.entries()); 
  const fest = params['fest'];


  if($.isEmptyObject(fest))
  {
     loadEvents();
  }
  else
  {  
  
     loadEvent(fest);
  }

  //Check the input of #search and #sort 
  //runs the corresponding function with the values from the form
  $('.search').on('input', function() {
    searchFor($(this).val().toLowerCase());
  });
  
  $('#sort').on('change', function() {
    loadEvents($(this).val());

    
  });
});


//Recieves value from #search 
//check if it is set or empty
function searchFor(input) {
  //if #search is empty return
  if (input == '') {
      $('#event_current tbody').children().show();
      return;
  }

  //get the table aand tablebody and find all the children that contains the £navn id
  $('#event_current tbody').children().each(function () {
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

//Use ajax to get the data from the database using a specific filter we get from #sort
function loadEvents(filters) {
  let f = {
    filter: filters
  }
  $.ajax({
    url: 'ajax/ajax.php',
    type: 'POST',
    contentType: 'application/json',
    data:  JSON.stringify(f),
    dataType: 'json',

    
    //on success empty the tablebody and append all the new items
    success: function(data) {
      console.log(data);
        $('#event_current tbody').empty();
        $.each(data, function() {
        $('#event_current tbody').append(
          $('<tr>').attr('onclick', 'location.href="overblik?fest='+this.Navn+'"').append(
            $('<td>').text(this.Navn).attr("id", "navn"),
            $('<td>').text(this.Fest_start),
            $('<td>').text(this.tilmeldinger_count),
            $('<td>').text(this.deltager_count),
            $('<td>').text(this.pris)
          )
        );
      });
    },
    //when completed apply the #search again so it show up correctly
    complete: function() {
      $('#search').trigger('input');
    }
  });

}


  function loadEvent(filters) {
    let f = {
      data: filters
    }

    $.ajax({
      url: 'ajax/ajax-fest.php',
      type: 'POST',
      data: f,
      dataType: 'json',
  
      //on success empty the tablebody and append all the new items
      success: function(data) {
          $indtjening = 0;
          $tilmeldte = 0;
          $deltager = 0;
          $('.prim').css("display", "none");
          $('.øko').css("display", "block");
          $('.title_card h1').text(filters);
          $('#event_current tbody').empty();
          $.each(data, function() {
            $deltager += this.Deltog,
            $indtjening += this.Billet_pris,
            $tilmeldte++
            if (this.Deltog == 1) {
              $mødt = 'Ja';
            } else {
              $mødt = 'Nej';
            }
          $('#event_current tbody').append(
            $('<tr>').append(
              $('<td>').text(this.Elev_navn).attr("id", "navn"),
              $('<td>').text(this.Email),
              $('<td>').text(this.Klasse),
              $('<td>').text($mødt),
              $('<td>').text(this.Drink_billetter),
              $('<td>').text(this.Billet_pris),
            
            )
          );
        });
        $('#tilmeldte').text($tilmeldte);
        $('#indtjening').text($indtjening +'Kr');
        $fravær = $tilmeldte - $deltager; 
        go($deltager, $fravær);
      },
      error: function()
      {loadEvents();},
    });

  }


  function go(show, noshow)
{
  console.log(show + " | "+noshow);
//Define the values for the chart
var xValues = ["", ""];
var yValues = [show, noshow];
var barColors = ["#4C4C8D", "#2D2D3B"];

//Calculate the maxIndex sich in this case is always show
var doughnutSizes = yValues.map(value => value === Math.max(...yValues) ? 15 : 10);

//use the chart plugin to create a text in the middle of the chart that shows the % of students that showed up
Chart.plugins.register({
afterDatasetsDraw: function(chart) {
  var ctx = chart.ctx;
  var sum = 0;
  yValues.forEach(function(value) {
    sum += value;
  });
  var percentage = Math.floor(show / sum * 100) + "%";
  var fontSize = chart.width / 11;
  ctx.font = fontSize + "px Arial";
  ctx.fillStyle = "#ffffff";
  ctx.textBaseline = "middle";
  var text = percentage;
  var textX = Math.round((chart.width - ctx.measureText(text).width) / 2);
  var textY = chart.height / 1.95;
  ctx.fillText(text, textX, textY);
}
});


//create a Doughnut that shows the before defined x and y values
new Chart("myChart", {
type: "doughnut",
data: {
  labels: xValues,
  datasets: [{
    backgroundColor: barColors,
    data: yValues,
    doughnutSizes: doughnutSizes
  }]
},
options: {
  title: {
    display: false,
  },
  legend: {
    display: false,
  },
  elements: {
    arc: {
      borderWidth: 0
    }
  },
  plugins: {
    datalabels: {
      display: false,
    }
  }
}
});
}

