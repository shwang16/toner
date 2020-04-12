<?php
require("connectdb.php");
session_start();
if(isset($_SESSION['user_id'])){
  $userID = $_SESSION['user_id']; // how to get current user ID
}
else {
  $userID = 1;
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if($_GET['call'] == 'pad'){
    updatePad($_POST['update_tone'], $_POST['tone_id']);
  }
  else if($_GET['call'] == 'tone'){
    addTone($_POST['name'], $_POST['freq']);
  }

}

function updatePad($tone, $id){
  global $db;
  global $userID;
  settype($id, 'int');
  $query = "UPDATE pad SET " . $tone . "=:tone_id WHERE user_id=:userID";
  $statement = $db->prepare($query);
  //$statement->bindValue(':tone', $tone_name);
  $statement->bindValue(':tone_id', $id);
  $statement->bindValue(':userID', $userID);
  $statement->execute();
  $statement->closeCursor();
  echo $query;
}

function addTone($name, $value){
  global $db;
  global $userID;
  $query = "INSERT INTO tone (name, frequency) VALUES (:name, :value)";
  $statement = $db->prepare($query);
  //$statement->bindValue(':tone', $tone_name);
  $statement->bindValue(':name', $name);
  $statement->bindValue(':value', $value);
  $statement->execute();
  $statement->closeCursor();
  echo $query;
}



?>
