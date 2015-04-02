<?php

class Twilio_Scavenger_Hunt_Stage {

    private $position;
    private $code;
    private $nextHint;
    private $nextSolution;

    private $extraText;

    public function __construct($position, $code, $nextHint, $nextSolution = null, $extraText = null) {

        $this->position = $position;
        $this->code = strtolower($code);
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

    public function getMessage() {
        if($this->isLastStage() || $this->isInitialMessage()){
            return $this->getExtraText();
        }else{
            return "Next Clue:\n"
                . $this->getNextHint()
                . ($this->getExtraText() ? "\n\n" . $this->getExtraText() : "");
        }
    }

    public function getSolutionMessage() {
        if(!$this->getNextSolution()){
            return "Sorry! There's no extra help for this one.";
        }
        return "Next Clue Help:\n" . $this->getNextSolution();
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

    public function getNextSolution() {
        return $this->nextSolution;
    }

    public function getExtraText() {
        return $this->extraText;
    }

}
