<?php

class Twilio_Scavenger_Hunt_Stage {

    private $position;
    private $code;
    private $nextHint;
    private $nextSolution;

    private $extraText;

    public function __construct($position, $code, $nextHint, $nextSolution = null, $extraText = null) {

        $this->position = $position;
        $this->code = $code;
        $this->nextHint = $nextHint;
        $this->nextSolution = $nextSolution;
        $this->extraText = $extraText;

        if(!$this->position || !$this->code){
            throw new Exception('A stage must be instantiated with a position, and a code-word.');
        }

    }

    // assume last stage if there is no hint for a next stage
    public function isLastStage() {
        return ($this->nextHint ? false : true);
    }

    public function isInitialMessage() {
        return ($this->position === 0 ? true : false);
    }

    public function sendTextTwiml($twilioApi) {
        if($this->isLastStage() || $this->isInitialMessage()){
            $message = $this->getExtraText();
        }else{
            $message = "Clue #" . $this->getPosition() . ":\n\n"
                . $this->getNextHint()
                . ($this->getExtraText() ? "\n\n" . $this->getExtraText() : "");
        }
        return $twilioApi->sms($message);
    }

    public function getCode() {
        return $this->code;
    }

    public function getPosition() {
        return $this->position;
    }

    public function getNextHint() {
        return $this->nextHint;
    }

    public function getExtraText() {
        return $this->extraText;
    }

}
