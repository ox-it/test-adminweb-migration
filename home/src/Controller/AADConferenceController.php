<?php
// src/Controller/AADConferenceController.php

namespace App\Controller;

//use Cake\Datasource\ConnectionManager;
use App\Form\GraduateAccomodationForm;

class AADConferenceController extends AppController
{

	public static function defaultConnectionName() {
			return 'aad_conference-test';
	}

	public function index()
	{
	  // For development only
	  $_SERVER['HTTP_WAF_WEBAUTH'] = 'ouit0197';

		$this->loadModel('AADConferenceConferences');
		$conference = $this->AADConferenceConferences->getLatest();
		$this->set('conference', $conference);

		$this->loadModel('AADConferenceColleges');
		$colleges = $this->AADConferenceColleges->getSelectOptions();
		$this->set('colleges', $colleges);

		$this->loadModel('AADConferenceDepartments');
		$departments = $this->AADConferenceDepartments->getSelectOptions();
		$this->set('departments', $departments);

		$this->loadModel('AADConferenceSessions');
		$sessions = $this->AADConferenceSessions->getSessions();
		$this->set('sessions', $sessions);

		$this->loadModel('AADConferenceApplicants');
		$applicant = $this->AADConferenceApplicants->getByOxfordID();
		if (empty($applicant)) {
		  $applicant = $this->AADConferenceApplicants->newEntity();
		  $applicant->newUser = true;
		}
		if ($this->request->is('post')) {
			$applicant = $this->AADConferenceApplicants->patchEntity($applicant, $this->request->getData());
			$applicant->eventID = $eventID;
			$applicant->statuscode = ($event->waiting) ? 'L' : 'A';
			if ($this->AADConferenceApplicants->save($applicant)) {
				$this->Flash->success(__('Your application has been saved.'));
				return $this->redirect(['action' => 'success', $applicant->applicantID]);
			}
			$this->Flash->error(__('Unable to process your application.'));
		}
		$this->set('applicant', $applicant);
	}

}