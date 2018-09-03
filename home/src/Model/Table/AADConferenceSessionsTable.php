<?php
// src/Model/Table/AADConferenceSessionsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class AADConferenceSessionsTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_conference-test';
	}

	public static function isPlenaryFull($conference) {
		if (substr(strtolower($conference->plenary),0,1) == 'y') {
		  $this->loadModel('AADConferenceApplicants');
		  $query = $this->AADConferenceApplicants->find('all') ->where(['superseded'=>0, 'plenary'=>'y']);
      $count = $query->count();
			return $count >= $conference->plenary_max;
		}
		return false;
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('aad_conference_event');
		$this->setPrimaryKey('eventID');
		$this->hasMany('AADConferenceApplicants')
		     ->setForeignKey([
						'event1'//,'event1a','event1b','event2','event2a','event2b','event3','event3a','event3b','event4','event4a','event4b','event5','event5a','event5b','event6','event6a','event6b','event7','event7a','event7b','event8','event8a','event8b','event9','event9a','event9b'
					]);
	}

	public function getSessions()
	{
    $query = $this->find('all') ->contain(['AADConferenceApplicants']);
    $sessions = $query->all();
    return $sessions;
	}

	private function getOptionsFromText($text) {
	  $result = [];
	  $options = explode(',', $text);
	  foreach($options as $option) {
	    $parts = explode(':', $option);
	    $key = $parts[0];
	    $val = count($parts) > 1 ? $parts[1] : $parts[0];
	    $result[$key] = $value;
	  }
	  return count($result)>0 ? $result : ['y'=>'Yes', 'n'=>'No'];
	}

}