<?php
	
	$con = new mysqli("localhost","root","", "pinchat");
	$color1 = "black";
	$color2 = "black";
	$color3 = "black";
	$color4 = "black";
  $color5 = "black";
	$html_start = "<!doctype html>
<html lang='en'>
  <head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1' crossorigin='anonymous'>

    <!-- Google Font Roboto Link -->
    <link rel='preconnect' href='https://fonts.gstatic.com'>
<link href='https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap' rel='stylesheet'>

    <!-- Tab Icon Image -->

    <link rel='icon' type='image/x-icon' href='images/logo.png'>

    <title>NeoApp</title>
    <style>
    body{
      font-family:'Roboto',sans-serif;
      padding:0px;
      margin:0px;
    }
    </style>
    ";

  $html_end = " <!-- Optional JavaScript; choose one of the two! -->

<script type='text/javascript'>
    function menu(value) {
        if (value == 1) {
            document.documentElement.style.position = 'fixed';
        } else if (value == 2) {
            document.documentElement.style.position = 'static';
        }
    }
    </script>

<script type='text/javascript'>
	if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js' integrity='sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW' crossorigin='anonymous'></script>
    
    <!-- Icons Script -->
    <script src='https://kit.fontawesome.com/56eedf655b.js' crossorigin='anonymous'></script>

    <script src='https://unpkg.com/aos@2.3.1/dist/aos.js'></script>
    <script>
      AOS.init({duration : 700});
    </script>
    <!-- JQuery CDN Link -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js' integrity='sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU' crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js' integrity='sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj' crossorigin='anonymous'></script>
    -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'>

</script>
  </body>
</html>";



	$menu_bar = "<style type='text/css'>
    * {
    margin: 0;
    padding: 0;
    font-family: 'montserrat', sans-serif;

}
body {
    background: #F0F2F5;
}

.header {
    height: 60px;
    background: #ffffff;
    padding: 0 20px;
    color: #fff;
    box-shadow: 0px 7px 13px 0px rgba(0, 0, 0, 0.16);
    -webkit-box-shadow: 0px 7px 13px 0px rgba(0, 0, 0, 0.16);
    -moz-box-shadow: 0px 7px 13px 0px rgba(0, 0, 0, 0.16);
}

.logo {
    padding: 11px;
    float: left;
    text-transform: uppercase;
}

.menu {
    float: right;
    line-height: 60px;
}

.menu a {
    color: #000;
    text-decoration: none;
    padding: 0 18px;
    color: #353A3F;

}

.menu a i {
    font-size: 18px;
    padding: 6px;
}

.show-menu-btn,
.hide-menu-btn {
    transition: 0.4s;
    font-size: 30px;
    cursor: pointer;
    display: none;
}

.show-menu-btn {
    float: right;
}

.show-menu-btn i {
    line-height: 60px;
    color: #2496FF;
}

.menu a:hover,
.show-menu-btn:hover,
.hide-menu-btn:hover {
    color: #2496FF;
}

#chk {
    position: absolute;
    visibility: hidden;
    z-index: -1111;
}

.content {
    padding: 0 20px;
}

.content img {
    width: 100%;
    max-width: 700px;
    margin: 20px 0;
}

.content p {
    text-align: justify;
}

@media screen and (max-width:992px) {

    .show-menu-btn,
    .hide-menu-btn {
        display: block;
    }

    .menu {
        position: fixed;
        width: 100%;
        height: 100vh;
        background: #0A345B;
        color: #ffffff;
        right: -100%;
        top: 0;
        text-align: center;
        padding: 80px 0;
        line-height: normal;
        transition: 0.7s;
        overflow: hidden;
    }

    .menu a {
        display: block;
        padding: 20px;
        color: #ffffff;
    }

    .hide-menu-btn {
        position: absolute;
        top: 40px;
        right: 40px;
    }

    #chk:checked~.menu {
        right: 0;
    }

}
  </style>

    <div class='header fixed-top'>
        <h2 class='logo'><img src='images/logo1.png' height='36px'></h2>
        <input type='checkbox' id='chk'>
        <label for='chk' class='show-menu-btn' id='menu_btn' onclick='menu(1)'>
            <i class='fas fa-bars'></i>
        </label>
        <ul class='menu' id='navbar'>
            <a href='home.php' id='color1'><i class='fas fa-home' onclick='menu(2);'></i>Home</a>
            <a href='friend.php' id='color2'><i class='fas fa-user-friends' onclick='menu(2);'></i>Friends</a>
            <a href='posts.php' id='color3'><i class='fas fa-mail-bulk' onclick='menu(2);'></i>My Posts</a>
            <a href='chats.php' id='color4'><i class='fas fa-paper-plane' onclick='menu(2);'></i>Chat <span id='chat_count'></span></a>
            <a href='profile.php' id='color5'><i class='fas fa-user-circle' onclick='menu(2);'></i>Profile</a>
            <a href='index.php'><i class='fas fa-sign-out-alt' onclick='menu(2);'></i>Logout</a>
            <label for='chk' class='hide-menu-btn' id='menu_cross' onclick='menu(2);'>
                <i class='fas fa-times'></i>
            </label>
        </ul>
    </div>";
?>

