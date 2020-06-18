// Firebase config
const config = {
	apiKey: "AIzaSyBDCFdhuDKGa8ipCGqZ-w-aZVQypOLH7FI",
	authDomain: "login-for-waw.firebaseapp.com",
	databaseURL: "https://login-for-waw.firebaseio.com",
	projectId: "login-for-waw",
	storageBucket: "login-for-waw.appspot.com",
	messagingSenderId: "53721053369"
};

// Create reference to the DOM
const form = document.getElementById("contactForm");
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const commentInput = document.getElementById("commentData");
const submitBtn = document.getElementById("submitBtn");

const shrinkForm = () => {
	// Shrink the form inputs smaller to accomadate the error size
	commentInput.style.height = '15vh';
	submitBtn.style.marginTop = '1vh';
	submitBtn.style.fontSize = '6.5vh';
}
// Initialize Firebase
firebase.initializeApp(config);

// When the window loads, verify that the user is logged in
window.addEventListener('load', () => {
	//This Checks If The User Is Logged In Or Logged Out
	firebase.auth().onAuthStateChanged((user) => {
		if (user) {
			// The user is signed in
			// Get the user name and email
			const displayName = user.displayName;
			const email = user.email;

			// Set the users name and email
			nameInput.value = displayName;
			emailInput.value = email;

			// Event listener for form submit
			form.addEventListener('submit', e => {
				// Prevent the default submit behaviour
				e.preventDefault();

				// This var stores the data to be sent to PHP
				const data = new URLSearchParams();
				// Append the Sign in status to data
				data.append("signInStatus", "True");
				// This counts the amount of inputs that were filled out
				let validInputCounter = 0;
				// Loop through each form input
				for (const input of new FormData(form)) {
					// If the input is not empty
					if (input[1] != "") {
						/* Create a new regular expression to 
						only allow certain characters */
						const regex = new RegExp("^[a-zA-Záéíóú0-9 \s @.€$£()/:]+$");

						// If the input matches the regular expression
						if (regex.test(input[1])) {
							// 	Clear any error prompts
							document.getElementById(input[0] + "Error").innerText = "";
							// Append the input to the data
							data.append(input[0], input[1]);
							// Increment the valid input counter
							validInputCounter++;
						} else {
							// If the regex did not match
							// Create an error prompt
							document.getElementById(input[0] + "Error").innerText = "Only letters, brackets, whitespace, currency symbols, @ , :, / and . are allowed";
							shrinkForm()
						}

					} else {
						// If the input is empty
						// Create an error prompt
						document.getElementById(input[0] + "Error").innerText = "This Is A Required Field";
						shrinkForm()
					}
				}
				// If all the inputs are valid
				if (validInputCounter == 3) {
					// Reset the form
					form.reset();

					// Set the name and email inputs
					nameInput.value = displayName;
					emailInput.value = email;

					/* 
					Send the data to the server

					While previously I have used Jquery's Ajax, this 
					time I am using/trialing fetch. This is because In the future I
					want to eliminate bootstrap and Jquery from the site for
					speed and optimization
					*/
					fetch('PHP/contact.php', {
							method: 'POST',
							// Send the urlSearchParams contained in the data var
							body: data
					}).then(
						/* The form data is also checked in PHP incase that someone edits the 
						JS and removes the validation. So the JS validation is not neccesary 
						but it takes some load off of the server 
						We are now going to display those errors to the user */
						
						// Convert the response to JSON
						response => response.json()
					).then(response => {
						const errors = response;
						// If there are errors
						if (errors.length != 0) {
							// Loop through each error
							for (i = 0; i < errors.length; i++) {
								// Get the error from the array
								const error = errors[i];
								// Get the error message
								const message = errors[i].slice(error.indexOf("|") + 1);
								// Get the error target
								const messageTarget = error.slice(0, error.indexOf("|")).toLowerCase();
								// Put the error message in the message target
								document.getElementById(messageTarget + "Error").innerText = message;
								// Shrink the form to accomadate the size of the error
								shrinkForm()
							}
						}
					})
					.catch(
						// Log the error to the console
						error => console.log(error)
					);
				}
			});

		} else {
			// The user is not signed in so send them back to the landing page
			window.location.href = "index.html";
		}
	}, (error) => {
		// Log the error to the console
		console.log(error);
	});
});