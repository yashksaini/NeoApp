<?php 
session_start();
include('config.php'); 
if(isset($_POST['chat_username']))
{
	$_SESSION['chat_username'] = $_POST['chat_username'];
}

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
	$rs = $con->query($sql);
  	$row = $rs->fetch_assoc();
  	$full_name = $row["first_name"]." ".$row["last_name"];
  	$f_name_i = $row["first_name"];

  	$sql1 = "SELECT * FROM profile WHERE username='$username' ";
	$re1 = mysqli_query($con,$sql1);
	$rs1 = $con->query($sql1);
	$rows = $rs1->fetch_assoc();
	$imagei = $rows["image"];

?>
<?php 
    
    $sql1 = "SELECT * FROM profile WHERE username='$chat_username' ";
	$re1 = mysqli_query($con,$sql1);
	$rs1 = $con->query($sql1);
	$rows = $rs1->fetch_assoc();
	$chat_imagei = $rows["image"];
	$chat_full_name = $rows["full_name"];

	$sql_tik = "UPDATE chats SET rec_status='true' WHERE send_username='$chat_username'&&rec_username='$username'";
	$tic_res = mysqli_query($con,$sql_tik);
	if(isset($_POST['chat_text']))
	{
		$chat_text = $_POST['chat_text'];
		$sql_l = "INSERT INTO chats(send_username,rec_username,content)VALUES('$username','$chat_username','$chat_text')";
		$check = mysqli_query($con,$sql_l);

		$sql_friend = "UPDATE friends SET timestamp=now()  WHERE (user_send='$username'&&user_rec='$chat_username')||(user_send='$chat_username'&&user_rec='$username')";
		$u_friend = mysqli_query($con,$sql_friend);
	}

?>

<!-- HTML Start -->
<style type="text/css">
	.chat_left
    {
      border-radius:20px;
      min-width:50px;
      max-width:80%; 
      padding: 5px 10px ;
      background-color: #2496FF;
      color:white;
      border-bottom-left-radius: 0px;
      margin-top: 5px;
      text-align: left;
      display: inline-block;
    }
    .chat_right
    {
      border-radius:20px;
      min-width:50px;
      max-width:80%; 
      padding:10px 20px ;
      background-color: #dfdfdf;
      color:black;
      border-bottom-right-radius: 0px;
      margin-top: 5px;
      text-align: right;
      display: inline-block;
    }
    #chat_text{
    	background-color: white;
    }
    #chat_text:focus{
    	box-shadow: none;
    }
</style>
<body>

	<div class="container-fluid p-0" style="height: calc(100vh - (30px + 30px));z-index: 100000;position: relative;" >
		<div style="height: 50px;display: flex;justify-content: left;align-items: center; padding-left: 20px;background-color: #fff;border-bottom: solid 1px #03030336;border-top: solid 1px #03030336;">
			<img src="images/<?php echo"$chat_imagei"; ?>" style="height: 30px;width: 30px;border-radius: 40px;" >
			<h5 style="color:  #2496FF"><b><?php echo"$chat_full_name";?></b></h5>
		</div>
		<div style="height:  calc(100vh - (30px + 140px));  overflow-y:scroll;background-color: #fff;padding: 10px;flex-direction:column-reverse;display:flex; " id="chat_box">
		</div>
		<form method="post" autocomplete="off" style="height: 60px;" class="p-0">
			<div class="input-group" >
	  			<input type="text" name="chat_text" id="chat_text" placeholder="Type Message Here.." class="form-control bg-light" style="padding: 15px;height:59px;border-radius: 50px;border-radius: 0px;" required>
				<div class="input-group-prepend">
		    		<button type="submit" id="send_chat" class="btn" style="color: white;background-color: #2496FF;padding: 15px;border-radius: 50px;border-radius: 0px;height: 59px"><i class='fas fa-paper-plane'></i> Send</button>
		  		</div>	
			</div>
		</form>
	</div>

<p id="result" style="display: none;"></p>
<!-- HTML Footer -->
<script type="text/javascript">
	document.getElementById('chat_count').innerHTML = "<?php 
	$sql_chat_count1 = "SELECT * FROM chats WHERE rec_username='$username' && rec_status='false'";
 	$chat_count_res1 = mysqli_query($con,$sql_chat_count1);
 	$num_rows_chat1 = mysqli_num_rows($chat_count_res1);

 	if($num_rows_chat1>0){
 	 	echo"$num_rows_chat1";}
 	?>";
</script>

<script>
    $(document).ready(function(){
      // load text file when page loads
      $('#chat_box').load('chat_box.php');

      setInterval(function(){
        $('#chat_box').load('chat_box.php');
      }, 200);
    });
    </script>
	
    <script>
  $(document).ready(function () {
    $('#send_chat').click(function (e) {

      e.preventDefault();
    	var p="chat_text";
      	var chat_text = document.getElementById(p).value;
      if(chat_text!="")
      {
      	$.ajax
              ({
                type: "POST",
                url: "addchat.php",
                data: { "chat_text": chat_text },
                success: function (data) {
                	document.getElementById('chat_text').value = "";
                }
              });}
    });
  });
</script>