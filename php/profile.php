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
   
    
    try{
        require_once dirname(__DIR__, 1) . "/vendor/autoload.php";

        $mongoDB = new MongoDB\Client(
           "mongodb+srv://priyadharshinis5102:senthamil@cluster0.gkno9yn.mongodb.net/?retryWrites=true&w=majority"
        );
        $db = $mongoDB->GUVIDB;
        $table = $db->users;

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
    
        
      }catch (Exception $e) {
        die($e->getMessage());
    }


if(isset($_POST["email_1"])){
 
    $id = $_POST["email_1"];
    $email = $redis->get($id);
 $cursor = $table->find();
 foreach ($cursor as $doc) {
     if ($doc["email"] == $email) {
         echo json_encode($doc);
     }
 }
}else if(isset($_POST["username"])){
    $email = $_POST['email'];
 $table->updateOne(
    ["email" => $email],
    [
        '$set' => [
            "name" => $_POST["username"],
            "dob" => $_POST["dob"],
            "phonenumber" => $_POST["phonenumber"],
        ],
    ]
    );

    $stmt1 = $conn->prepare("UPDATE users SET dob=?, phonenumber=? WHERE email=?");
    $stmt1->bind_param("sss", $_POST["dob"], $_POST["phonenumber"], $email);
    $stmt1-> execute();
    $stmt1-> close();
  
    echo $email;   
}else if(isset($_POST["email_2"])){
    $id = $_POST["email_2"];
    $email = $redis->get($id);
    $table->deleteOne(["email" => $email]);
    
        $stmt1 = $conn->prepare("DELETE FROM users WHERE email=?");
        $stmt1->bind_param("s", $email);
        $stmt1-> execute();
        $stmt1-> close();
      
        echo "profile deleted";     
}
}
?>