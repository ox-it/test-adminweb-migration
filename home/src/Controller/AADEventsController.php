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
	  $message  = "<p>Dear ".$person->title." ".$person->forename." ".$person->surname.",</p>\n";
    $message .= "<p>Your event registration has been recorded. You are now confirmed to attend the following AAD events:</p>\n";

    $message .= '<ul><li>' . implode("</li><li>\n", $booked) . "</li></ul>\n";

		$message .= "<p>To cancel a booking, please call the AAD Communications team on 284847 or email us at ";
		$message .= '<a href="mailto:AcademicAdmin.Comms@admin.ox.ac.uk">AcademicAdmin.Comms@admin.ox.ac.uk</a>.</p>' . "\n";
		$message .= "<p>You may log back in to the AAD events registration form via the AAD Staff Events page ";
		$message .= '(<a href="http://www.admin.ox.ac.uk/aad/communications/events/">http://www.admin.ox.ac.uk/aad/communications/events/</a>)' . "\n";
		$message .= "to register for new events as they become available.</p>\n";

		$message .= "<p>Kind Regards,</p>\n";
		$message .= "<p><strong>Academic Administration Division Communications</strong>,<br>\n";
		$message .= "University of Oxford,<br>\n";
		$message .= "Examination Schools,<br>\n";
		$message .= "75-81 High Street,<br>\n";
		$message .= "Oxford<br>\n";
		$message .= "OX1 4BG</p>\n";
		$message .= "<p>Tel: 01865 (2)84847<br>\n";
		$message .= 'Email: <a href="mailto:AcademicAdmin.Comms@admin.ox.ac.uk">AcademicAdmin.Comms@admin.ox.ac.uk</a><br>' . "\n";
		$message .= 'Web: <a href="http://www.admin.ox.ac.uk/aad">www.admin.ox.ac.uk/aad</a></p>' . "\n";

		// Send the email
		$email = new Email('default');
  	$email->from(['AcademicAdmin.Comms@admin.ox.ac.uk' => 'Academic Administration Division Communications'])
			->to($person->email)
			->subject('AAD Event Registration')
			->emailFormat('html')
			->send($message);
	}

}