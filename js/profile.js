var page = "./login.html";

var user = window.localStorage.getItem("user");
if(!user){
    window.location.href = page;
}

let username= document.getElementById("username").value;
let email = document.getElementById("email").value;
let dob = document.getElementById("dob").value;
let phonenumber = document.getElementById("phonenumber").value;

function logout(){
    var logout=confirm("Do you really want to log out?");
    if(logout){
    localStorage.clear();
    window.location.href = page;
    }
}

function deleteUser(){
    var deleteUser=confirm("Do you really want to deleted your profile?");
    if(deleteUser){
    $.ajax({
        method: "POST",
        url: "./php/profile.php?",
        data: {email_2 :user},

        success:function(response) {
            console.log(response);
            alert("Profile Deleted");
            localStorage.clear();
            window.location.href = page;
        
        },
              
      });
    }
}

$(document).ready(function(){
    $.ajax({
        method: "POST",
        url: "./php/profile.php?",
        data: { email_1 : user},
        success: function(res){
            if(res){
            var form_value = JSON.parse(res);
            username.value = form_value.name;
            email.value = form_value.email;
            dob.value = form_value.dob;
            phonenumber.value = form_value.phonenumber;
            document.getElementById("username_1").textContent = form_value.name;
            document.getElementById("email_1").textContent = form_value.email;
            }
        }

    })
});

$("#form").submit(function (e) {    
    e.preventDefault();


  
      $.ajax({
        url: "./php/profile.php?user= " + user,
        method: "POST",
        data: {username:username,email:email,dob:dob,phonenumber:phonenumber},

        success:function(response) {
            console.log(response);
            alert("Profile Updated");
            location.reload();
        
        },
              
      });
    
});


