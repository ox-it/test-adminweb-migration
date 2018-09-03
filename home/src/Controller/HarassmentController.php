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
		$user = $this->getOxfordUserAndValidate();
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

	public function report($userID, $deptcode, $acyear)
	{
		$user = $this->getOxfordUserAndValidate();
		$this->loadModel('HarassmentSurveys');
		$survey = $this->HarassmentSurveys->newEntity(['personID'=>$userID, 'deptcode'=>$deptcode, 'year'=>$acyear]);

		$this->loadModel('HarassmentDepartments');
		$this->set('departments', $this->HarassmentDepartments->getSelectOptions());

		if ($this->request->is(['post', 'put'])) {
			$survey = $this->HarassmentSurveys->patchEntity($survey, $this->request->getData(), ['validate'=>'report']);
			if ($this->HarassmentSurveys->save($survey)) {
				$this->Flash->success(__('Saved.'));
				return $this->redirect(['action' => 'success', $survey->surveyID]);
			} else {
			  $this->Flash->error(__('Sorry. Your survey contains errors.'));
			}
		}
		$this->set('survey', $survey);
	}

	public function confirm($userID, $deptcode, $acyear)
	{
		$user = $this->getOxfordUserAndValidate();
		$this->loadModel('HarassmentSurveys');
		$survey = $this->HarassmentSurveys->getByDeptAndYear($deptcode, $acyear);
		//$this->Flash->success('SURVEY: '.json_encode($survey));
		$this->set('survey', $survey);
		//$surveys = $this->HarassmentSurveys->getByDept($deptcode);
		//$this->Flash->success('SURVEYS: '.json_encode($surveys));
		$this->set('surveys', []);
		if (empty($survey)) {
		  $nilreport = $this->HarassmentSurveys->newEntity([
		    'personID' => $userID,
		    'deptcode' => $deptcode,
		    'year' => $acyear,
		    '0nilreturn' => 1
		  ]);
		  $this->HarassmentSurveys->save($nilreport);
  		$this->set('report', $nilreport);
		}
	}

	public function success($surveyID)
	{
		$user = $this->getOxfordUserAndValidate();
		$this->loadModel('HarassmentSurveys');

		$survey = $this->HarassmentSurveys->getByID($surveyID);
		if (empty($user) || empty($survey->personID) || $survey->personID!=$user->userID) {
		  $this->render('nouser');
		  return null;
		}

    $this->loadModel('HarassmentDepartments');
    $survey->inqdept = $this->HarassmentDepartments->getByCode($survey->{'12inqdeptcode'});

		//$this->Flash->success('SURVEY: '.json_encode($survey));
		$this->set('survey', $survey);
		$this->set('waf', $this->Waf);
	}

	private function getOxfordUserAndValidate()
	{
	  // TODO: Remove the development OSS value
		if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) $_SERVER['HTTP_WAF_WEBAUTH'] = 'bioc0236';
		// 'sloblock' - non existant
		// 'alls0027' - inactive
		// 'bioc0236' - single dept
		// 'ashgjp'   - multiple depts

		if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) {
		  // TODO: Force Oxford SSO Login
		}

	  $this->loadModel('HarassmentUsers');
		$user = $this->HarassmentUsers->getByOxfordID();
    //$this->Flash->success('USER: '.json_encode($user));
		if (empty($user) || !empty($user->inactive)) {
		  $this->render('nouser');
		  return null;
		}
		$this->set('user', $user);
		return $user;
	}

	private function emailConfirmation($applicant)
	{
	  $message  = "<p>Dear ".$applicant->title." ".$applicant->forename." ".$applicant->surname.",</p>\n";
		// Send the email
		$email = new Email('default');
  	$email->from(['AcademicAdmin.Comms@admin.ox.ac.uk' => 'Academic Administration Division Communications']);
		//$email->to($person->email);
		// TODO: Remove test email
		$email->to(['al@cache.co.uk'=>'Al Pirrie', 'al.pirrie@it.ox.ac.uk'=>'Al Pirrie']);
		$email->subject('AAD Event Registration');
		$email->emailFormat('html');
		$email->send($message);
	}

}