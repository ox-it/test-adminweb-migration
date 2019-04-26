<?php
// src/Controller/HarassmentController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;


class HarassmentController extends AppController
{

	public static function defaultConnectionName() {
			return 'harassment';
	}

	public function index()
	{
		// Respond to GET parameters
  	$action = $this->request->getData('action');
		$userID = $this->request->getData('personID');
		$deptcode = $this->request->getData('deptcode');
		$acyear = $this->request->getData('acyear');
  	if (!empty($action) && in_array($action,['report','noreport'])) {
  	  return $this->$action($userID,$deptcode,$acyear);
    }

  	// Otherwise continue
		$user = $this->getOxfordUserAndValidate();
		if ($this->request->is(['post','put'])) {
			$user = $this->HarassmentUsers->patchEntity($user, $this->request->getData());
			$this->Flash->success('USER: ' . print_r($user,true));
      if (!empty($user->action)) {
        //return $this->redirect([ '?' => [ 'a'=>($user->action == 'report'?'report':'noreport'), 'u'=>$user->userID, 'd'=>$user->deptcode, 'y'=>$user->acyear ] ]);
        $action = $user->action;
       	if (!empty($action) && in_array($action,['report','noreport'])) {
					return $this->$action($user->userID, $user->deptcode, $user->acyear);
				}
        /*
        if ($user->action == 'report') {
          return $this->redirect([ 'action' => 'report', $user->userID, $user->deptcode, $user->acyear ]);
        } else {
          return $this->redirect([ 'action' => 'noreport', $user->userID, $user->deptcode, $user->acyear ]);
        }
        //*/
      }
		}
	}

	public function report($userID, $deptcode, $acyear)
	{
	  $submitted = $this->request->getData('submitted');
		//$this->Flash->success('REPORT :: USER:' . $userID . ' DEPTCODE:'.$deptcode . ' ACYEAR:'.$acyear  . ' SUMITTED:'.$submitted );

		$user = $this->getOxfordUserAndValidate();
		$this->loadModel('HarassmentSurveys');
		$survey = $this->HarassmentSurveys->newEntity(['personID'=>$userID, 'deptcode'=>$deptcode, 'year'=>$acyear]);

		$this->loadModel('HarassmentDepartments');
		$departments = $this->HarassmentDepartments->getSelectOptions();
		$this->set('departments', $departments);

		if ($this->request->is(['post', 'put']) && $submitted) {
			$survey = $this->HarassmentSurveys->patchEntity($survey, $this->request->getData(), ['validate'=>'report']);
			if ($this->HarassmentSurveys->save($survey)) {
				$this->Flash->success(__('Saved.'));
				//$this->Flash->success('SURVEY: ' . print_r($survey,true));
				//$this->Flash->success('USER: ' . print_r($user,true));
				//return $this->redirect(['action' => 'success', $survey->surveyID]);
    		$this->set('user', $user);
    		$this->set('survey', $survey);
				return $this->render('success');
			} else {
			  $this->Flash->error(__('Sorry. Your survey contains errors. Please check all the fields for errors/omissions.'));
			}
		}
		$this->set('survey', $survey);
		$this->render('report');
	}

	public function noreport($userID, $deptcode, $acyear)
	{
		//$this->Flash->success('NOREPORT :: USER:' . $userID . ' DEPTCODE:'.$deptcode . ' ACYEAR:'.$acyear );
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
		$this->render('noreport');
	}

  /*
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
	//*/

	private function getOxfordUserAndValidate()
	{
	  // Removed the development OSS value
		//if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) $_SERVER['HTTP_WAF_WEBAUTH'] = 'bioc0236';
		// 'sloblock' - non existant
		// 'alls0027' - inactive
		// 'bioc0236' - single dept
		// 'ashgjp'   - multiple depts
    //$this->Flash->success('USER: '.getenv('HTTP_WAF_WEBAUTH'));

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