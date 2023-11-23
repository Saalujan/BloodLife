/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


function HHrequest() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/HospitalFiles/HospitalRequest.php", true);
    xhttp.send();
    
}

function SStockmanage() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/HospitalFiles/HospitalBloodStock.php", true);
    xhttp.send();
    
}

function pprofile() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/HospitalFiles/HospitalProfile.php", true);
    xhttp.send();
    
}


function EditHosProfile(hospitalId){

    console.log(hospitalId);
    
    $.ajax({url: "../HospitalFiles/HospitalProfile.php",
    method: 'post',
    data: {hospitalId : hospitalId },
    success: function (result) {

        $("#EditHosProfile").html(result);
    }});
        
}