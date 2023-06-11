var page = "./profile.html";


$("#form").submit(function (e) {    
    e.preventDefault();
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if(email == "" || password == ""){
        alert("Enter all the data");
    }else{
   
         
      $.ajax({
        url: "./php/login.php?",
        method: "POST",
        data: {email:email,password:password},

        success:function(response) {
    console.log(response);
          if(response == "invalid credentials"){
            alert("Incorrect email or password");
          }else{
            alert("Logged in");
            window.location.href = page;
            localStorage.setItem("user",response);
          }
        },
              
      });
    }
});

var user = window.localStorage.getItem("user");
if(user){
    window.location.href = page;
}


