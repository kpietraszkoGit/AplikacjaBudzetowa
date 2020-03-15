function today()
{
		let d = new Date();
		let currDate = d.getDate();
		let currMonth = d.getMonth()+1;
		let currYear = d.getFullYear();
				
		document.getElementById("days").value = currYear + "-" + ((currMonth<10) ? '0'+currMonth : currMonth )+ "-" + ((currDate<10) ? '0'+currDate : currDate );
		document.getElementById("days2").value = currYear + "-" + ((currMonth<10) ? '0'+currMonth : currMonth )+ "-" + ((currDate<10) ? '0'+currDate : currDate );
}
  
//przycisk menu
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
//function myFunction() {
 // document.getElementById("myDropdown").classList.toggle("show");
//}

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
