var page = "./login.html";

var user = lwindow.localStorage.getItem("user");
if(!user){
    window.location.href = page;
}

function logout(){
    var logout=confirm("Do you really want to log out?");
    if(logout){
    localStorage.clear();
    window.location.href = page;
    }
}