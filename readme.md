# Anseo Digital Passport
Anseo Digital Passport is a digital logging service for the Wild Atlantic Way that aims to be an alternitave to the physical passport that is currently available. 
![Image Of Wild Atlantic Way Passport](https://pbs.twimg.com/media/DoG3NV1W0AUWXho.jpg)
The current phyical passport.

The physical passport requires people to get it stamped at local businesses along the Wild Atlantic Way, which could end up being an inconvenience for the user as the business may be closed or might take them away from the lovely coast. 

This is where Anseo steps in.

## What is Anseo Digital Passport?

Anseo Digital Passport is a digital logging service for the Wild Atlantic Way. It uses the GPS on the users phone to determine their position. It will then check to see if they are within 25m of one of the 162 Discovery Points dotted along the Wild Atlantic Way. Discovery Points are marked by a pole with the Wild Atlantic Way logo on top.

![Image Of Wild Atlantic Way Passport](https://www.aughruspeninsula.com/resources/2%20Omey%20Island%20sign%202%20%20for%20FB.jpg?timestamp=1458223580947)
A Wild Atlantic Way Discovery Point.

If the user is within 25m of a Discovery Point, Anseo will allow them to "Log It". They can then upload an image and write a comment to remember their visit.
The log is saved to their digital passport for them to view anytime, anywhere.

## What did I use to build Anseo
* Html
* Css
* Javascript
* PHP
* MySQL
* Firebae Authentication
* Firebase Storage
* PHP Mailer
## What did I find difficult?

* Finding a way to communicate between Javascript and PHP was very difficult for me. I ended up using Jquery's ajax function, but I hope to replace this with the native fetch function in the future.

* Sending an email from PHP was also very difficult. I ended up using PHP mailer and am very happy with the solution.

* Another difficulty that I encountered was implementing Firebase Storage to allow the user to upload an image. I solved this problem by following many tutorials and reading the documentation.
## If I Started From Scratch What Would I Do Differently?

* I would teach myself Javascript before I began rather than learning as I went

* I would write clean and commented code as I go rather than having to do it all at the end.

* I would read the documentation for Firebase more so that I would do it right the first time rather than creating a bigger job for myself down the line

* I would not sacrifice loading times for the ease of using a library such as Bootstrap or Jquery

* I would use a CSS preproccessor such as sass or less

## Future Plans For Anseo

* Replace Bootstrap and Jquery with vanilla CSS and JS to help improve loading times

* Create an app for IOS and Android

* Expand to include more tourist location lists
