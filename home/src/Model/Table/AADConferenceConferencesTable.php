<?php
// src/Model/Table/AADConferenceConferencesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class AADConferenceConferencesTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_conference-test';
	}

	public static function isPlenaryFull($conference) {
		if (substr(strtolower($conference->plenary),0,1) == 'y') {
		  if (empty($conference->plenary_max)) return false;
		  $this->loadModel('AADConferenceApplicants');
		  $query = $this->AADConferenceApplicants->find('all') ->where(['superseded'=>0, 'plenary'=>'y']);
      $count = $query->count();
			return $count >= $conference->plenary_max;
		}
		return true;
	}

	public static function isSpeakersQuestionFull($conference) {
		if (substr(strtolower($conference->speakerquestion),0,1) == 'y') {
		  if (empty($conference->speakerquestion_max)) return false;
		  $this->loadModel('AADConferenceApplicants');
		  $query = $this->AADConferenceApplicants->find('all') ->where(['superseded'=>0, 'speakersquestion'=>'y']);
      $count = $query->count();
			return $count >= $conference->speakerquestion_max;
		}
		return true;
	}

	public static function isBikeRepairFull($conference) {
		if (substr(strtolower($conference->bikerepair),0,1) == 'y') {
		  if (empty($conference->bikerepair_max)) return false;
		  $this->loadModel('AADConferenceApplicants');
		  $query = $this->AADConferenceApplicants->find('all') ->where(['superseded'=>0, 'bikerepair'=>'y']);
      $count = $query->count();
			return $count >= $conference->bikerepair_max;
		}
		return true;
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('eventdetails');
	}

	public function getLatest()
	{
    $query = $this->find('all') ->order(['id'=>'DESC']);
    $conference = $query->first();
    $conference->lunchOptions = $this->getOptionsFromText($conference->lunch_options);
    $conference->plenaryOptions = $this->getOptionsFromText($conference->plenary_options);
    $conference->plenaryIsFull = self::isPlenaryFull($conference);
    $conference->speakersQuestionIsFull = self::isSpeakersQuestionFull($conference);
    $bro = (!empty($conference->bikerepeair_yes) && !empty($conference->bikerepeair_no)) ? 'y:'.$conference->bikerepeair_yes.',n:'.$conference->bikerepeair_no : '';
    $conference->bikeRepairOptions = $this->getOptionsFromText($bro);
    $conference->bikeRepairIsFull = self::isBikeRepairFull($conference);
    $conference->accessibilityOptions = ['y'=>'Yes', 'n'=>'No'];
    return $conference;
	}

	private function getOptionsFromText($text) {
	  $result = [];
	  if (!empty($text)) {
			$options = explode(',', $text);
			foreach($options as $option) {
				$parts = explode(':', $option);
				$key = $parts[0];
				$val = count($parts) > 1 ? $parts[1] : $parts[0];
				$result[$key] = $val;
			}
	  }
	  return count($result)>0 ? $result : ['y'=>'Yes', 'n'=>'No'];
	}

}