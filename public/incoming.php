<?php

$scavengerHunt = new Twilio_Scavenger_Hunt();

$this->setIvrText("Hello! Welcome to the unltimate scavenger hunt! Text the word start to this phone number to begin!");

$scavengerHunt->addStage("start", "I open at the close1.", "In your closet.", "Crossword Clue: 6 Across: A strange smell");
$scavengerHunt->addStage("two", "I open at the close2.", "In your closet.", "Crossword Clue: 6 Across: A strange smell");
$scavengerHunt->addStage("three", "I open at the close3.", "In your closet.", "Crossword Clue: 6 Across: A strange smell");
$scavengerHunt->addStage("four", "I open at the close4.", "In your closet.", "Crossword Clue: 6 Across: A strange smell");

$scavengerHunt->processRequest();
