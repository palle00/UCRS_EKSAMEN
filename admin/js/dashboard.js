$(document).ready(function () {
  // Function to check if all required fields are not empty
  function checkRequiredFields() {
    let requiredFields = $("input[required]");
    let valid = true;
    requiredFields.each(function () {
      if ($(this).val().trim() === "") {
        valid = false;
      }
    });
    return valid;

  }

  $("#næste").click(function () {

    $(".form-2").css("display", "flex");
    $(".form-1").css("display", "none");
  })


  $("#tilbage").click(function () {

    $(".form-1").css("display", "flex");
    $(".form-2").css("display", "none");
  })


  //Save the image data so we can display it in the preview later
  var imageBlob = null;
  $("#Image").change(function () {
    var reader = new FileReader();
    reader.onload = function (event) {
      imageBlob = new Blob([event.target.result], { type: 'image/webp' });
    };
    reader.readAsArrayBuffer(this.files[0]);
  });

  $("#forhånd").click(function () {
    var formData = new FormData($("#create_party")[0]);
    if (imageBlob) {
      formData.append("Image", imageBlob, "image.jpg");
    }
    
    var url = "forhånd.html?";
    for (var pair of formData.entries()) {
      if (pair[0] != 'Image') {
        url += encodeURIComponent(pair[0]) + "=" + encodeURIComponent(pair[1]) + "&";
      }
    }
    if (imageBlob) {
      var imageUrl = URL.createObjectURL(imageBlob);
      url += "Image=" + encodeURIComponent(imageUrl);
    }
    window.open(url, "_blank");
  });



  // Click handler for the confirmation button
  $("#confirm").click(function () {
    Swal.fire({
      title: "Er du sikker?",
      text: "Du er ved at oprette en fest",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuller",
      confirmButtonText: "Ja, opret festen",
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
});


function go(show, noshow) {
  //Define the values for the chart
  var xValues = ["", ""];
  var yValues = [show, noshow];
  var barColors = ["#4C4C8D", "#2D2D3B"];


  //use the chart plugin to create a text in the middle of the chart that shows the % of students that showed up
  Chart.plugins.register({
    afterDatasetsDraw: function (chart) {
      var ctx = chart.ctx;
      var sum = 0;
      yValues.forEach(function (value) {
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
        data: yValues
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





