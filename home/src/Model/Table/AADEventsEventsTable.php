<?php
// src/Model/Table/AADEventsEventsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class AADEventsEventsTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('aad_events_event');
		$this->setPrimaryKey('eventID');
		$this->hasMany('AADEventsBookings') ->setForeignKey('eventID');
		$this->belongsTo('AADEventsLocations') ->setForeignKey('locationID');
	}

	public function getAvailable()
	{
	  $cutoff = date('Ymd');
    //$cutoff = '20170101';
    $query = $this->find('all') ->where(['sortdate >=' => $cutoff]) ->order(['sortdate' => 'ASC', 'eventname' => 'ASC']) ->contain('AADEventsLocations');
    $events = $query->all();
    foreach($events as $event) {
      $start_date = Time::createFromFormat('d/m/Y', $event->startdate);
      $event->startstamp = $start_date->getTimestamp();
      $event->display = '<strong>' . $event->eventname . '</strong> (<em>' . date("d F Y", $event->startstamp) . ', ' . $event->starttime . '</em>; &nbsp; ' . $event->a_a_d_events_location->location . ')';
    }
    return $events;
	}

}