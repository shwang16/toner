
<html>
<head>
<title>Toner</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="edit.css">


</head>

<?php
require("connectdb.php");
include("func.php");
$tones = getAllTones();
$pad = getPad();
//echo $pad;

?>

<body>
<div class="row">
  <div class="col-md-6" >
    <div class="pad">
      <button style='font-size: 20px;' class="button selected" id="1" onclick="high('1')"><?php echo getTone($pad['tone1'])['name'] ?></button>
      <button style='font-size: 20px;' class="button" id="2" onclick="high('2')"><?php echo getTone($pad['tone2'])['name'] ?></button>
      <button style='font-size: 20px;' class="button" id="3" onclick="high('3')"><?php echo getTone($pad['tone3'])['name'] ?></button>
      <br>
      <button style='font-size: 20px;' class="button" id="4" onclick="high('4')"><?php echo getTone($pad['tone4'])['name'] ?></button>
      <button style='font-size: 20px;' class="button" id="5" onclick="high('5')"><?php echo getTone($pad['tone5'])['name'] ?></button>
      <button style='font-size: 20px;' class="button" id="6" onclick="high('6')"><?php echo getTone($pad['tone6'])['name'] ?></button>
      <br>
      <button style='font-size: 20px;' class="button" id="7" onclick="high('7')"><?php echo getTone($pad['tone7'])['name'] ?></button>
      <button style='font-size: 20px;' class="button" id="8" onclick="high('8')"><?php echo getTone($pad['tone8'])['name'] ?></button>
      <button style='font-size: 20px;' class="button" id="9" onclick="high('9')"><?php echo getTone($pad['tone9'])['name'] ?></button>
    </div>
  </div>

  <div class="col-md-6">
    <div class="sounds">
      <?php foreach ($tones as $tone): ?>
      <button class="notes" id="<?php echo $tone['id']; ?>" onclick="update_pad('<?php echo $tone['name']; ?>','<?php echo $tone['id']; ?>')">
      <?php echo $tone['name']; ?></button>
      <?php endforeach; ?>
      <button class="notes" onclick="myFunction()"><img src="images/add.svg"></button>
      <!-- onclick="add_sound()" -->
    </div>

    <div id="myDIV">
      <h3>Add a Tone</h3>
      <form action="edit.php" name="add_tone" method="post" onsubmit="return checkForm()">
        <div class="form-group">
    		<input type="text" placeholder="name" id="tone_name" name="toneName" value=""><br>
        <span class="error_message" id="name_message"></span>
        </div>
        <div class="form-group">
    		<input type="text" placeholder="(Hz)" id="freq" name="frequency"><br>
        <span class="error_message" id="freq_message"></span>
        </div>
        <a href=https://pages.mtu.edu/~suits/notefreqs.html>Frequency Chart</a><br><br>
        <div class="form-group">
        <button type="submit" value="addTone">Add</button><br>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="bar">
  <button class="circle" id="home" >
    <img src="images/house.svg">
  </button>
  <br>
  <button class="circle" id="edit">
    <img src="images/edit.svg">
  </button>
  <button class="circle" id="logout">
    <img src="images/logout.svg">
  </button>
</div>

</body>

<script type="text/javascript">

var highlighted = "1";
document.cookie = "update_tone=tone1";
document.cookie = "tone_id=1";
var high = (id) => {
  //console.log("clicked");
  document.getElementById(highlighted).classList.remove("selected");
  document.getElementById("" + id).classList.add("selected");
  highlighted = id;
  //console.log(highlighted);
};

var home = () => { window.location.href='home.php'; };
document.getElementById("home").addEventListener("click", home);

var logout = () => { window.location.href='login.php'; };
document.getElementById("logout").addEventListener("click", logout);

function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function checkForm(){
  var name = document.getElementById("tone_name").value;
  var freq = document.getElementById("freq").value;
  var check = /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;
  if(name == ""){
    document.getElementById("tone_name").value = "";
    document.getElementById("name_message").innerHTML = "Name field is empty."
    return false;
  }
  else if(name.length > 6){
    document.getElementById("tone_name").value = name;
    document.getElementById("name_message").innerHTML = "Name must be less than 6 characters."
    return false;
  }
  else if(!freq.match(check)){
    document.getElementById("freq").value = freq;
    document.getElementById("freq_message").innerHTML = "Frequency must be a valid value (0-999.99)."
    return false;
  }

  $.ajax({
     url: "update.php?call=tone",
     type: "POST",
     data: {name: name, freq: freq},
     success: function(result){
       console.log(result);
     }
  })
  return true;
}

function update_pad(name, id){
  document.getElementById(highlighted).innerHTML = name;
  //var url = "update.php?update_tone=tone" + highlighted + "&tone_id=" + id;
  // console.log(url);
  // var xhttp = new XMLHttpRequest();
  // xhttp.open("GET", url, true);
  // xhttp.send();
  var tone = "tone" + highlighted;
  var toneID = id;
  $.ajax({
     url: "update.php?call=pad",
     type: "POST",
     data: {update_tone: tone, tone_id: toneID},
     success: function(result){
       console.log(result);
     }
  })
}
</script>


</html>
