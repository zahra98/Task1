<?php
include 'Database.php';
$conn = OpenCon();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    //$sql = "SELECT user_name FROM users where user_email = 'kj'";
    // $result = $conn->query($sql);
    // $sql2 = "SELECT * FROM users where user_password='" . $y . "'";
    // $result2 = $conn->query($sql2);
    // echo $result;
    // $sql = "INSERT INTO users (user_name, user_email, user_phone,user_address,user_password,is_admin)
    // VALUES ('name' , 'email', 'phone','address','encrypted_password','0')";
    // // $sql = sprintf("SELECT * FROM users 
    // // WHERE email='%s'",
    // // mysql_real_escape_string($email));
    // if ($conn->query($sql) === TRUE) {
    //     echo " success"; 
    //     // header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/View/Register.html");
    //     // exit();
    //       } else {
    //         echo "Error: " . $sql . "<br>" . $conn->error;
    //       }

    $sql = "SELECT * FROM users where user_email = '$email' ";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_array($result)){
                $a = $row['user_password'];
                $b = $row['user_name'];
             $verify = password_verify($password, $a);
             if ($verify) {
                 echo "Found it";
                 session_start();
                 header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/NormalUser/View/ProfilePage.html");
                 exit();
             }
             else{
                 echo $a;
             }
            }
        } else{
            echo "No records matching your query were found.";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

//     if (!$result ) {
//         die($conn->error);
//     }
//     if ($result->num_rows > 0) {

//         while ($row = $result->fetch_assoc()) {
    
//             $a = $row["user_password"];
//             $verify = password_verify($passsword, $a);
//             if ($verify) {
//                 session_start();
              
//                 //header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/View/Register.html");
//                 //exit();
//             }

//             else {
//                 echo "<script>
//     var text= \" check email or password\";
//         window.confirm(text);
//  window.open('login.html','_self');
//       </script> ";
//             }
//         }
//     }

}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
CloseCon($conn);
?>