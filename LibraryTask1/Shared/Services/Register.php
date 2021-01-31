<?php
include 'Database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
  require '/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/vendor/autoload.php';
  require_once '/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/vendor/phpmailer/phpmailer/src/Exception.php';
  require_once '/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/vendor/phpmailer/phpmailer/src/SMTP.php';
  require_once '/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/vendor/phpmailer/phpmailer/src/PHPMailer.php';
  $r = "zahraabuzahra4@gmail.com";
  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = "ssl://smtp.gmail.com"; 
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'zahraabuzahra4@gmail.com';                     // SMTP username
    $mail->Password   = 'zahra0599527348';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->setFrom('zahraabuzahra4@gmail.com', 'User Registration');
 
    $mail->addAddress('zainaaaa98@gmail.com');
   
    $mail->isHTML(true);
  
    $mail->Subject = 'Confirm email';
   
    $mail->Body = 'Activate your email:
    <a href="http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/Services/verify-email.php?email=' . $r . '&token=' . $token . '">Confirm email</a>';

   if( $mail->send()){
    $output = 'Message sent!';
   }
   else{
    $output = 'something went rong';
   }
    
} catch (Exception $e) {
 
    $output = $mail->ErrorInfo;
}
echo $output ;
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

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