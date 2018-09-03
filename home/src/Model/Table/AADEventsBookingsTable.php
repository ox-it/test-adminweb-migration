<?php
// src/Model/Table/AADEventsBookingsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class AADEventsBookingsTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('aad_events_booking');
		$this->setPrimaryKey('bookingID');
		$this->hasOne('AADEventsEvents') ->setBindingKey('eventID') ->setForeignKey('eventID') ->setJoinType('INNER');
	}

	public function getByID($bookingID = null)
	{
		$booking = $this->get($bookingID);
		return $booking;
	}

  public function getByOxfordID()
  {
	  $cutoff = date('Ymd');
    $cutoff = '20170101';
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all') ->where(['oxfordID'=>$oxfordID,'sortdate >=' => $cutoff]) ->order(['webdatesort'=>'ASC']) ->contain(['AADEventsEvents','AADEventsEvents.AADEventsLocations']);
    $bookings = $query->all();
    foreach($bookings as $booking) {
			$start_date = Time::createFromFormat('d/m/Y', $booking->a_a_d_events_event->startdate);
      $booking->a_a_d_events_event->startstamp = $start_date->getTimestamp();
    }
    return $bookings;
  }

	public function getByOxfordIDForEvents($events)
	{
	  $eventIDs = [];
	  foreach($events as $event) $eventIDs[] = $event->eventID;
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all') ->where(['oxfordID'=>$oxfordID, 'eventID IN' => $eventIDs]) ->order(['webdatesort'=>'ASC']);
    $bookings = $query->all();
    return $bookings;
	}

	public function validationRegister()
	{
		$validator = new Validator();
		$validator ->requirePresence('surname') ->notBlank('surname', 'Please complete this field');
		$validator ->requirePresence('forename') ->notBlank('forename', 'Please complete this field');
		$validator ->requirePresence('title') ->notBlank('title', 'Please complete this field');
		$validator ->requirePresence('jobtitle') ->notBlank('jobtitle', 'Please complete this field');
		$validator ->lengthBetween('phone', [5, 16], 'Please enter a valid phone number');
		$validator ->requirePresence('email') ->notBlank('email', 'Please enter a valid email address') ->equalToField('email','email2','The emails do not match');
		$validator ->requirePresence('email2') ->notBlank('email', 'Please enter a valid email address');
		return $validator;
	}

	public function beforeSave($event, $entity, $options)
	{
		if ($entity->isNew()) {
			$entity->oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? $_SERVER['HTTP_WAF_WEBAUTH'] : 'notgiven';
			$entity->timestamp = time();
			$entity->webdate = date('d/m/Y');
			$entity->webdatesort = date('Y/m/d');
			$entity->webtime = date('H:i');
		}
	}

	public function updateWithPerson($booking, $person)
	{
		$booking->surname = $person->surname;
		$booking->title = $person->title;
		$booking->deptcode = $person->deptcode;
		$booking->depttext = $person->depttext;
		$booking->collcode = $person->collcode;
		$booking->phone = $person->phone;
		$booking->email = $person->email;
		return $booking;
	}

}