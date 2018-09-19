<?php
// src/Model/Table/UASEventsBookingsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class UASEventsBookingsTable extends Table
{

	public static function defaultConnectionName() {
		return 'uas_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('uas_events_booking');
		$this->setPrimaryKey('bookingID');
		$this->hasOne('UASEventsEvents') ->setBindingKey('eventID') ->setForeignKey('eventID') ->setJoinType('INNER');
	}

	public function getByID($bookingID = null)
	{
		$booking = $this->get($bookingID);
		return $booking;
	}

  public function getByOxfordID()
  {
	  $cutoff = date('Ymd');
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all') ->where(['oxfordID'=>$oxfordID,'sortdate >=' => $cutoff]) ->order(['webdatesort'=>'ASC']) ->contain(['UASEventsEvents','UASEventsEvents.UASEventsLocations']);
    $bookings = $query->all();
    foreach($bookings as $booking) {
			$start_date = Time::createFromFormat('d/m/Y', $booking->u_a_s_events_event->startdate);
      $booking->u_a_s_events_event->startstamp = $start_date->getTimestamp();
    }
    return $bookings;
  }

	public function getByOxfordIDForEvents($events)
	{
	  if (empty($events) || count($events)==0) return null;
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
		$validator ->notEmpty(['surname','forename','title','jobtitle','phone','email','email2']);
		$validator ->lengthBetween('phone', [5, 16], 'Please enter a valid phone number');
		$validator ->equalToField('email','email2','The emails do not match');
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