<?php
include 'Database.php';
$conn = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $sql = "SELECT * FROM users where user_email = '$email' ";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_array($result)){
             $DBPassword = $row['user_password'];
             $id = $row['user_id'];
             $verify = password_verify($password, $DBPassword);
             if ($verify) {
                 session_start();
                 $_SESSION['user_id'] = $id;
             }
             else{
                 echo "No match";
                 header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/View/LogIn.html");
                 exit();
             }
            }
        } else{
            echo "No records matching your query were foundddd.";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
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



<!-- this is the profile page -->
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/TrainingTasks/MyTask1/LibraryTask1/Shared/View/LogIn.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
  .img{
   width: 190px;
   height: 200px
        }
 .center {
  margin: auto;
  width: 60%;
  border: 3px solid #73AD21;
  padding: 10px;
 }
 table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 300px;
  margin: auto;
  width: 90%;
  border: 3px ;
  padding: 15px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
 
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
                    <div class="row mb-4 px-3">
                        <h6 class="mb-0 mr-4 mt-2">
<?php 
$conn = OpenCon();
 session_start();
 $user_id2 = $_SESSION['user_id'];

 $sql = "SELECT * FROM users where user_id = '$user_id2' ";
 if($result = mysqli_query($conn, $sql)){
     if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){
            $activate = $row['confirmation'];
            if($activate == 1){
                echo "your account is activated";
            }
            else if ($activate == 0){
                echo "your account is not activated";
            }
            $image = $row['user_image'];
            echo "<table>";
            echo "<tr>";
            echo "<th>";
            echo "<img src='".$image."' width = '100%'  >";
            echo "</th >";
            echo "<tr >";

            echo "<table   >";
            echo "<tr>";
            echo "<th style='border=1px solid black' >". "Name". "</th>";
            echo "<th style='border=1px solid black' >". $row['user_name']. "</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<th style='border=1px solid black' >". "Phone". "</th>";
            echo "<th style='border=1px solid black' >" . $row['user_phone'] . "</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<th style='border=1px solid black' >". "Email". "</th>";
            echo "<th style='border=1px solid black' >" . $row['user_email'] . "</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<th style='border=1px solid black' >". "Address". "</th>";
            echo "<th style='border=1px solid black'>" . $row['user_address'] . "</th>";
            echo "</tr>";
            
         }
           echo "</table>";
           echo "</tr >";
           echo "</tr>";
           echo "</table>";
        mysqli_free_result($result);
     }
      else{
         echo "No records matching your query were founddd.";
      }
 } 
  else{
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
  
 // Close connection
 mysqli_close($conn);
?>

</h6>
</div>
            
<div style="text-align:center;"  class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto" >
<form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
</div>
</div>
         
         </div>                   
          
        </div>
    </div>

</body>
</html>