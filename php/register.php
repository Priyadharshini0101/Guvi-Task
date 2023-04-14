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

  $stmt = $conn->prepare("SELECT * FROM auth WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if($stmt->num_rows > 0){
    $response = "invalid credentials";
  }else{
        $stmt1 = $conn->prepare("INSERT INTO auth (username, email, password) VALUES (?, ?, ?)");
        $stmt1->bind_param("sss", $username, $email, $password);
        $stmt1-> execute();
        $stmt1-> close();
        $response = $email;
  }

  echo $response;
  $stmt->close();
  $conn->close();



?>