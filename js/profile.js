var page = "./login.html";

var user = window.localStorage.getItem("user");
if(!user){
    window.location.href = page;
}

    console.log(window.localStorage.getItem("user"));

function logout(){
    var logout=confirm("Do you really want to log out?");
    if(logout){
    localStorage.clear();
    window.location.href = page;
    }
}