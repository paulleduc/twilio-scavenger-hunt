<?php

class Twilio_Scavenger_Hunt {

	private $twilioApi;

	private $ivrText;
	private $ivrAudioFileUrl;

	private $requestData;
	private $requestType;

	private $stages = array();

    public function __construct() {

    	$this->setRequestData();

    }

	private function getTwilioApi() {
    	if(!$this->twilioApi){
    		$this->twilioApi = new Services_Twilio_Twiml();
    	}
    	return $this->twilioApi;
    }

    private function setRequestData() {
    	$this->requestData = $_POST;
    	if(isset($this->requestData['CallSid'])){
    		$this->requestType = 'call';
    	}elseif(isset($this->requestData['MessageSid'])){
    		$this->requestType = 'text';
    	}else{
    		$this->requestType = 'web';
    	}
    }

    public function processRequest() {
    	if($this->getRequestType() == 'call'){
    		$this->playIvr();
    	}elseif($this->getRequestType() == 'text'){
    		$stage = $this->getCurrentStage();
    		if($stage){
                if($this->isSolutionRequested()){
                    $this->sendText($stage->getSolutionMessage());
                }else{
                    $this->sendText($stage->getMessage());
                }
    		}else{
    			$this->sendText($this->invalidCodeMessage());
    		}
    	}
    	// do nothing for general web requests...
    }

    public function invalidCodeMessage() {
        return "Sorry, that's not a valid clue code!";
    }

    public function addStage($code, $nextHint, $nextSolution = null, $extraText = null) {
    	$position = $this->countStages() + 1;
    	$this->stages[] = new Twilio_Scavenger_Hunt_Stage($position, $code, $nextHint, $nextSolution, $extraText);
    }

    public function getCurrentStage() {
    	foreach($this->getStages() as $stage) {
    		if($this->getStageFromText() == $stage->getCode()){
    			return $stage;
    		}
    	}
    	return null;
    }

    public function getStageFromText() {
        $words = $this->getTextWords();
        if(count($words)){
            return strtolower($words[0]);
        }
    }

    public function isSolutionRequested() {
        $words = $this->getTextWords();
        if(count($words) == 2 && strtolower($words[1]) == 'help'){
            return true;
        }
        return false;
    }

    public function getTextWords() {
    	return explode(' ', $this->getRequestData('Body'));
    }

    public function playIvr() {
    	if($this->getIvrAudioFileUrl()){
    		$this->getTwilioApi()->play($this->getIvrAudioFileUrl());
    	}elseif($this->getIvrText()){
    		$this->getTwilioApi()->say($this->getIvrText(), array("voice" => "woman"));
    	}else{
    		$this->getTwilioApi()->say('No IVR has been set for incoming calls to this number. Goodbye.', array("voice" => "woman"));
    	}
    	$this->printTwiml();
    }

    public function sendText($message) {
        $this->getTwilioApi()->sms($message);
        $this->printTwiml();
    }

    private function printTwiml() {
    	header('Content-type: application/xml');
    	echo $this->getTwilioApi();
    	die();
    }

    private function getRequestData($parameter = null) {
    	if($parameter){
    		if(isset($this->requestData[$parameter])){
    			return $this->requestData[$parameter];
    		}
			return null;
    	}
    	return $this->requestData;
    }

    private function getRequestType() {
    	return $this->requestType;
    }

    public function getIvrAudioFileUrl() {
    	return $this->ivrAudioFileUrl;
    }

    public function setIvrAudioFileUrl($ivrAudioFileUrl) {
    	$this->ivrAudioFileUrl = $ivrAudioFileUrl;
    }

    public function getIvrText() {
    	return $this->ivrText;
    }

    public function setIvrText($ivrText) {
    	$this->ivrText = $ivrText;
    }

    public function getStages() {
    	return $this->stages;
    }

    public function getFirstStage() {
    	foreach($this->getStages() as $stage) {
    		if($stage->getPosition() == 1){
    			return $stage->getPosition();
    		}
    	}
    	if($this->countStages()){
    		return $this->stages[0];
    	}
    }

    public function countStages() {
    	return count($this->stages);
    }

}
