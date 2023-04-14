var page = "./profile.html";

$("#form").submit(function (e) {    
      e.preventDefault();
      let username= document.getElementById("username").value;
      let email = document.getElementById("email").value;
      let password = document.getElementById("password").value;
  
      if(username == "" || email == "" || password == ""){
          alert("Enter all the data");
      }else{
        $.ajax({
          url: "./php/register.php?",
          method: "POST",
          data: {username:username,email:email,password:password},

          success:function(response) {
          console.log(response);
            if(response == "success"){
             alert("Registered Successfully");
            window.location.href = page;
            localStorage.setItem("user",response);
            }else{
              alert("Email already exists");
            }
          },
                
        });
      }
});

var user = window.localStorage.getItem("user");
if(user){
    window.location.href = page;
}


