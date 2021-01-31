<?php
include 'Database.php';
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = test_input($_POST["oldPassword"]);
    $newPassword = test_input($_POST["newPassword"]);
    $confirmedPassword = test_input($_POST["ConfirmPassword"]);
    $newencrypted_password =password_hash($newPassword,PASSWORD_DEFAULT); 
    if($_GET){
        if(isset($_GET['email'])){
            $email = $_GET['email'];
            echo  $email;
            if($email == ''){
                unset($email);
            }
        }
        if(!empty($email)){
            $conn = OpenCon();
         

            $sql = "SELECT * FROM users where user_email = '$email' ";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
        
                    while($row = mysqli_fetch_array($result)){
                     $DBPassword = $row['user_password'];
                     $id = $row['user_id'];
                     $verify = password_verify($oldPassword, $DBPassword);
                     if ($verify) {
                         $sql = "UPDATE users set user_password = '$newencrypted_password'  WHERE user_email = '$email' ";
                         if ($conn->query($sql) === TRUE) {
            
                         header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/View/LogIn.html");
                         exit();
                       
                         } else {
        
                        echo "Error: " . $sql . "<br>" . $conn->error;
                         }
                        }
                     else{
                        echo $DBPassword;
                         echo "No match";
                     }
                    }
                } else{
                    echo "No records matching your query were foundddd.";
                }
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
       mysqli_close($conn);
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



<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/TrainingTasks/MyTask1/LibraryTask1/Shared/View/LogIn.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
</head>
<body>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                  
                        <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img src="https://thumbs.dreamstime.com/z/librarian-online-service-platform-knowledge-education-idea-llibrary-bookshelves-guid-isolated-vector-illustration-191844276.jpg" class="image"> </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-4 px-3">
                            <h6 class="mb-0 mr-4 mt-2">Reset Password</h6>
                        </div>
                        <form action="" method="post">
                        <div class="row px-3"> <label class="mb-1">
                        <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Old Password</h6>
                            </label> <input type="password" name="oldPassword"  placeholder="Enter your old password">  </div>
                            <h6 class="mb-0 text-sm">New Password</h6>
                        </label> <input type="password" name="newPassword" id="txtPassword" placeholder="Enter your new password"> </div>
                        <h6 class="mb-0 text-sm">Confirm Password</h6>
                    </label> <input type="password" name="ConfirmPassword" id="txtConfirmPassword" placeholder="Confirm your new password"> </div>
                        <div class="row mb-3 px-3"> <button type="submit" name = "reset" onclick="return Validate()" class="btn btn-blue text-center">Reset</button> </div>
                          <!-- Password Matching using JavaScript  -->

                        <script type="text/javascript">
                        function Validate() {
                         var password = document.getElementById("txtPassword").value;
                        var confirmPassword = document.getElementById("txtConfirmPassword").value;
                       if (password != confirmPassword) {
                        alert("Passwords do not match.");
                        return false;
                         }
                        return true;
                         }
                       </script>
                    </form>
                    </div>
                </div>
            </div>
            <div class="bg-blue py-4">
             
            </div>
        </div>
    </div>

</body>
</html>