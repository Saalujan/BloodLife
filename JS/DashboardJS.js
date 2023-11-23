/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

//var navLinks = document.getElementsByClassName("nav-link");
//
//function setActiveLink(event) {
//    // Remove 'active' class from all links
//    for (var i = 0; i < navLinks.length; i++) {
//        navLinks[i].classList.remove("active");
//    }
//
//    // Add 'active' class to the clicked link
//    event.target.classList.add("active");
//}
//
//// Attach click event listener to each link
//for (var i = 0; i < navLinks.length; i++) {
//    navLinks[i].addEventListener("click", setActiveLink);
//}
//navLinks[0].classList.add("active");



function bigtosmal() {

    var div = document.getElementById("col2");
    div.style.display = "none";

    var div = document.getElementById("col1");
    div.style.display = "block";


    var col2element = document.getElementById("col10");

    var newClassNamecol2 = "col-11 content p-0 m-0 container col11edit";
    col2element.className = newClassNamecol2;

    var div1 = document.getElementById("smalltobig");
    div1.style.display = "block";


}

function smalltobig() {

    var div = document.getElementById("col2");
    div.style.display = "block";

    var div = document.getElementById("col1");
    div.style.display = "none";

    var col2element = document.getElementById("col10");
    var newClassNamecol2 = "col-10 container p-0 m-0 content col10edit";
    col2element.className = newClassNamecol2;


}

function handleWindowWidth() {
    var windowWidth = window.innerWidth;

    // Code to execute based on the window width
    if (windowWidth < 1024) {


        var div = document.getElementById("col2");
        div.style.display = "none";

        var div = document.getElementById("col1");
        div.style.display = "block";

        var col2element = document.getElementById("col10");
        var newClassNamecol2 = "col-11 container p-0 m-0 content col10edit";
        col2element.className = newClassNamecol2;

    } else if (windowWidth < 1500) {

        var div = document.getElementById("col2");
        div.style.display = "block";

        var div = document.getElementById("col1");
        div.style.display = "none";

        var col2element = document.getElementById("col10");
        var newClassNamecol2 = "col-10 container p-0 m-0 content col10edit";
        col2element.className = newClassNamecol2;

        var elements = document.querySelectorAll('[id="letter"]');

        for (var i = 0; i < elements.length; i++) {
            var div = elements[i];
            div.style.fontSize = "10px";
            div.className = "col-9 ml-5";
        }



    } else {
        var div = document.getElementById("col2");
        div.style.display = "block";

        var div = document.getElementById("col1");
        div.style.display = "none";

        var col2element = document.getElementById("col10");
        var newClassNamecol2 = "col-10 container p-0 m-0 content col10edit";
        col2element.className = newClassNamecol2;

        var elements = document.querySelectorAll('[id="letter"]');

        for (var i = 0; i < elements.length; i++) {
            var div = elements[i];
            div.style.fontSize = "16px";
            div.className = "col-10";
        }




    }
}

// Function to run continuously while monitoring the width changes
function runFunctionOnResize() {
    handleWindowWidth();

    // Add any additional code or function calls here
}

// Call the function initially
runFunctionOnResize();

// Attach the function to the window resize event
window.addEventListener('resize', runFunctionOnResize);



function functionTest(value) {


    $.ajax({url: "../services/locationService.php",
        method: 'post',
        data: {district: value},
        success: function (result) {

            $("#divisionDropDown").html(result);
           

        }});
}



function getBloodBank(value) {
    console.log(value);

    $.ajax({url: "../services/locationService.php",
        method: 'post',
        data: {division: value},
        success: function (result) {

            $("#bloodbankDropDown").html(result);

        }});
}

function getBloodBankDetails(value) {
    console.log(value);

    $.ajax({url: "../services/bloodbankservices.php",
        method: 'post',
        data: {bloodBank: value},
        success: function (result) {
            console.log("Success");
            $("#bloodbankdetails").html(result);

        }});
}


function validateMobileNumber(contactNumber) {
    // Remove any non-numeric characters from the input
    contactNumber = contactNumber.replace(/\D/g, '');

    // Check if the mobile number is 10 digits long (including the prefix)
    if (contactNumber.length === 10) {
        // Check if the mobile number starts with a valid Sri Lankan prefix
        const validPrefixes = ["071", "072", "075", "076", "077", "078", "074","071","070"];
        const prefix = contactNumber.substr(0, 3);

        if (validPrefixes.includes(prefix)) {
            document.getElementById("validationResult").textContent = ` ${contactNumber} is a valid Sri Lankan mobile number.`;
            document.getElementById("validationResult").className = "valid"; // Set the text color to green
            return;
        }
    }

    document.getElementById("validationResult").textContent = `${contactNumber} is not a valid Sri Lankan mobile number.`;
    document.getElementById("validationResult").className = "not-valid"; // Set the text color to red
}



