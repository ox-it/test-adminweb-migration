<?php
// src/Model/Table/SafetyEventsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SafetyEventsTable extends Table
{

    public static function defaultConnectionName() {
      return 'safety';
    }

    public function initialize(array $config)
    {
        $db_config = $config['connection']->config();
        $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
        $table = $prefix . 'event';
        $this->setTable($table);
        $this->addBehavior('Timestamp');
        $this->setPrimaryKey('eventID');
        $this->belongsTo('SafetyCourses')->setForeignKey('courseID');
        $this->hasMany('SafetyApplicants')->setForeignKey('applicantID');
    }

    public function getByID($eventID = null) {
      //$event = $this->get($eventID);
      $query = $this->find('all', ['conditions' => ['eventID' => $eventID]] );
      $event = $query->first();

      if (!empty($event->eventstatuscode) && !empty($event->category)) {
        $event->waiting = ( $event->eventstatuscode=='F' || $event->category==4 );
      }
      if (!empty($event->datestart)) {
        $start_date = Time::createFromFormat('d/m/Y', $event->datestart);
        $event->startstamp = $start_date->getTimestamp();
      }

      return $event;
    }

    public function futureEventsForCourseID($courseID = null) {
      // Can't use this because dates are stored as strings!
      // 'SafetyEvents.datestart >' => new Time('+12 hours'),
      // Can't use this because dates are stored as strings!
      // 'order' => [ 'SafetyEvents.datestart' => 'ASC', 'SafetyEvents.timestart' => 'ASC' ]

      //$query = $this->find('all') ->where(['sortdate >=' => $cutoff]) ->order(['sortdate' => 'ASC', 'eventname' => 'ASC']) ->contain('UASEventsLocations');
      $events_query = $this->find('all', [
        'conditions' =>
          [
            'SafetyEvents.courseID' => $courseID,
          ],
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

    public function openEventsForCourseID($courseID = null) {
      $events_query = $this->find('all') ->where([ 'SafetyEvents.courseID' => $courseID, 'SafetyEvents.eventstatuscode ' => 'O' ]);
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
      return $events;
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