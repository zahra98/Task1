
<?php
function OpenCon()
{
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "zahra";
$db = "Library";
$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
echo "Connected Successfully";
return $conn;
}

function CloseCon($conn)
{
$conn -> close();
}
?>



