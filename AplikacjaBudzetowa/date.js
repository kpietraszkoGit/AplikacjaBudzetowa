function today()
{
		let d = new Date();
		let currDate = d.getDate();
		let currMonth = d.getMonth()+1;
		let currYear = d.getFullYear();
				
		document.getElementById("days").value = currYear + "-" + ((currMonth<10) ? '0'+currMonth : currMonth )+ "-" + ((currDate<10) ? '0'+currDate : currDate );
}

//przycisk menu
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

//wykres kolowy
anychart.onDocumentReady(function() {

  // set the data
  var data = [
      {x: "white", value: 223553265},
      {x: "Black or African American", value: 38929319},
      {x: "American Indian and Alaska Native", value: 2932248},
      {x: "Asian", value: 14674252},
      {x: "Native Hawaiian and Other Pacific Islander", value: 540013},
      {x: "Some Other Race", value: 19107368},
      {x: "Two or More Races", value: 9009073}
  ];

  // create the chart
  var chart = anychart.pie();


  // add the data
  chart.data(data);

  // display the chart in the container
  chart.container('container');
  chart.draw();

});