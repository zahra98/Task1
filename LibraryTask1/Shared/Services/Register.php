<?php
include 'Database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$conn = OpenCon();
$name = $email = $phone = $address = $passsword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $phone = test_input($_POST["phone"]);
  $address = test_input($_POST["address"]);
  $password = test_input($_POST["password"]);
  $encrypted_password =password_hash($password,PASSWORD_DEFAULT); 
  $pattern = '/^[0-9]{10}$/i';//the phone pattern only 10 digits allowed
  $check_email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $check_phone = preg_match($pattern, $phone);
  if (!($check_email && $check_phone)) {  //if the phone and emails does not match the patterns show an alert msg else continue..
    echo "<script>
    var text= \"Invalid data check your email or phone number\";
        window.confirm(text);
 window.open('../View/Register.html','_self');
      </script> ";
  }

else{
$token = md5(time().$email);
$sql = "INSERT INTO users (user_name, user_email, user_phone,user_address,user_password,is_admin,token)
VALUES ('$name' , '$email', '$phone','$address','$encrypted_password','0','$token')";

if ($conn->query($sql) === TRUE) {
  echo "OK";
  $mail = new PHPMailer(true);
  echo "OK";
  try {
    $mail->setFrom('zainaaaa98@gmail.com', 'User Registration');
    $mail->addAddress('zahraabuzahra4@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Confirm email';
    $mail->Body = 'Activate your email:
    <a href="http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/Services/verify-email.php?email=' . $email . '&token=' . $token . '">Confirm email</a>';

    $mail->send();
    $output = 'Message sent!';
} catch (Exception $e) {
    $output = $mail->ErrorInfo;
}

}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
//   $to = $reciverEmail;
//   $subject = " Cinfermation Email"; 
  
//   $message = "<a href = 'http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/Services/verify-email.php?tkey=$token'> Regester account </a> ";
//   $header = "";

//  header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/View/LogIn.html");
//  exit();

}
}
//validate the form data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
CloseCon($conn);
?>