<?php
require('connectdb.php');
/*************************/
/** get's users password **/
function getPassword($userID){

// if ($_SERVER['REQUEST_METHOD'] == 'POST')
// {

    global $db;

    $query = "SELECT password FROM user WHERE username = :userID limit 1;";

    $statement = $db->prepare($query);
	$statement->bindValue(':userID', $userID);
    $statement->execute();
    $results = $statement->fetch();

    return $results['password'];


}


function getpk($userID, $pwd){
    global $db;
    $query = "SELECT id FROM user WHERE username = :userID AND password = :pwd limit 1;";
    // AND password = :pwd
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':pwd', $pwd);
    $statement->execute();
    $results = $statement->fetch();

    return $results['id'];

}

function getuser($userID){
    global $db;
    $query = "SELECT username FROM user WHERE username = :userID limit 1;";
    // AND password = :pwd
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $results = $statement->fetch();

    return $results['username'];
}
?>
