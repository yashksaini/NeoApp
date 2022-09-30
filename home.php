<?php 
session_start();
include('config.php'); 
$username = $_SESSION['username'];
$password = $_SESSION['password'];

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


<!-- HTML Start -->
<?php echo "$html_start";?>
<link rel="stylesheet" type="text/css" href="styles/home.css">
</head>
<body>
<!-- Menu Bar -->
<?php echo"$menu_bar";?>
<style type="text/css">
	#color1
	{
		color:#2496FF;
	}
</style>
<div style="margin-top: 70px;">
	<div style="padding: 15px;">
	<?php

			$sql4 = "SELECT * FROM posts ORDER BY ID DESC ";
			$rest2 = mysqli_query($con,$sql4);
			$numb = mysqli_num_rows($rest2);

			if($numb>0)
			{
			 while($row = $rest2->fetch_assoc()) 
 				{
 					$p_content = $row["content"];
 					$post_date = $row["date_of_post"];
 					$pieces = explode(" ", $post_date);

          $piece1 =  explode("-", $pieces[0]);

          $date1 = $piece1[2];
          $month1 = $piece1[1];
          $year1 = $piece1[0];

 					$p_username = $row["username"];
 					$p_id = $row["ID"];
 					$p_likes = $row["likes"];

 					$sql5 = "SELECT * FROM profile WHERE username='$p_username'";
					$rest1 = mysqli_query($con,$sql5);

					$show = $rest1->fetch_assoc();
					$p_image = $show["image"];
					$p_username = $show["username"];

					$y_sql = "SELECT * FROM likes WHERE like_by='$username' && username='$p_username' && status ='1' && post_id='$p_id'";
					$y_res = mysqli_query($con,$y_sql);
					$y_rows = mysqli_num_rows($y_res);
					if($y_rows==0)
					{
						$like_color = "far";
					}
					else
					{
						$like_color = "fas";
					}

					$sql7 = "SELECT * FROM friends WHERE ((user_send='$username' && user_rec='$p_username')||(user_send='$p_username' && user_rec='$username'))&&send_status='true'&&rec_status='true'";
					$result7 = mysqli_query($con,$sql7);
					$count_n7 = mysqli_num_rows($result7);

					$sqlc = "SELECT * FROM comments WHERE post_id='$p_id'";
					$resc = mysqli_query($con,$sqlc);
					$numc = mysqli_num_rows($resc);
					if($count_n7>0)
					{

	echo "
 	<div class='container-fluid mt-2 post'>
        <div class='row'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <div class='post_content'>
                    <div class='head1_post'>
                        <img  src='images/$p_image' class='profile_img mx-3'>
                        <h4>$p_username</h4>
                    </div>
                    <div class='body_post'>
                        <p>
                            $p_content
                        </p>
                    </div>
                    <div class='footer_post'>
                        <p class='pt-4'>
                            $date1-$month1-$year1
                        </p>
                        <p class='pt-4 icon'>
              <form method='post' action='' id='form_likes'>
								<input type='number' id='post_id$p_id' value='$p_id' name='post_id$p_id' style='display:none'>
								<input type='text' id='post_username$p_id' value='$p_username' name='post_username$p_id' style='display:none'>
								<input type='text' id='curr_username$p_id' value='$username' name='curr_username$p_id' style='display:none'>
								<p type='submit' class='btn like_btn mt-3' id='$p_id' style='font-size:20px;'><span id='like$p_id'>$p_likes</span><i class='$like_color fa-heart' style='color:red'></i> </p>
							</form>
              <form action='comments.php' method='post'>
								<input type='number' value='$p_id' name='co_pid' style='display:none'>
								<button type='submit' class='btn'><i class='far fa-comment'></i> $numc</button>
							</form>
                        </p>
                    </div>
                </div>
            </div>
            <div class='col-md-3'></div>
        </div>
    </div>";
	}

}
	echo"
<div class='container-fluid mt-2'>
        <div class='row'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <div class='post_content'>
                    <div class='body_post'>
                        <h3 style='text-align:center;color:#474747'><b>Welcome to NeoApp</b></h3>
                        <p style='text-align:center;color:#474747'>Connect with friends to start seeing their ideas</p>
                    </div>
                </div>
            </div>
            <div class='col-md-3'></div>
        </div>
    </div>";
}

		?>
	</div>
</div>
<p id="result" style="display: none;"></p>
<!-- HTML Footer -->

<script type="text/javascript">
	document.getElementById('chat_count').innerHTML = "<?php 
	$sql_chat_count1 = "SELECT * FROM chats WHERE rec_username='$username' && rec_status='false'";
 	$chat_count_res1 = mysqli_query($con,$sql_chat_count1);
 	$num_rows_chat1 = mysqli_num_rows($chat_count_res1);

 	if($num_rows_chat1>0){
 	 	echo"( $num_rows_chat1 )";}
 	?>";
</script>

<?php echo "$html_end";?>
<script>
  $(document).ready(function () {
    $('.like_btn').click(function (e) {

      e.preventDefault();
    	var id = $(this).attr('id');
    	var p="post_id"+id;
    	var q="post_username"+id;
    	var r="curr_username"+id;
      var post_id = document.getElementById(p).value;
      var post_username =document.getElementById(q).value;
      var curr_username = document.getElementById(r).value;

      $.ajax
        ({
          type: "POST",
          url: "like.php",
          data: { "post_id": post_id, "post_username": post_username, "curr_username": curr_username },
          success: function (data) {
          	 $('#result').html(data);
          	 var t = document.getElementById('result').innerHTML ;
          	 var i = "like"+id;
          	 var c = document.getElementById(i).innerHTML;
          	
          	 if(t=="far")
          	 {
          	    c-=1;
          	 }
          	 else
          	 {
          	 	c=parseInt(c)+1;
          	 }
          	 document.getElementById(post_id).innerHTML = "<i class='"+t+" fa-heart' style='color:red'></i> <span id='like"+id+"'>"+c+"</span>";
          }
        });
    });
  });
</script>