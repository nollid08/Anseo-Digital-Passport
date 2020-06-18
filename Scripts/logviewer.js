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
			if (user) {
				// The user is signed in

				// Create references to the DOM

				// Location Title
				let title = document.getElementById('title');
				// Comment textarea
				let commentInput = document.getElementById('Comment');
				// Comment submit button
				let commentBtn = document.getElementById("commentBtn");
				// Image Lightbox - opens when user clicks on image
				let lightBoximg = document.getElementById('lightboxPhoto');
				// Retro white box around image
				let polaroid = document.getElementsByClassName('polaroid')[0];
				// User uploaded image tag				
				let img = document.getElementById('photo');
				// Image subtitle text
				let imgSubtitle = document.getElementById('imgSubtitle');
				// File submit btn
				let fileBtn = document.getElementById('fileBtn');
				// Logo
				let logo = document.getElementById('logo');
				// Hamburger icon
				let hamburger = document.getElementById('icon')

				/* Get the users UID and log ID to use when interacting with
				the server */
				let uid = firebase.auth().currentUser.uid;
				let logId = window.location.href.split('?').pop();;

				// Create a refrence to the Firebase storage server
				let storageRef = firebase.storage().ref();

				/* Darken the logo and hamburger menu when the lightbox 
				opens so that they do not pop through the opauqe overlay.
				They are restored when it closes in simple-lightbox.min.js*/
				polaroid.addEventListener("click", () => {
					hamburger.classList.add("darken");
					logo.classList.add("darken");
				});

				// Create a lightbox
				new SimpleLightbox('.polaroid a', "closeText = 'y'");

				/* Post the users UID and log id to the server 
				to retrieve the comment data */
				jQuery.ajax({
					url: "PHP/commentData.php",
					type: "POST",
					data: {
						UID: uid,
						LOG_ID: logId
					},
					success: function (data) {
						/* Check to see whether comment should be inputted
						as a placeholder or edditable text */
						if (data.trim().localeCompare('Add A Comment(Max 255 Characters)...'.trim()) === 0) {
							// Remove "loading..." so placeholder will show							
							commentInput.value = null;
							// Input comment as placeholder
							commentInput.placeholder = data;
						} else {
							// Input comment as normal, edditable text
							commentInput.value = data;
						}
					}
				})

				/* Load in the image subtitle which will then also 
				be split to get the Discovery Point name */
				jQuery.ajax({
					url: "PHP/subtitleLoader.php",
					type: "POST",
					data: {
						UID: uid,
						LOG_ID: logId
					},
					success: function (data) {
						// Set the image subtitle
						imgSubtitle.innerText = data;

						/* Get the Discovery Point name by splitting the
						subtitle at the comma */
						let placeName = data.split(",");
						title.innerHTML = placeName[0];
					}
				})

				// Download the image from firebase
				//First, retrieve the image location from the DB
				jQuery.ajax({
					url: "PHP/imageLoader.php",
					type: "POST",
					data: {
						UID: uid,
						LOG_ID: logId

					},
					success: function (data) {
						/* The image location is now stored 
						in the data variable */

						// Get the images url
						storageRef.child(data).getDownloadURL().then(
							function (url) {
								/* The image url is now stored in the variable
								url */

								// Set the polaroid and lightbox images href to the url
								img.src = url;
								lightBoximg.setAttribute('href', url);
							}).catch(function (error) {
							console.log(error);
						});
					},
					error: function (jqXHR, textStatus, errorThrown) {
						// Log the error to the console
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
					}
				});

				// This triggers when the comment button is pressed
				commentBtn.addEventListener('click', () => {
					let comment = commentInput.value;
					/* Send the comment, log id and the user id to the server
					to insert the comment into the DB */
					jQuery.ajax({
						url: "PHP/commentuploader.php",
						type: "POST",
						data: {
							UID: uid,
							COMMENT: comment,
							LOG_ID: logId
						},
						success: function (data) {
							/* Fire a "Sweet Alert" to inform the user that
							   the comment has been submitted */
							Swal.fire({
								type: 'success',
								title: 'Success!',
								text: 'Comment Submitted',
								timer: 1500
							})
						}
					})

				});

				/* This event listener fires when the user selects an image to
				upload */
				fileBtn.addEventListener('change', function (e) {

					// Save the file and file name as variables
					let file = e.target.files[0];
					let name = e.target.files[0].name;

					/* Create a reference to where the image will go 
					when uploaded to Firebase */
					let imageRef = firebase.storage().ref('img/ ' + firebase.auth().currentUser.uid + '/' + logId + '/' +
						file.name);
					// Get the full path to the image
					let image = (imageRef.fullPath);
					// Begin the upload and save it's progress to the variable task
					let task = imageRef.put(file);

					task.on('state_changed', function progress() {},

						function error(err) {
							// If there is an error
							console.log(err);

						},
						function complete() {
							// When the upload is complete

							/* Get the image url to set as the src
							 for the image and lightbox */
							storageRef.child(image).getDownloadURL().then(
								function (url) {
									// Set the polaroid image source to the new source
									img.src = url;
									// Set the HREF to the new url
									lightBoximg.setAttribute('href', url);
								}).catch(function (error) {
									// If there is an error
									console.log(error);
							});

							/* Post the image location, user ID and the log ID to the server
							to be inserted into the DB */
							jQuery.ajax({
								url: "PHP/imageUploader.php",
								type: "POST",
								data: {
									UID: uid,
									logId: logId,
									image: image
								},
								success: function (data) {
									/* Next we must delete the old image(Its
									   location is passed back via the data 
									   variable) from firebase to save space. */

									/* Make sure that it is not the default image as we 
									do not want to delete the default image */
									if (data !== 'img/Default/default.png') {
										// Create a reference to the image to delete
										let imgToDeleteRef = storageRef.child(data);

										// Delete the image
										imgToDeleteRef.delete()
										.catch(function (error) {
											console.log("Error: " + error);
										});
									}
									/* Fire a "Sweet Alert" to inform the user
									that the image has been submitted */
									Swal.fire({
										type: 'success',
										title: 'Success!',
										text: 'Image Submitted',
										timer: 1500
									})
								},
								error: function (jqXHR, textStatus, errorThrown) {
									console.log(jqXHR);
									console.log(textStatus);
									console.log(errorThrown);
								}
							});
						});
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