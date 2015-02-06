<?php

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
 
 
 
 
 */






echo "pi guess: ".$pi."<br/>";
echo "turn speed: ".$turnSpeedFor360."<br/>";
echo "travel speed: ".$travelSpeed."<br/>";
echo "distance traveled: ".$distanceTraveled."<br/>";
echo "radius guess: ".$radiusGuess."<br/>";

echo "distance traved guess:".$distanceTraveled."<br/>";
echo "pi guess:".$piGuess."<br/>";
echo "funny then isnt it the case that: pi = (turnSpeedFor360 * travelSpeed) / diameter<br/>";


