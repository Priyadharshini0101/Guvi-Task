<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "authenticate"; 

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  require_once dirname(__DIR__, 1) . "/vendor/autoload.php";

  $mongoDB = new MongoDB\Client(
     "mongodb+srv://priyadharshinis5102:senthamil@cluster0.gkno9yn.mongodb.net/?retryWrites=true&w=majority"
  );
 
  $db = $mongoDB-> GUVIDB;
  $table = $db->users;

  $document = [
      "name" => $_POST["username"],
      "email" => $_POST["email"],
      "password" => $_POST["password"],
      "dob" => $_POST["dob"],
      "phonenumber" => $_POST["address"],
  ];

  if($stmt->num_rows > 0){
    $response = "invalid credentials";
  }else{
        $stmt1 = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt1->bind_param("sss", $username, $email, $password);
        $stmt1-> execute();
        $stmt1-> close();
        $response = $email;
      $table->insertOne($document);
  }

  echo $response;
  $stmt->close();
  $conn->close();

 


?>

