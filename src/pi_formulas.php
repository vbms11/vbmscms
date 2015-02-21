<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<?php

// 
function timeForDeceleration ($startVelocity, $endVelocity, $gravity = 9.8) {
	$time = ($startVelocity - $endVelocity) / $gravity;
	return $time;
}

function getEndVelocityAtTime ($startVelocity, $time, $gravity) {
	
	
	// $time = ($startVelocity - $endVelocity) / $gravity;
	// $endVelocity = $startVelocity - ($time * $gravity);
	// return $time;
}

function heightReached ($startVelocity, $endVeolcity, $gravity = 9.8) {
	//$t = timeForDeceleration($startVelocity, $endVeolcity);
	//$height = ($startVelocity * $t) + (0.5 * $gravity * (pow($t, 2)));
	//return $height;
	
	
	
	$height = (pow($startVelocity, 2) - pow($endVeolcity, 2)) / (2 * $gravity);
	return $height;
}

function distanceReachedAtTime ($startVelocity, $time) {
	$height = ($startVelocity * $time) + (0.5 * $gravity * pow($time, 2));
	return $height;
	
}

function speedTraveledIfReachedThatHeight ($height, $gravity = 9.8) {
	$height = (pow($startVelocity, 2) - pow($endVeolcity, 2)) / (-(2* $gravity));
	return $height;
}

function getVelocity ($startVelocity, $time, $gravity = 9.8) {
	$endVelocity = $startVelocity + sqrt(2.0 * $gravity * $time);
	return $endVelocity;
}

function normalize ($x, $y) {
	$length = sqrt(pow($x, 2) + pow($y, 2));
	$x /= $length;
	$y /= $length;
	return array($x, $y);
} 



$piGuess = 3.141; // M_PI;
$velocity = 26.3;

$height = heightReached($velocity, 0);
$time = timeForDeceleration($velocity, 0);
$height2 = distanceReachedAtTime($velocity, $time);
$distance = 4 * $time * $velocity;
$diameter = $height * 2;
$pi = $distance / $diameter;

$ratio = $vec[0]

echo "velocity: ".$velocity."<br/>";
echo "height: ".$height."<br/>";
echo "height2: ".$height2."<br/>";
echo "time: ".$time."<br/>";
echo "distance: ".$distance."<br/>";
echo "diameter: ".$diameter."<br/>";
echo "pi: ".$pi."<br/>";
echo "".($height / ($time * $velocity));

/*

$radius = $height;
$circumfrence = $height * 2 * $piGuess;
$halfTime = $time / 2;
$heightAtHalfTime = ($velocity * $halfTime) + (0.5 * 9.8 * (pow($halfTime, 2)));
$ratioOfHeight = $height / $heightAtHalfTime;

echo "<hr/> knowing PI:<br/>";
echo "circumfrence: $circumfrence<br/>";
echo "height at half time: ".$heightAtHalfTime."<br/>";
echo "ratio of height: $ratioOfHeight<br/>";
echo "<hr/>";

$distance = distanceReachedAtTime($velocity, $halfTime);
$component = normalize($distance, $distance);

echo "height at half time: ".$heightAtHalfTime."<br/>";
echo "component at half time: x: ".$component[0].", y: ".$component[1]."<br/>";
echo "<hr/>";

$angle = 30;
$angleRatio = $angle / 90;
$xTime = $time * (1 - $angleRatio);
$yTime = $time * $angleRatio;
$xDistance = distanceReachedAtTime($velocity, $xTime);
$yDistance = distanceReachedAtTime($velocity, $yTime);
$component = normalize($xDistance, $yDistance);

echo "angle ".$angle."<br/>";
echo "angleRatio ".$angleRatio."<br/>";
echo "xTime ".$xTime."<br/>";
echo "yTime ".$yTime."<br/>";
echo "xDistance ".$xDistance."<br/>";
echo "yDistance ".$yDistance."<br/>";
echo "component: x: ".$component[0].", y: ".$component[1]."<br/>";
echo "<hr/>";

echo "knowing pi<br/>";
echo "angle ".$angle."<br/>";
echo "component: x: ".cos(deg2rad($angle)).", y: ".sin(deg2rad($angle))."<br/>";
echo "<hr/>";
/*

// throw a ball in steps
$steps = 20;
$coordinates = array();
// 
$angle = 45;
$speed = 50;
// components of the motion
$components = normalize(1, 1);
$xSpeed = $speed * $components[0];
$ySpeed = $speed * $components[1];
$timeTaken = timeForDeceleration($speed, 0) * 2;
$distanceTraveledX = $xSpeed * $timeTaken;
$heightReached = heightReached($ySpeed, 0);
echo "direction components: ".print_r($components)."<br/>";
echo "time to hit ground: ".$timeTaken."<br/>";
echo "heightReached: ".$heightReached."<br/>";
echo "distanceTraveledX: ".$distanceTraveledX."<br/>";
//echo "<br/>";
//echo "<br/>";
// for each step
for ($i=0; $i<$steps; $i++) {
	$xDistance = $i * ($distanceTraveledX / $steps);
	//if ($i < $steps / 2) {
		// on the way up
		$endVelocity = getVelocity($ySpeed, ($timeTaken / $steps) * $i);
		
		$yDistance = heightReached($ySpeed, $endVelocity);
	//}
	echo "new coordinate: ".$xDistance.", ".$yDistance."</br>";
	$coordinates[$i] = array($xDistance, $yDistance);
}


$a = -9.8;
$t = 4;



/*

s = ut + 0.5at^2

Initial velocity of the ball = 26.3m/s

(v^2-u^2/(-2g) = (0^2-26.3^2)/(2*-9.8)=35.2903 m.

In the downward motionthe initial velocity u is 0 at the heighest pointthe acceleration is gand the final velocity is v towards earths= 35.2803m. So the equation of motion is:

v^2-u^2= 2gs or

v= sqrt(2gs) = sqrt(2*9.8*35.2903)=26.3m/s vertically down ward.

Time taken to reach the ground , t=(v-u)/g= (26.3-0)/9.8=2.6837 s

*/



