<?php

$pi = 4;

$turnSpeedFor360 = 5;
$travelSpeed = 10;

$distanceTraveled = $turnSpeedFor360 * $travelSpeed;

$radiusGuess = $distanceTraveled / $pi;

$distanceTravedGuess = $radiusGuess * $pi;

$piGuess = $distanceTravedGuess / $radiusGuess;

$pi = $distanceTraveled / $radiusGuess;

/**
 * the hope is that we can say we got it :)
 
 $pi = ($turnSpeedFor360 * $travelSpeed) / ($radiusGuess / $pi)
 
 how can we get pi out of this as a parameter
 we can try it by replacing pi with $distanceTravedGuess / $radiusGuess
 
 $pi = ($turnSpeedFor360 * $travelSpeed) / ($radiusGuess / ($distanceTravedGuess / $radiusGuess))
 
 */

echo "pi guess: ".$pi."<br/>";
echo "turn speed: ".$turnSpeedFor360."<br/>";
echo "travel speed: ".$travelSpeed."<br/>";
echo "distance traveled: ".$distanceTraveled."<br/>";
echo "radius guess: ".$radiusGuess."<br/>";

echo "distance traved guess:".$distanceTraveled."<br/>";
echo "pi guess:".$piGuess."<br/>";
echo "funny then isnt it the case that: pi = (turnSpeedFor360 * travelSpeed) / (radiusGuess / (distanceTravedGuess / radiusGuess))<br/>";
