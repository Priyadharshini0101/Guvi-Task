<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "authenticate"; 


  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $email = $_POST["email"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM auth WHERE email = ? && password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $stmt->store_result();


  if($stmt->num_rows > 0){
    $response = $email;
  }else{
    $response = "invalid credentials";
  }

  echo $response;
  $stmt->close();
  $conn->close();

?>