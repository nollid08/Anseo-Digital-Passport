// Placeholder Variables
// let km = "";

/* This var is used to store the distance between the user and the closest
point. It is initialized to the circumfrence of the earth (The Equator).
This is done so that all points will be closer than the default value */
let closestPointDistance = 40100;

// Create a reference to the table
const table = document.getElementById("rows");

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
    return Math.round(d * 1000);
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

            // Clear the table to make way for the updated rows
            table.innerHTML = "";

            // Loop through each Discovery Points
            for (index = 0; index < discoveryPoints.length; ++index) {
                const closestPointDistance = PythagorasEquirectangular(
                    latitude, longitude, discoveryPoints[index][1], discoveryPoints[index][2]);
                const closestPoint = discoveryPoints[index][0];

                // Insert a row at the end of the table
                const newRow = table.insertRow(-1);
                // Save the distance as an attribute in the row
                newRow.setAttribute("data-distance", closestPointDistance);

                // Insert two cells into the row dir the location name and distance
                const nameCell = newRow.insertCell(0);
                const distanceCell = newRow.insertCell(1);

                // Default the kilometres var to nothing
                let km = "";
                /* Get the amount of kilometres If the closest point is 
                over 1000m away */
                if (Math.trunc(closestPointDistance / 1000) > 0) {
                    // Get the amount of kilometres
                    km = Math.trunc(closestPointDistance / 1000) + "km";
                }
                // Get the amount of meters
                let meters = closestPointDistance % 1000;

                // Put the location name into a text node
                const locationNameNode = document.createTextNode(closestPoint);
                // Put the distance into a text node
                const locationDistanceNode = document.createTextNode(km + " " + meters + "m");
                
                // Append the name and distance text nodes to the table
                nameCell.appendChild(locationNameNode);
                distanceCell.appendChild(locationDistanceNode);
            }
            //Sort the table by Distance
            let switching = true;
            /*Make a loop that will continue until
            no more switching can be done*/
            while (switching) {
                //start by saying that no switching is done
                switching = false;
                let rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 0; i < (rows.length - 1); i++) {
                    /* Get the distance attribute from the two 
                    rows which are to be compared */
                    x = Math.trunc(rows[i].getAttribute("data-distance"));
                    y = Math.trunc(rows[i + 1].getAttribute("data-distance"));
                    
                    // Check if the two rows should switch place
                    if (x > y) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        // Set switching to true
                        switching = true;
                    }
                }
            }
        }, (err) => {
            // If there is an error log it to the console
            console.warn('ERROR(' + err.code + '): ' + err.message);
        }, {
            enableHighAccuracy: true, //this makes sure that the accuracy is high.
            maximumAge: 0 //This makes sure that it doesnt get a location from the cache of the devices memory
        });

    }
})