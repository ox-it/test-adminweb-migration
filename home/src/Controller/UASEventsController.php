<?php
// src/Controller/UASEventsController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;

class UASEventsController extends AppController
{

	public static function defaultConnectionName() {
			return 'uas_events-test';
	}

	public function index()
	{
	  // DONE: Remove test SSO
	  // $_SERVER['HTTP_WAF_WEBAUTH'] = 'ouit0197';
    $oxfordID = empty($_SERVER['HTTP_WAF_WEBAUTH']) ? 'unknown' : $_SERVER['HTTP_WAF_WEBAUTH'];

		$this->loadModel('UASEventsLocations');
		$this->set('locations', $this->UASEventsLocations->getSelectOptions());

		$this->loadModel('UASEventsColleges');
		$this->set('colleges', $this->UASEventsColleges->getSelectOptions());

		$this->loadModel('UASEventsDepartments');
		$this->set('departments', $this->UASEventsDepartments->getSelectOptions());

		$this->loadModel('UASEventsEvents');
		$events = $this->UASEventsEvents->getAvailable();
		$this->set('events', $events);

		$this->loadModel('UASEventsBookings');
		$bookings = $this->UASEventsBookings->getByOxfordIDForEvents($events);
		$this->set('bookings', $bookings);

		$this->loadModel('UASEventsPeople');
		$person = $this->UASEventsPeople->getByOxfordID();
		if (empty($person)) $person = $this->UASEventsPeople->newEntity();

		if ($this->request->is(['post', 'put'])) {
			$person = $this->UASEventsPeople->patchEntity($person, $this->request->getData(), ['validate'=>'register']);
			if ($this->UASEventsPeople->save($person)) {
				$this->Flash->success(__('Saved.'));
				$booked = [];
				foreach($events as $event) {
				  $key = 'event_' . $event->eventID;
          if (!empty($person->$key)) {
            $booking = null;
            foreach ($bookings as $booking) if ($booking->eventID == $event->eventID) break;
            if (empty($booking)) {
              $booking = $this->UASEventsBookings->newEntity();
  						$booking->oxfordID = $oxfordID;
  						$booking->eventID = $event->eventID;
  						$booking->webdate = date('d/m/Y');
  						$booking->webdatesort = date('Y/m/d');
  						$booking->webtime = date('H:i');
            }
						$booking->bookstatus = $person->$key;
            $booking = $this->UASEventsBookings->updateWithPerson($booking, $person);
            if ($person->$key=='B') $booked[] = $event->display;
						$this->UASEventsBookings->save($booking);
          }
				}
			  if (count($booked)>0) $this->emailConfirmation($person, $booked);
    		$this->set('person', $person);
    		$this->set('bookings', $this->UASEventsBookings->getByOxfordID());
				$this->render('success');
				return;
			} else {
			  $this->Flash->error(__('Unable to process your changes at this time.'));
			}
		}
		$this->set('person', $person);

	}

	public function success($personID)
	{
		// For development only
	  //if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) $_SERVER['HTTP_WAF_WEBAUTH'] = 'ouit0197';

		$this->loadModel('UASEventsPeople');
		$person = $this->UASEventsPeople->getByOxfordID();
		$person->mismatch = (empty($person) || $person->personID!=$personID);
		$this->set('person', $person);

		$this->loadModel('UASEventsBookings');
		$this->set('bookings', $this->UASEventsBookings->getByOxfordID());
	}

	private function emailConfirmation($person, $booked)
	{
		$file = new File(WWW_ROOT . env('cssBaseUrl','css/') . 'waf.css');
    $css = str_replace('.web-app-wrapper ','',$file->read());
		$email = new Email();
		$email->template('new_uas_event_booking');
		$email->viewVars(['person' => $person, 'booked' => $booked, 'waf' => $this->Waf, 'css'=>$css ]);
  	$email->subject('UAS Event Registration');
  	$email->from(['uas.communications@admin.ox.ac.uk' => 'UAS Communications']);
    $email->to($person->email);

		// TODO: Remove test email
    $email->to([ "al.pirrie@it.ox.ac.uk" => 'Al Pirrie', 'al@cache.co.uk' => 'Al' ]);

		$email->emailFormat('html');
  	$email->send();
  }

}