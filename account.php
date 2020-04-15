<?php
require('connectdb.php');
require('form_handling.php');
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset = "utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css">
<style>
    body{background color: #7C9885;
        text-align: center;
    }
    h1 {color: #28666E;
        text-align:center;
        font-weight: bold;
        padding-top:100px;
        font-size: 80px;

    }
    .error_message{color: #D4E4BC; }



</style>
<title> Create an Account </title>
</head>

<body>
    <div class = "container">
    <h1>Create an Account </h1>

    <form action= "<?php $_SERVER['PHP_SELF']?>" name = "CreateAccount" method = "post" onSubmit = "return checkAccount(this)" >
    <div class = "form-group">
        <label for ="user">Enter username between 8 and 25 characters: </label>
        <input type = "text" id = "user" name = "userID" class = "form-control" style = 'margin:auto' input style = "width:150px" placeholder = "Enter username.">
        <span class = "error_message" id = "user_message" > </span>

    </div>
    <div class = "form-group">
        <label for ="password">Enter password between 8 and 25 characters: </label>
        <input type = "password" id = "pwd" name = "pwd" class = "form-control" style = 'margin:auto' placeholder = "Enter password.">
        <span class = "error_message" id = "pw_message" > </span>
    </div>
    <div class = "form-group">
        <label for ="password">Re-enter Password: </label>
        <input type = "password" id = "pwd2" name = "pwd2" class = "form-control" style = 'margin:auto' placeholder = "Re-enter password.">
        <span class = "error_message" id = "pw_message2" > </span>
    </div>
    <input type = "submit" name = "action" value = "Create Account" class = "btn btn-info" />
</form>

<script>
var p1 = document.getElementById('pwd');
var p2 = document.getElementById('pwd2');
var user = document.getElementById('user');
function checkAccount(){
    // var p1 = document.getElementById('pwd');
    // var p2 = document.getElementById('pwd2');
    document.getElementById("pw_message").innerHTML = "";
    document.getElementById("pw_message2").innerHTML = "";
    document.getElementById("user_message").innerHTML = "";

    if(user.value == ""){
        document.getElementById("user_message").innerHTML = "Please enter username.";
        return false;
    }
    else if(user.value.length < 8 || user.value.length > 25){
        document.getElementById("user_message").innerHTML = "Please enter username between 8 and 25 characters.";
        return false;
    }
    else if(p1.value == ""){
        document.getElementById("pw_message").innerHTML = "Please enter password.";
        return false;
    }
    else if((p1.value.length < 8 || p1.value.length > 25)){
        document.getElementById("pw_message").innerHTML = "Password must be between 8 and 25 characters.";
        return false;
    }
    else if (p2.value == ""){
        document.getElementById("pw_message2").innerHTML = "Please enter confirmation password.";
        return false;
    }
    else if (p1.value != p2.value){
        document.getElementById("pw_message2").innerHTML = "Passwords are not the same.";
        return false;
    }
    else{
        document.getElementById("pw_message").innerHTML = "";
        return true;
     }
}





</script>


<?php
/*************************/
/** insert user into table **/
function addUser($userID, $pwd){
  global $db;
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pwd = htmlspecialchars($_POST['pwd']);
    $hash_pwd = password_hash($pwd, PASSWORD_BCRYPT);
    $query = "INSERT INTO user
            (username, password) VALUES (:userID, :hash_pwd)";
    if ($_POST['userID'] !== getuser($_POST['userID']) ){
      $statement = $db->prepare($query);
      $statement->bindValue(':userID', $userID);
      $statement->bindValue(':hash_pwd', $hash_pwd);
      $statement->execute();
      $statement->closeCursor();
      $_SESSION['user_id'] = getpk($_POST['userID'],$hash_pwd);

      newPad();
      header("Location: login.php?action=add_user");
    }
    else{
      echo "Username already exists.";
    }
 }
}

function newPad(){
  global $db;
  $user_id = $_SESSION['user_id'];
  $query = "INSERT INTO pad (user_id, tone1, tone2, tone3, tone4, tone5, tone6, tone7, tone8, tone9)
            VALUES (:id, 1, 2, 3, 4, 5, 6, 7, 8, 9)";
  $statement = $db->prepare($query);
  //$statement->bindValue(':tone', $tone_name);
  $statement->bindValue(':id', $user_id);
  $statement->execute();
  $statement->closeCursor();
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(!empty($_POST['action']) && ($_POST['action'] == 'Create Account')){

        if (!empty($_POST['userID']) && !empty($_POST['pwd']))
      {

        addUser($_POST['userID'], $_POST['pwd']);



      }
   }
}
?>
</body>
</div>

</html>
