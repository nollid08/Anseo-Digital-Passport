//Firbase config
const config = {
	apiKey: "AIzaSyBDCFdhuDKGa8ipCGqZ-w-aZVQypOLH7FI",
	authDomain: "login-for-waw.firebaseapp.com",
	databaseURL: "https://login-for-waw.firebaseio.com",
	projectId: "login-for-waw",
	storageBucket: "login-for-waw.appspot.com",
	messagingSenderId: "53721053369"
};

// Create references to the DOM
const nameTitle = document.getElementById("name");
const emailTitle = document.getElementById("email");
const logsTitle = document.getElementById("logs");
const profileImg = document.getElementById("profilePic");
const logOutBtn = document.getElementById("logOutBtn");
const allLogsBtn = document.getElementById("allLogsBtn");

// Initialize Firebase
firebase.initializeApp(config);

// When the window loads, verify that the user is logged in
window.addEventListener('load', () => {
	// Check to make sure that the user is signed in
	firebase.auth().onAuthStateChanged((user) => {
		if (user) {
			// The User Is Signed In!!
			const displayName = user.displayName;
			const email = user.email;
			const photoURL = user.photoURL;
			const uid = user.uid;
			
			// Display the users name and email
			nameTitle.innerText = "Name: " + displayName;
			emailTitle.innerText = "Email: " + email;

			/* Make the email title size up to fill available space. 
			I have edited fitty.min.js to size the log and name titles
			 to match */
			fitty(email);
			
			// If the user has a profile picture
			if (photoURL !== null) {
				// Display the users profile picture
				profileImg.src = photoURL;
			}

			// Retrieve the amount of logs from the server
			jQuery.ajax({
				url: "PHP/logAmountChecker.php",
				type: "POST",
				data: {
					UID: uid,
				},
				success: function (data) {
					// Display the result
					logsTitle.innerText = "Logs: " + data;
				}
			})

		} else {
			// If The User Has Signed Out, Send Them Back To The Login Page :(
			console.log("Logging " + displayName + "(Current User) Out And Rederecting Them To Home Page")
			window.location.href = "index.html";
		}
	}, function (error) {
		console.log(error);
	});

});

// /* Make the email title size up to fill available space. 
// I have edited fitty.min.js to size the log and name titles to match */
// fitty(email);

// Add a click event for the log out btn
logOutBtn.addEventListener("click", () => {
	// Sign the user out
	firebase.auth().signOut();
	// Send them back to the landing page
	window.location.href = "index.html";
});

// Add a click event for the view logs btn
allLogsBtn.addEventListener("click", () => {
	// Send the user to the passport page
	window.location.href = "passport.html";
});