/*

$piGuess = 3.141; // M_PI;

$turnSpeedFor360 = 5;
$travelSpeed = 10;

$distanceTraveled = $turnSpeedFor360 * $travelSpeed;

$radiusGuess = $distanceTraveled / $piGuess;

$pi = $distanceTraveled / $radiusGuess;

$diameter = $distanceTraveld / $pi;
// pi = circumfrance / diameter



$distanceTravedGuess = $radiusGuess * $pi;

$piGuess = $distanceTravedGuess / $radiusGuess;
$coordinate = $distanceTraveled / 2;
$radius = $distanceTraveled / 2;

echo "pi = distanceTraveled / (radius / (distanceTraveled / radius))";

*/

/*
 * 
$distanceTravedGuess = $radiusGuess * $pi;

$piGuess = $distanceTravedGuess / $radiusGuess;
$coordinate = $distanceTraveled / 2;
$radius = $distanceTraveled / 2;
*/


// $y = sqare($coordinate power(2) + $coordinate power(2))


/**
 * the hope is that we can say we got it :)
 
 $radiusGuess = $distanceTraveled / $pi;
 
(speed * rotateSpeed) / ($distanceTraveled / $pi)
 
 
 $pi = ($turnSpeedFor360 * $travelSpeed) / ($radiusGuess / $pi)
 
 how can we get pi out of this as a parameter
 we can try it by replacing pi with $distanceTravedGuess / $radiusGuess
 
 $pi = ($turnSpeedFor360 * $travelSpeed) / ($radiusGuess / ($distanceTravedGuess / $radiusGuess))
 $pi = $distanceTraveledGuess / $radiusGuess

 
 
 turnSpeed = 4;
 360 / 8 = 45 degrees per second
 
 speed = 1
 if radius = 1
 distance = turnSpeed * speed / 8
 coordinate = sqr
 diameter = 2
 pi = turnSpeed * speed / 8 / diameter
 
 
function () {

}
 # get length of vector
 math.sqrt( x**2 + y**2)
 
 ratio = math.sqrt( 1**2 + 1**2)
 x = 1 / ratio;
 y = 1 / ratio;
 
 x = sin(45) 
 y = cos(45)
 radius = 1
 diameter = 2
 speed = 1
 rotateSpeed = 360
 
 correct rotate speed
 
 rotateSpeed / lengthRatio
 circumfrence = 1 * rotateSpeed;
 
 pi = circumfrence / 2
 
 correct vector to 1 at 45 degrees
 multiply by x,y * length() / 8
 
 rotateSpeed / 8 * speed = 45 degrees
 
 
 
 
 

echo "pi guess: ".$pi."<br/>";
echo "turn speed: ".$turnSpeedFor360."<br/>";
echo "travel speed: ".$travelSpeed."<br/>";
echo "distance traveled: ".$distanceTraveled."<br/>";
echo "radius guess: ".$radiusGuess."<br/>";

echo "distance traved guess:".$distanceTraveled."<br/>";
echo "pi guess:".$piGuess."<br/>";
echo "funny then isnt it the case that: pi = (turnSpeedFor360 * travelSpeed) / diameter<br/>";

*/

?>



