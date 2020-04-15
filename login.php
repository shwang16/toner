<?php
require('connectdb.php');
// require('account.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset = "utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css">
<style>
.error_message{color: #D4E4BC; }
</style>
<title> Log In </title>
</head>
<!-- onsubmit = "return checkUser()" -->
<body>
	<h1> Toner </h1>
	<!-- <div class="container"> -->
	<form action name = "<?php $_SERVER['PHP_SELF']?>" method = "post" on submit = "return checkUser(this)" >
    <div class = "form-group">
		<input type = "text" placeholder = "Username" id = "username" name = "userID"> <br>
    <span class = "error_message" id = "user_message" > </span>
  </div>

  <div class = "form-group">
		<input type = "password" placeholder = "Password" id = "pwd" name = "pwd" > <br>
  </div>

    <input type = "checkbox" id = "reveal"/> <label for = "reveal"> Show Password </label> <br>
    <a href = "account.php">Create an Account</a></br> </br>

<div class = "form-group">
<input type = "submit" name = "action" value = "Login" class = "btn btn-info" />
</div>



	</form>

<div id = "msg" class = "error_message"></div>
</body>

<script>


  (function() {
       var pass = document.getElementById("pwd");
       var rev = document.getElementById("reveal");

       rev.addEventListener("change", function() {
          try {
         	  if (rev.checked)
              pass.type ="text";
         	  else
              pass.type = "password";
          } catch(error) {
             alert("Cannot switch type");
          }
       }, false);
    }());


  var user = document.getElementById("username")

  function checkUser(){


    if(this.value.length < 8 || this.value.length > 25){
      document.getElementById("user_message").innerHTML = "Username must be between 8 and 25 characters.";

    }
    else{
      document.getElementById("user_message").innerHTML = "";

    }

  }
  if (user){
    user.addEventListener('blur', checkUser, false);
  }
</script>
<?php

session_start();
?>
<?php
function authenticate()
{
  require('form_handling.php');
  global $mainpage;
  global $db;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $hash_pwd = getPassword($_POST['userID']);
    $pwd = htmlspecialchars($_POST['pwd']);
    //echo '<br/> password_verify =' . password_verify($pwd, getPassword($_POST['userID'])) . "<br/>";

    if (password_verify($pwd, $hash_pwd))
    {
      echo "password matches <br>";

      header("Location: " . $mainpage);
      $_SESSION['user_id'] = getpk($_POST['userID'], $hash_pwd);


    }
    else {
      echo "password does not match <br/>";
    }
  }
}
$mainpage = "home.php";
authenticate();

?>
