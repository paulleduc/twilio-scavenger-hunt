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

$scavengerHunt->setIvrText("Hello! Welcome to the unltimate scavenger hunt! Text the word start to this phone number to begin!");

$scavengerHunt->addStage("start", "I open at the close1.", "In your closet1.", "Crossword Clue: 6 Across: A strange smell");
$scavengerHunt->addStage("two", "I open at the close2.", "In your closet2.", "Crossword Clue: 6 Across: A strange smell");
$scavengerHunt->addStage("three", "I open at the close3.", "In your closet3.", "Crossword Clue: 6 Across: A strange smell");
$scavengerHunt->addStage("four", "I open at the close4.", "In your closet4.", "Crossword Clue: 6 Across: A strange smell");

$scavengerHunt->processRequest();
