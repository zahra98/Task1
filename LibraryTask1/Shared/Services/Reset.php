<?php
include 'Database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$conn = OpenCon();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  $email = test_input($_POST["email"]);
  $check_email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if (!$check_email) {  //if the phone and emails does not match the patterns show an alert msg else continue..
    echo "<script>
    var text= \"Invalid data check your email \";
        window.confirm(text);
 window.open('../View/Reset.html','_self');
      </script> ";
  }

else{
$token = md5(time().$email);
echo "done1";
  require '/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/vendor/autoload.php';
  require_once '/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/vendor/phpmailer/phpmailer/src/Exception.php';
  require_once '/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/vendor/phpmailer/phpmailer/src/SMTP.php';
  require_once '/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/vendor/phpmailer/phpmailer/src/PHPMailer.php';
  echo "OK";
  echo "OK";
  $r = "zahraabuzahra4@gmail.com";
  $mail = new PHPMailer(true);
  echo "OK";
  try {
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = "ssl://smtp.gmail.com"; 
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'zahraabuzahra4@gmail.com';                     // SMTP username
    $mail->Password   = 'zahra0599527348';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->setFrom('zahraabuzahra4@gmail.com', 'Reset Password');
 
    $mail->addAddress($email);
   
    $mail->isHTML(true);
  
    $mail->Subject = 'Confirm email';
   
    $mail->Body = 'Activate your email:
    <a href="http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/Services/NewPassword.php?email=' . $email . '">Confirm email</a>';

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