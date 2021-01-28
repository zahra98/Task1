<?php
include 'Database.php';
$conn = OpenCon();
$name = $email = $phone = $address = $passsword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $phone = test_input($_POST["phone"]);
  $address = test_input($_POST["address"]);
  $password = test_input($_POST["password"]);
  $encrypted_password =password_hash($password,  
  PASSWORD_DEFAULT); 
  $pattern = '/^[0-9]{10}$/i';
  $check_email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $check_phone = preg_match($pattern, $phone);
  if (!($check_email && $check_phone)) {
    echo "<script>
    var text= \"Invalid data check your email or phone number\";
        window.confirm(text);
 window.open('../View/Register.html','_self');
      </script> ";
  }

else{
$sql = "INSERT INTO users (user_name, user_email, user_phone,user_address,user_password,is_admin)
VALUES ('$name' , '$email', '$phone','$address','$encrypted_password','0')";

if ($conn->query($sql) === TRUE) {
header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/View/LogIn.html");
exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
CloseCon($conn);
?>