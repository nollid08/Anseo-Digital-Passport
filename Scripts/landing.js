/* This sets a custom css property that gets  
    the viewport Height excluding the scrollbars */
window.addEventListener('resize', () => {
	let vh = window.innerHeight * 0.01;
	document.documentElement.style.setProperty('--vh', `${vh}px`);
});

// This function opens the sidenav when the hamburer btn is clicked
function openNav() {
	document.getElementById("mySidenav").style.width = "250px";
	document.getElementById("logo").style.display = "none";
}

// This function closes the sidenav when the X btn is clicked
function closeNav() {
	document.getElementById("mySidenav").style.width = "0";
	document.getElementById("logo").style.display = "block";

}

//This is the code that submits the form
var form = document.getElementById("contactForm");
form.addEventListener('submit', e => {
	// Prevent the default form behaviour
	e.preventDefault();
	// UrlSearchParams are used to send the data to PHP via fetch
	var data = new URLSearchParams();
	var dataLength = 0;
	//Append the users sign in status to the data
	data.append("signInStatus", "False");
	// Looping through the form data
	for (var p of new FormData(form)) {
		// Check to make sure that the form data is not empty
		if (p[1] != "") {
			// Create a new regular expression
			var regex = new RegExp("^[a-zA-Záéíóú0-9 \s @.€$£()/:]+$");

			/* Make sure that the form data complies with the regular
			expression so that their are no rouge character */
			if (regex.test(p[1])) {
				// Clear the error prompt
				document.getElementById(p[0] + "Error").innerText = "";
				// Add the form data to the urlSearchParams that are going to be sent to PHP
				data.append(p[0], p[1]);
				//Increment the dataLength by one
				dataLength++;
			} else {
				// Regular Expresion was not matched so output error
				document.getElementById(p[0] + "Error").innerText = "Only letters, brackets, whitespace, currency symbols, @ , :, / and . are allowed";
				/* Make the margin above to submit btn smaller to 
				   accomadate the space that the error will take up */
				document.getElementById("submitBtn").style.marginTop = '1vh';
			}

		} else {
			// Form input was empty matched so output error
			document.getElementById(p[0] + "Error").innerText = "This Is A Required Field";
			/* Make the margin above to submit btn smaller to 
			   accomadate the space that the error will take up */
			document.getElementById("submitBtn").style.marginTop = '1vh';
		}
	}
	// If the form passed all the verifiction tests
	if (dataLength == 3) {
		// Reset the from
		form.reset();

		// Post the data to the server using fetch
		fetch('PHP/contact.php', {
			method: 'POST',
			body: data
		}).then(
			/* The form data is also checked in PHP incase that someone edits the 
			JS and removes the validation. So the JS validation is not neccesary 
			but it takes some load off of the server 
			We are now going to display those errors to the user */

			//convert the response to text
			response => response.json()
		).then(response => {
			const errors = response;

			// If there are errors
			if (errors.length != 0) {
				// Seperate all the errors and loop through them
				for (i = 0; i < errors.length; i++) {
					// Get the error from the array
					const error = errors[i];
					// Get the error message
					const message = errors[i].slice(error.indexOf("|") + 1);
					// Get the error target
					const messageTarget = error.slice(0, error.indexOf("|")).toLowerCase();
					// Put the error message in the message target
					document.getElementById(messageTarget + "Error").innerText = message;
					/* Make the margin above to submit btn smaller to 
				    accomadate the space that the error will take up */
					document.getElementById("submitBtn").style.marginTop = '1vh';
				}

			}
		}).catch(
			// If there is an error while fetching log it to the console
			error => console.log(error)
		);
	}
});