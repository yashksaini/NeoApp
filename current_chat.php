<?php 
session_start();
include('config.php'); 


$username = $_SESSION['username'];
$password = $_SESSION['password'];

$chat_username = $_SESSION['chat_username'];

$sql = "SELECT * FROM users WHERE username='$username' && password='$password'";
$re = mysqli_query($con,$sql);
$number = mysqli_num_rows($re);

if($number!=1)
{
  header('location:index.php');
}

if(isset($_POST['chat_username']))
{
	$_SESSION['chat_username'] = $_POST['chat_username'];
	header('location:chats.php');
}

?>