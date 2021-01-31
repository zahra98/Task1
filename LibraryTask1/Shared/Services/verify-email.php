
<?php
include 'Database.php';
if($_GET){
    if(isset($_GET['email'])){
        $email = $_GET['email'];
        echo  $email;
        if($email == ''){
            unset($email);
        }
    }
    if(isset($_GET['token'])){
        $token = $_GET['token'];
        echo  $token;
        if($token == ''){
            unset($token);
        }
    }
    if(!empty($email) && !empty($token)){
        $conn = OpenCon();
     
        $sql = "UPDATE users set confirmation = '1'  WHERE token = '$token' ";
     if ($conn->query($sql) === TRUE) {
        
   header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/View/LogIn.html");
   exit();
       echo  "done";
     } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
       }
 // Close connection
   mysqli_close($conn);
    }
}
?>