// Initialize Firebase
var config = {
    apiKey: "AIzaSyBDCFdhuDKGa8ipCGqZ-w-aZVQypOLH7FI",
    authDomain: "login-for-waw.firebaseapp.com",
    databaseURL: "https://login-for-waw.firebaseio.com",
    projectId: "login-for-waw",
    storageBucket: "login-for-waw.appspot.com",
    messagingSenderId: "53721053369"
};
firebase.initializeApp(config);

// Configure the login ui
var uiConfig = {
    // Url to go to after login
    signInSuccessUrl: 'logIt.html',
    // Sign in providers
    signInOptions: [
        firebase.auth.GoogleAuthProvider.PROVIDER_ID,
        firebase.auth.EmailAuthProvider.PROVIDER_ID,
    ],
    // Terms of service url
    tosUrl: '<your-tos-url>',
    // Privacy policy url/callback.
    privacyPolicyUrl: () => {
        window.location.assign('<your-privacy-policy-url>');
    }
};

// Initialize the FirebaseUI Widget using Firebase.
const ui = new firebaseui.auth.AuthUI(firebase.auth());
// The start method will wait until the DOM is loaded.
ui.start('#firebaseui-auth-container', uiConfig);