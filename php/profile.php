<?php 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "authenticate"; 

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

if($_SERVER["REQUEST_METHOD"] === "POST"){
    require_once dirname(__DIR__, 1) . "/vendor/autoload.php";

    $mongoDB = new MongoDB\Client(
       "mongodb+srv://priyadharshinis5102:senthamil@cluster0.gkno9yn.mongodb.net/?retryWrites=true&w=majority"
    );
    $db = $mongoDB->GUVIDB;
    $table = $db->users;

if(isset($_POST["email_1"])){
  $email_1 = $_POST["email_1"];

 $cursor = $table->find();
 foreach ($cursor as $doc) {
     if ($doc["email"] == $email_1) {
         echo json_encode($doc);
     }
 }
}else if(isset($_POST["username"])){
 $table->updateOne(
    ["email" => $email = $_POST["email"]],
    [
        '$set' => [
            "name" => $_POST["username"],
            "dob" => $_POST["dob"],
            "phonenumber" => $_POST["phonenumber"],
        ],
    ]
    );

    $stmt1 = $conn->prepare("UPDATE users SET dob=?, phonenumber=? WHERE email=?");
    $stmt1->bind_param("sss", $_POST["dob"], $_POST["phonenumber"], $_POST["email"]);
    $stmt1-> execute();
    $stmt1-> close();
  
    echo "profile updated";   
}else if(isset($_POST["email_2"])){
    $table->deleteOne(["email" => $_POST["email_2"]]);
    
        $stmt1 = $conn->prepare("DELETE FROM users WHERE email=?");
        $stmt1->bind_param("s", $_POST["email_2"]);
        $stmt1-> execute();
        $stmt1-> close();
      
        echo "profile deleted";     
}
}
?>