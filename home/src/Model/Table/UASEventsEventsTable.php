<?php
// src/Model/Table/UASEventsEventsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class UASEventsEventsTable extends Table
{

	public static function defaultConnectionName() {
		return 'uas_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('uas_events_event');
		$this->setPrimaryKey('eventID');
		$this->hasMany('UASEventsBookings') ->setForeignKey('eventID');
		$this->belongsTo('UASEventsLocations') ->setForeignKey('locationID');
	}

	public function getAvailable()
	{
	  $cutoff = date('Ymd');
    $query = $this->find('all') ->where(['sortdate >=' => $cutoff]) ->order(['sortdate' => 'ASC', 'eventname' => 'ASC']) ->contain('UASEventsLocations');
    $events = $query->all();
    foreach($events as $event) {
      $start_date = Time::createFromFormat('d/m/Y', $event->startdate);
      $event->startstamp = $start_date->getTimestamp();
      $event->display = '<strong>' . $event->eventname . '</strong> (<em>' . date("d F Y", $event->startstamp) . ', ' . $event->starttime . '</em>; &nbsp; ' . $event->u_a_s_events_location->location . ')';
    }
    return $events;
	}

}