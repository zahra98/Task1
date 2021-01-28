<?php
include 'Database.php';
$conn = OpenCon();
session_start();
$target_dir = "/Applications/MAMP/htdocs/TrainingTasks/MyTask1/LibraryTask1/images/";
$target_file = $target_dir .basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
   // echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
   // echo "File is not an image.";
    $uploadOk = 0;
  }
}
// Check if file already exists
if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 1;
  }
  
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $path ="/TrainingTasks/MyTask1/LibraryTask1/images/";
        $image_name = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])); 
        $image_path = $path . $image_name;
     // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
     // echo  $image_path ; 
     // echo "The id is ". $Uid ; 
      $Uid =  $_SESSION['user_id'];
      $sql = "UPDATE users set user_image = '$image_path'  WHERE user_id = '$Uid' ";
      if ($conn->query($sql) === TRUE) {
         header("Location: http://localhost:8888/TrainingTasks/MyTask1/LibraryTask1/Shared/Services/LogIn.php");
         exit();
      
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }


    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
?>