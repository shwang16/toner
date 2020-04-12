<?php
session_start();
if(isset($_SESSION['user_id'])){
  $userID = $_SESSION['user_id']; // how to get current user ID
}
else {
  $userID = 1;
}



function getTone($id)
{
  global $db;

  $query = "SELECT * FROM tone WHERE id=:id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();

  $results = $statement->fetch();

  $statement->closeCursor();
  return $results;
}

function getPad()
{
  global $db;
  global $userID;

  $query = "SELECT * FROM pad WHERE user_id=:userID";
  $statement = $db->prepare($query);
  $statement->bindValue(':userID', $userID);
  $statement->execute();

  $results = $statement->fetch();

  $statement->closeCursor();
  return $results;
}

function getAllTones()
{
  global $db;

  $query = "SELECT * FROM tone";
  $statement = $db->prepare($query);
  $statement->execute();

  $results = $statement->fetchAll();

  $statement->closeCursor();
  return $results;
}



/*user
username VARCHAR(25)
password VARCHAR(255)
id AUTO-INCREMENT PRIMARY KEY

tone
id AUTO-INCREMENT
name VARCHAR(6)
frequency DOUBLE(5,2)

create table pad
(user_id int,
tone1 int,
tone2 int,
tone3 int,
tone4 int,
tone5 int,
tone6 int,
tone7 int,
tone8 int,
tone9 int,
foreign key(user_id) references user(id),
foreign key(tone1) references tone(id),
foreign key(tone2) references tone(id),
foreign key(tone3) references tone(id),
foreign key(tone4) references tone(id),
foreign key(tone5) references tone(id),
foreign key(tone6) references tone(id),
foreign key(tone7) references tone(id),
foreign key(tone8) references tone(id),
foreign key(tone9) references tone(id)
);

*/



?>
