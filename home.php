
<html>
<head>
<title>Toner</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="home.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<?php
require("connectdb.php");
include("func.php");
$pad = getPad();
//echo $pad;
?>

<body>

<div class="pad">

  <!-- sourceBuffer.start(context.currentTime) -->
  <button class="button" id="one" onclick="playNote(<?php echo getTone($pad['tone1'])['frequency'] ?>, context.currentTime, 0.116)"></button>
  <button class="button" id="two" onclick="playNote(<?php echo getTone($pad['tone2'])['frequency'] ?>, context.currentTime, 0.116)"></button>
  <button class="button" id="three" onclick="playNote(<?php echo getTone($pad['tone3'])['frequency'] ?>, context.currentTime, 0.116)"></button>
  <br>
  <button class="button" id="four" onclick="playNote(<?php echo getTone($pad['tone4'])['frequency'] ?>, context.currentTime, 0.116)"></button>
  <button class="button" id="five" onclick="playNote(<?php echo getTone($pad['tone5'])['frequency'] ?>, context.currentTime, 0.116)"></button>
  <button class="button" id="six" onclick="playNote(<?php echo getTone($pad['tone6'])['frequency'] ?>, context.currentTime, 0.116)"></button>
  <br>
  <button class="button" id="seven" onclick="playNote(<?php echo getTone($pad['tone7'])['frequency'] ?>, context.currentTime, 0.116)"></button>
  <button class="button" id="eight" onclick="playNote(<?php echo getTone($pad['tone8'])['frequency'] ?>, context.currentTime, 0.116)"></button>
  <button class="button" id="nine" onclick="playNote(<?php echo getTone($pad['tone9'])['frequency'] ?>, context.currentTime, 0.116)"></button>
</div>

<div class="bar">
  <button class="circle" id="home">
    <img src="images/house.svg">
  </button>
  <br>
  <button class="circle" id="edit" onclick="editPage()">
    <img src="images/edit.svg">
  </button>
  <br>
  <button class="circle" id="logout">
    <img src="images/logout.svg">
  </button>
</div>

</body>

<script>
function editPage(){
  window.location.href='edit.php';
}

var logout = () => { window.location.href='login.php'; };
document.getElementById("logout").addEventListener("click", logout);

var context = new AudioContext();
//acquired from https://code.tutsplus.com/tutorials/the-web-audio-api-adding-sound-to-your-web-app--cms-23790
var playNote = function (frequency, startTime, duration) {
    var osc1 = context.createOscillator(),
        osc2 = context.createOscillator(),
        volume = context.createGain();

    // Set oscillator wave type
    osc1.type = 'triangle';
    osc2.type = 'triangle';

    volume.gain.value = 0.1;

    // Set up node routing
    osc1.connect(volume);
    osc2.connect(volume);
    volume.connect(context.destination);

    // Detune oscillators for chorus effect
    osc1.frequency.value = frequency + 1;
    osc2.frequency.value = frequency - 2;

    // Fade out
    volume.gain.setValueAtTime(0.1, startTime + duration - 0.05);
    volume.gain.linearRampToValueAtTime(0, startTime + duration);

    // Start oscillators
    osc1.start(startTime);
    osc2.start(startTime);

    // Stop oscillators
    osc1.stop(startTime + duration);
    osc2.stop(startTime + duration);
};



</script>

</html>
