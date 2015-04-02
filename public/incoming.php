<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
ini_set("log_errors", 1);
ini_set("error_log", "/var/www/scavengerhunt/tmp/logs/error.log");

error_log('incoming.php hit!');

require_once('../includes/twilio-php/Services/Twilio.php');
require_once('../includes/Twilio_Scavenger_Hunt.php');
require_once('../includes/Twilio_Scavenger_Hunt_Stage.php');

$scavengerHunt = new Twilio_Scavenger_Hunt();

$scavengerHunt->setIvrText("Hello! Welcome to the ultimate scavenger hunt. Text the word. start. to this phone number to begin. Goodbye.");
// $scavengerHunt->setIvrAudioFileUrl("http://example.com/some-recording-explaining-the-game.mp3");

$scavengerHunt->addStage("start", "I'm somewhere never wet", "In the dryer", "Good Luck!");
$scavengerHunt->addStage("penguin", "You might wear me out", "In your closet");
$scavengerHunt->addStage("giraffe", "I roll around", "On your computer chair");
$scavengerHunt->addStage("zebra", null, null, "Congratulations! You finished the scavenger hunt with flying colours!");

$scavengerHunt->processRequest();
