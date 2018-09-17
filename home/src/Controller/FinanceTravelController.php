<?php
// src/Controller/FinanceTravelController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;

class FinanceTravelController extends AppController
{

	public static function defaultConnectionName() {
			return 'finance_travel-test';
	}

	public function index()
	{
		$this->loadModel('FinanceTravelDepartments');
		$this->set('departments', $this->FinanceTravelDepartments->getSelectOptions());

		$this->loadModel('FinanceTravelAgents');
		$this->set('agents', $this->FinanceTravelAgents->getAllAlphabetically());

		$this->loadModel('FinanceTravelApplicants');
		$applicant = $this->FinanceTravelApplicants->newEntity();

		if ($this->request->is(['post', 'put'])) {
			$applicant = $this->FinanceTravelApplicants->patchEntity($applicant, $this->request->getData(), ['validate'=>'register']);
			if ($this->FinanceTravelApplicants->save($applicant)) {
				$this->Flash->success(__('Saved.'));
				return $this->redirect(['action' => 'confirm', $applicant->applicantID]);
			}
			$this->Flash->error(__('Sorry. Your request contains errors.'));
		}
		$this->set('applicant', $applicant);
	}

	public function confirm($applicantID)
	{
		$this->loadModel('FinanceTravelAgents');
		$this->set('agents', $this->FinanceTravelAgents->getAllAlphabetically());
		$this->loadModel('FinanceTravelApplicants');
		$this->set('applicant', $this->FinanceTravelApplicants->getByID($applicantID));
	}

	private function emailConfirmation($applicant)
	{
	  $message  = "<p>Dear ".$applicant->title." ".$applicant->forename." ".$applicant->surname.",</p>\n";
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