<?php
// src/Controller/HarassmentController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;

class HarassmentController extends AppController
{

	public static function defaultConnectionName() {
			return 'harassment-test';
	}

	public function index()
	{
	  // For development only
	  $_SERVER['HTTP_WAF_WEBAUTH'] = 'ashgjp'; //'alls0027';

		$this->loadModel('HarassmentUsers');
		$user = $this->HarassmentUsers->getByOxfordID();
		$this->set('user', $user);

		$this->loadModel('HarassmentDepartments');
		$this->set('userdepts', $this->HarassmentDepartments->getByOxfordID());

		if ($this->request->is(['post', 'put'])) {
			$user = $this->HarassmentUsers->patchEntity($user, $this->request->getData());
      if (!empty($user->action)) {
        if ($user->action == 'report') {
          return $this->redirect([ 'action' => 'report', $user->userID, $user->deptcode, $user->acyear ]);
        } else {
          return $this->redirect([ 'action' => 'confirm', $user->userID, $user->deptcode, $user->acyear ]);
        }
      }
		}

	}

	public function report()
	{
		$this->loadModel('HarassmentDepartments');
		$this->set('departments', $this->HarassmentDepartments->getSelectOptions());

		$this->loadModel('HarassmentUsers');
		$this->set('user', $this->HarassmentUsers->getUserFromOxfordID());

		$this->loadModel('HarassmentSurveys');
		$survey = $this->HarassmentSurveys->newEntity();

		if ($this->request->is(['post', 'put'])) {
			$user = $this->HarassmentSurveys->patchEntity($survey, $this->request->getData(), ['validate'=>'register']);
			if ($this->HarassmentSurveys->save($survey)) {
				$this->Flash->success(__('Saved.'));
				return $this->redirect(['action' => 'confirm', $survey->surveyID]);
			}
			$this->Flash->error(__('Sorry. Your survey contains errors.'));
		}
		$this->set('survey', $survey);
	}

	public function confirm($surveyID)
	{
		$this->loadModel('HarassmentSurveys');
		$this->set('survey', $this->FinanceTravelAgents->getByID($surveyID));
	}

  // Allows the script file to be called individually
	public function script()
	{
	  $file = new File(WWW_ROOT . env('jsBaseUrl','js/') . $this->name . '/script.js');
    $script = $file->read();
    $response = $this->response;
    $response->body($script);
    $response = $response->withType('js');
    return $response;
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