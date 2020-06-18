// This function opens the navbar
function openNav() {
    document.getElementById("mySidenav").style.width = "100vw";
    document.getElementById("logo").style.display = "none";
    document.getElementById("icon").style.opacity = "0%";
}

// This function closes the navbar
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("logo").style.display = "block";
    document.getElementById("icon").style.opacity = "100%";
}