<?php 
/*
echo "pi guess: ".$pi."<br/>";
echo "turn speed: ".$turnSpeedFor360."<br/>";
echo "travel speed: ".$travelSpeed."<br/>";
echo "distance traveled: ".$distanceTraveled."<br/>";
echo "radius guess: ".$radiusGuess."<br/>";

echo "distance traved guess:".$distanceTraveled."<br/>";
echo "pi guess:".$piGuess."<br/>";
echo "funny then isnt it the case that: pi = (turnSpeedFor360 * travelSpeed) / diameter<br/>";
*/

?>
<div>
<button id="start">start</button>
<button id="pause">pause</button>
<input id="angle" value="" />
<button id="showAngle">show</button>
</div>

<canvas id="myCanvas" width="1000" height="1000" style="border:1px solid silver;">
Your browser does not support the HTML5 canvas tag.
</canvas>

<?php 


?>

<script>
var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
var coordinates = <?php echo json_encode($coordinates); ?>;
var timeFor360 = 30 * 1000;
var currentTime = 0;
var velocity = 26.3;
var realAngle;
var realX;
var realY;
var run = true;
var gravity = 9.8;
var estimateComponents;

// sil cos sin functions
function timeForDeceleration (startVelocity, endVelocity) {
	time = (startVelocity - endVelocity) / gravity;
	return time;
}
function distanceReachedAtTime (startVelocity, time) {
	var height = (startVelocity * time) + (0.5 * gravity * Math.pow(time, 2));
	return height;	
}
function normalize (x, y) {
	var length = Math.sqrt(Math.pow(x, 2) + Math.pow(y, 2));
	var x = x / length;
	var y = y / length;
	return [x, y];
} 
function silCosSin (angle) {
	var angleRatio = angle / 90;
	var time = timeForDeceleration(velocity, 0);
	var xTime = time * (1 - angleRatio);
	var yTime = time * angleRatio;
	var xDistance = distanceReachedAtTime(velocity, xTime);
	var yDistance = distanceReachedAtTime(velocity, yTime);
	//var component = normalize(xDistance, yDistance);
	//return component;
	return [xDistance, yDistance];
}


// test functions
function toRadians (angle) {
	return angle * (Math.PI / 180);
}
function drawLines(coordinates) {
	ctx.moveTo(0,0);
	for (var i=0; i<coordinates.length; i++) {
		var vertex = coordinates[i];
		ctx.lineTo(vertex[0],1000-vertex[1]);
	}
	ctx.stroke();
}
function drawCircle (x, y, d) {
	ctx.beginPath();
	ctx.arc(x, y, d, 0, 2 * Math.PI);
	ctx.stroke();
}
function clearCanvas () {
	ctx.clearRect (0, 0, c.width, c.height);
}
function drawRealPiDot (x, y, d) {
	realX = Math.cos(toRadians(realAngle));
	realY = Math.sin(toRadians(realAngle));
	
	
	x = (realX * d) + x;
	y = (realY * d) + y;
	drawCircle(x, y, 5);
}
function drawSinCosEstimate (x, y, d) {
	estimateComponents = silCosSin(realAngle);
	ctx.moveTo(x, y);
	ctx.lineTo(estimateComponents[0] * d + x, estimateComponents[1] * d + y);
	ctx.stroke();
}
function drawInfo (x, y) {
	var offset = 20;
	ctx.font = "16px Arial";

	ctx.fillText("angle: "+realAngle, x, y);
	
	ctx.fillText("x: "+realX, x, y + offset);
	ctx.fillText("y: "+realY, x, y + (offset * 2));
	
	ctx.fillText("ex: "+estimateComponents[0], x, y + (offset * 3));
	ctx.fillText("ey: "+estimateComponents[1], x, y + (offset * 4));
}

function estimatePi () {

	
	var time = timeForDeceleration(velocity, 0);
	var diameter90 = distanceTraveledInTime(velocity, 0, time);
	var diameter360 = diameter90 * 2;
	var cirumfrence = velocity * time;
	var diameter = [];

	var velocityStart = [velocity, 0];
	var velocityEnd = [0, velocity];
	
	
	var pi = cirumfrence360 / diameter360;
	
	
	return $pi;
}

function draw () {
	clearCanvas();
	drawCircle(200,200,100);
	
	drawRealPiDot(200, 200, 100);
	drawSinCosEstimate(200, 200, 100);
	drawInfo(500, 100);
}

window.setInterval(function(){

	if (run) {
		
		currentTime += 100;
		var ratio = currentTime / timeFor360;
		realAngle = 360 * ratio;
		realAngle %= 360;
		draw();
		
	}
	
}, 100, this);
$("#start").click(function(){
	run = true;
});
$("#pause").click(function(){
	run = false;
});
$("#showAngle").click(function(){
	run = false;
	realAngle = $("#angle").val();
	draw();
});

// drawLines(coordinates);
</script>

</body>
</html>






