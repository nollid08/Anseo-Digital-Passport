//Start of Firebase setup
let config = {
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
			if (!user) {
				// The user is not signed in so send them back to the landing page
				window.location.href = "index.html";
			}
		},
		(error) => {
			// Log the error to the console
			console.log(error);
		});
});
// End of Firebase setup

/* This var is used to store the distance between the user and the closest
point. It is initialized to the circumfrence of the earth (The Equator).
This is done so that all points will be closer than the default value */
let closestDistance = 40100;

/* This function converts degrees to radians.It will
 be used later to figure out how far away each point is */
function Deg2Rad(deg) {
	return deg * Math.PI / 180;
}

/* Equation that returns the distance between 
   two pairs of latitude and longitude pairs */
function PythagorasEquirectangular(lat1, lon1, lat2, lon2) {
	// Convert all the latitude and longitudes from degrees to radians
	lat1 = Deg2Rad(lat1);
	lat2 = Deg2Rad(lat2);
	lon1 = Deg2Rad(lon1);
	lon2 = Deg2Rad(lon2);
	// Use Pythagoras Equirectangular to find the distance between the two
	const R = 6371;
	let x = (lon2 - lon1) * Math.cos((lat1 + lat2) / 2);
	let y = (lat2 - lat1);
	let d = Math.sqrt(x * x + y * y) * R;
	return d;
}

// Load in all the Discovery Points from the DB
jQuery.ajax({
	url: "PHP/locationLoader.php",
	type: "POST",
	success: function (data) {
		// Convert the returned JSON to a JS object
		let discoveryPoints = JSON.parse(data);
		// Start tracking their GPS
		id = navigator.geolocation.watchPosition((position) => {
			// This function is ran every time that the users location changes

			// Save the latitude and longitude as variables
			let latitude = position.coords.latitude;
			let longitude = position.coords.longitude;

			// Loop through all locations and find the closest
			for (index = 0; index < discoveryPoints.length; ++index) {
				// Calculate the distance between the point and the user
				let distance = PythagorasEquirectangular(latitude, longitude, discoveryPoints[index][1], discoveryPoints[index][2]);
				// If distance is smaller than the closestDistance
				if (distance < closestDistance) {
					/* Update the closest and closestDistance to match the
					new index and ditances */
					closest = index;
					closestDistance = distance;
				}
			}

			// Round closestDistance off to meters
			closestDistance = Math.round(closestDistance * 1000);

			// Output the data
			document.getElementById("locationout").innerHTML = "Closest Location: " + discoveryPoints[closest][0];
			document.getElementById("distanceout").innerHTML = "Distance: " + closestDistance + "m";
			document.getElementById("countyout").innerHTML = "County: " + discoveryPoints[closest][3];

		}, (err) => {
			// If there is an error log it to the console
			console.warn('ERROR(' + err.code + '): ' + err.message);
		}, {
			enableHighAccuracy: true, //this makes sure that the accuracy is high.
			maximumAge: 0 //This makes sure that it doesnt get a location from the cache of the devices memory
		});

		let btn = document.getElementById("logBtn");
		// This triggers when the log button is pressed 
		btn.addEventListener('click', () => {
			if (closestDistance <= 90) {
				if (firebase.auth().currentUser !== null) {
					// Get users data to insert into DB
					let uid = firebase.auth().currentUser.uid;
					let email = firebase.auth().currentUser.email;
					let name = firebase.auth().currentUser.displayName;
					// Get the closest point ID
					let closestPoint = discoveryPoints[closest][4];
					// Get the closest point name
					let closestPointName = discoveryPoints[closest][0];

					/* Post the users UID, closest point name and ID to the server 
					to be inserted into the DB */
					jQuery.ajax({
						url: "PHP/logIt.php",
						type: "POST",
						data: {
							UID: uid,
							cpId: closestPoint,
							cpName: closestPointName
						},
						success: function (data) {
							let logId = data;
							/* Post to a PHP script on the server 
							to send an email to the user */
							$.ajax({
								type: 'post',
								url: 'PHP/logEmail.php',
								data: {
									cp: closestPointName,
									ve: email,
									dn: name
								},
								success: function (data) {
								}
							})
							// Fire a "Sweet Alert" to tell the user that the log was successful
							Swal.fire({
								type: 'success',
								title: 'Discovery Point Logged!',
								text: 'Congrats,You Have Successfully Logged The Discovery Point "' +
									discoveryPoints[closest][0] + '"',
								footer: 'Anseo Digital Passport, Made And Maintained By Dillon Lynch',
								onClose: () => {
									window.location.href = "logviewer.html?" + logId;
								}
							})
						}
					});
				}
				// If they are too far away
			} else if (closestDistance > 90) {
				//Fire a "Sweet Alert" to tell the user that the log was unsuccessful
				Swal.fire({
					type: 'success',
					title: 'Uh Oh!',
					text: 'You are too far away from "' +
						discoveryPoints[closest][0] + '" to log it!',
					footer: 'Anseo Digital Passport, Made And Maintained By Dillon Lynch'
				})
			}
		});
	}
})