<?php
// src/Model/Table/SafetyEventsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SafetyEventsTable extends Table
{

		public static function defaultConnectionName() {
			return 'safety-test';
		}

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->setTable('safety_event');
        $this->setPrimaryKey('eventID');
        $this->belongsTo('SafetyCourses')->setForeignKey('courseID');
        $this->hasMany('SafetyApplicants')->setForeignKey('applicantID');
    }

    public function getByID($eventID = null) {
      $event = $this->get($eventID);

      $event->waiting = ( $event->eventstatuscode=='F' || $event->category==4 );

      $start_date = Time::createFromFormat('d/m/Y', $event->datestart);
      $event->startstamp = $start_date->getTimestamp();

      return $event;
    }

    public function futureEventsForCourseID($courseID = null) {
      $events_query = $this->find('all', [
        'conditions' =>
					[
						'SafetyEvents.courseID' => $courseID,
						'SafetyEvents.eventstatuscode ' => 'O',
						// Can't do this because they are stored as strings!
						// 'SafetyEvents.datestart >' => new Time('+12 hours'),
					],
				// Can't do this because they are stored as strings!
				// 'order' => [ 'SafetyEvents.datestart' => 'ASC', 'SafetyEvents.timestart' => 'ASC' ]
      ]);
      $events = $events_query->all();
      foreach ($events as $event) {
        //print_r($event);
        $start_date = Time::createFromFormat('d/m/Y H:i', $event->datestart . ' ' . $event->timestart);
        $event->startstamp = $start_date->getTimestamp();
        $event->month = date("m",$event->startstamp);
        $cutoff_date = new Time('+12 hours');
        $event->cutoff = $cutoff_date->getTimestamp();
        $event->ignore = ($event->startstamp < $event->cutoff);
        $open_date = Time::createFromFormat('d/m/Y', $event->bookingopen);
        $event->openstamp = $open_date->getTimestamp();
        if (!empty($event->bookingclosed)) {
	        $closed_date = Time::createFromFormat('d/m/Y', $event->bookingclosed);
	      } else {
	        $closed_date = $cutoff_date;
	      }
        $event->closedstamp = $closed_date->getTimestamp();
      }
      $events->sortBy('startstamp');
      $result = $events->reject(function ($event, $key) {
        return $event->ignore === true;
      });
      return $result;
    }

    public function cancellableEvents() {
      $nowstamp = time();
      $query = $this->find('all')
				->where([
					'OR' => [['SafetyCourses.category' => 1], ['SafetyCourses.category' => 4]],
					'OR' => [['eventstatuscode' => 'O'], ['eventstatuscode' => 'C'], ['eventstatuscode' => 'F']]
			  ])
        ->contain([ 'SafetyCourses' ]);
      $events = $query->all();
      foreach ($events as $event) {
        $start_date = Time::createFromFormat('d/m/Y H:i', $event->datestart . ' ' . $event->timestart);
        $event->startstamp = $start_date->getTimestamp();
        $event->ignore = ($event->startstamp < $nowstamp);
        //print_r($event);
      }
      $events->sortBy('startstamp');
      $result = $events->reject(function ($event, $key) {
        return $event->ignore === true;
      });
      return $result;
    }

}