/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

function Hrequest() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/BloodBankFiles/BloodBankHospitalRequest.php", true);
    xhttp.send();
    
}



function Brequest() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/BloodBankFiles/BloodBankRequest.php", true);
    xhttp.send();
    
}

function Stockmanage() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/BloodBankFiles/BloodBankStock.php", true);
    xhttp.send();
    
}

function stockalert() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/BloodBankFiles/BloodBankStockAlert.php", true);
    xhttp.send();
    
}

function campaign() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/BloodBankFiles/BloodBankCampaign.php", true);
    xhttp.send();
    
}

function donor() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/BloodBankFiles/BloodBankDonor.php", true);
    xhttp.send();
    
}

function profile() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("col10").innerHTML = this.responseText;
    };
    xhttp.open("GET", "../DashboardFiles/BloodBankFiles/BloodBankProfile.php", true);
    xhttp.send();
    
}

function EditBloodpackets(bloodId){
    $.ajax({url: "../popups/EditBloodpackets.php",
    method: 'post',
    data: {bloodId: bloodId},
    success: function (result) {
console.log("success");
        $("#editbloodpackets").html(result);
       

    }});
}


function EditDon(donorId){

    console.log(donorId);
    
    $.ajax({url: "../popups/EditDonor.php",
    method: 'post',
    data: {donorId : donorId },
    success: function (result) {

        $("#EditDonor").html(result);
    }});
        
}


function ViewDon(donorId){

    

    console.log(donorId);
    
    $.ajax({url: "../popups/ViewDonor.php",
    method: 'post',
    data: {donorId : donorId },
    success: function (result) {
        console.log("success");
        $("#ViewDonor").html(result);
    }});
        
}

function EditBBProfile(bloodBankId){

    console.log(bloodBankId);
    
    $.ajax({url: "../popups/EditBBprofileEdit.php",
    method: 'post',
    data: {bloodBankId : bloodBankId },
    success: function (result) {

        $("#EditProfile").html(result);
    }});
        
}



