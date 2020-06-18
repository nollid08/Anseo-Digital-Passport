const config = {
	apiKey: "AIzaSyBDCFdhuDKGa8ipCGqZ-w-aZVQypOLH7FI",
	authDomain: "login-for-waw.firebaseapp.com",
	databaseURL: "https://login-for-waw.firebaseio.com",
	projectId: "login-for-waw",
	storageBucket: "login-for-waw.appspot.com",
	messagingSenderId: "53721053369"
};

// Initialize Firebase
firebase.initializeApp(config);
// When the window loads, verify that the user is logged in
window.addEventListener('load', () => {
	// Check to make sure that the user is signed in
	firebase.auth().onAuthStateChanged((user) => {
			// If the user is signed in
			if (user) {
				// Save their name, photo url and uid as variables
				const displayName = user.displayName;
				const photoURL = user.photoURL;
				const uid = user.uid;

				// Create references to the DOM and save them as variables
				const tableOutput = document.getElementById("write");
				const profilePicImg = document.getElementById('profilePic');
				const nameTitle = document.getElementById('name');
				const uniqueLogsTitle = document.getElementById("uniqueLogs")
				const logAmountTitle = document.getElementById("logAmount")

				/* This variable is 1 if the user is on a phone and 0 if 
				a user is on a pc. If the user is on onMobile 
				do not set aside titles */
				let onMobile;

				// The count of logs. Defaults to 0
				let logCount = 0;
				// An array for unique logs
				let uniqueLogsArray = [];

				/* Check to see if the user is on a onMobile or 
				PC and set onMobile variable */
				if (window.matchMedia("(max-width: 992px)").matches) {
					// Set the onMobile variable to 1 as the user is on onMobile
					onMobile = 1;
				} else {
					// Set the onMobile variable to 0 as the user is on PC
					onMobile = 0;
					// If the user has a profile pic
					if (photoURL !== null) {
						// Set the profile pic
						profilePicImg.src = photoURL;
					}
					// Set the name title
					nameTitle.innerText = displayName;
				}

				// Retrieve all logs from the DB
				$.ajax({
					type: "POST",
					url: 'PHP/passport.php',
					data: {
						UID: uid,
						onMobile: onMobile
					},
					success: function (data) {
						// Output the log table
						tableOutput.innerHTML = (data);
						// Select all table rows
						const rows = document.querySelectorAll("tr[data-href]");

						// Loop through each log
						rows.forEach( (row) => {

							// Turn each row into a link
							row.addEventListener("click", () => {
								/* Get the log id of each row from the href 
								data attribute and send them to the log viewer 
								for that id */
								window.location.href = "logviewer.html?" +
									row.dataset.href
							})

							// If the user is on Desktop
							if (onMobile == 0) {
								// Increment the logs amount by one
								logCount++;

								let DiscoveryPointName = row.firstChild.innerHTML;
								
								// If the log is already in the unique logs array
								if (uniqueLogsArray.includes(DiscoveryPointName)) {
									return
								} else {
									// If not, add it to the array
									uniqueLogsArray.push(DiscoveryPointName)
								}
								uniqueLogsTitle.innerHTML =
									uniqueLogsArray.length + "/162 Unique Logs"
							}
						})

						// Set the log amount title
						if (onMobile == 0) {
							logAmountTitle.innerHTML = logCount + " Logs";
						}
					}
				});

			} else {
				// The user is not signed in so send them back to the landing page
				window.location.href = "index.html";
			}
		},
		(error) => {
			// Log the error to the console
			console.log(error);
		});
});