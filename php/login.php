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

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? && password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $stmt->store_result();


  if($stmt->num_rows > 0){
    try{
    require_once dirname(__DIR__, 1) . "/vendor/predis/predis/autoload.php";
    Predis\Autoloader::register();
    $redis = new Predis\Client([
        "scheme" => "tcp",
        "host" => "127.0.0.1:6379",
        "port" => 6379,
    ]);

    if (!$redis->ping()) {
      echo "Connection failed";
  }

  $id = password_hash($email, PASSWORD_DEFAULT);
  $redis->set($id, $email);

  $response = $id;
  }catch (Exception $e) {
    die($e->getMessage());
}
  

   
  }else{
    $response = "invalid credentials";
  }

  echo $response;
  $stmt->close();
  $conn->close();

?>