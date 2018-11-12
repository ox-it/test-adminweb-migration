<?php
// src/Controller/AADEventsController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;

class AADEventsController extends AppController
{

	public static function defaultConnectionName() {
			return 'aad_events-test';
	}

	public function index()
	{
    $oxfordID = empty($_SERVER['HTTP_WAF_WEBAUTH']) ? 'unknown' : $_SERVER['HTTP_WAF_WEBAUTH'];

		$this->loadModel('AADEventsLocations');
		$this->set('locations', $this->AADEventsLocations->getSelectOptions());

		$this->loadModel('AADEventsColleges');
		$this->set('colleges', $this->AADEventsColleges->getSelectOptions());

		$this->loadModel('AADEventsDepartments');
		$this->set('departments', $this->AADEventsDepartments->getSelectOptions());

		$this->loadModel('AADEventsEvents');
		$events = $this->AADEventsEvents->getAvailable();
		$this->set('events', $events);

		$this->loadModel('AADEventsBookings');
		$bookings = $this->AADEventsBookings->getByOxfordIDForEvents($events);
		$this->set('bookings', $bookings);

		$this->loadModel('AADEventsPeople');
		$person = $this->AADEventsPeople->getByOxfordID();
		if (empty($person)) $person = $this->AADEventsPeople->newEntity();

		if ($this->request->is(['post', 'put'])) {
			$person = $this->AADEventsPeople->patchEntity($person, $this->request->getData(), ['validate'=>'register']);
			if ($this->AADEventsPeople->save($person)) {
				$this->Flash->success(__('Saved.'));
				$booked = [];
				foreach($events as $event) {
				  $key = 'event_' . $event->eventID;
          if (!empty($person->$key)) {
            $booking = null;
            foreach ($bookings as $booking) if ($booking->eventID == $event->eventID) break;
            if (empty($booking)) {
              $booking = $this->AADEventsBookings->newEntity();
  						$booking->oxfordID = $oxfordID;
  						$booking->eventID = $event->eventID;
  						$booking->webdate = date('d/m/Y');
  						$booking->webdatesort = date('Y/m/d');
  						$booking->webtime = date('H:i');
            }
						$booking->bookstatus = $person->$key;
            $booking = $this->AADEventsBookings->updateWithPerson($booking, $person);
            if ($person->$key=='B') $booked[] = $event->display;
						$this->AADEventsBookings->save($booking);
          }
				}
			  if (count($booked)>0) $this->emailConfirmation($person, $booked);
    		$this->set('person', $person);
    		$this->set('bookings', $this->AADEventsBookings->getByOxfordID());
				$this->render('success');
				return;
			}
			$this->Flash->error(__('Unable to process your changes at this time.'));
		}
		$this->set('person', $person);

	}

	private function emailConfirmation($person, $booked)
	{
		$file = new File(WWW_ROOT . env('cssBaseUrl','css/') . 'waf.css');
    $css = str_replace('.web-app-wrapper ','',$file->read());
		$email = new Email();
		$email->template('new_aad_event_booking');
		$email->viewVars(['person' => $person, 'booked' => $booked, 'waf' => $this->Waf, 'css'=>$css ]);
  	$email->subject('AAD Event Registration');
  	$email->from(['AcademicAdmin.Comms@admin.ox.ac.uk' => 'Academic Administration Division Communications']);
    $email->to($person->email);

		// TODO: Remove test email
    $email->to([ "al.pirrie@it.ox.ac.uk" => 'Al Pirrie', 'al@cache.co.uk' => 'Al' ]);

		$email->emailFormat('html');
  	$email->send();
  }

}