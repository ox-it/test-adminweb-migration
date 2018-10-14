<?php
// src/Controller/OrientationController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;

class OrientationController extends AppController
{

  // These values can be adjusted
  private static $REG_CODE = "OP2018";
  private static $meet_and_greet = false;



	public static function defaultConnectionName() {
			return 'orientation-test';
	}

	public function index()
	{

		$this->set('meet_and_greet', self::$meet_and_greet);

		$this->loadModel('OrientationColleges');
		$this->set('colleges', $this->OrientationColleges->getSelectOptions());

		$this->loadModel('OrientationCountries');
		$this->set('countries', $this->OrientationCountries->getSelectOptions());

		$this->loadModel('OrientationDepartments');
		$this->set('departments', $this->OrientationDepartments->getSelectOptions());

		$this->loadModel('OrientationNationalities');
		$this->set('nationalities', $this->OrientationNationalities->getSelectOptions());

		$this->loadModel('OrientationApplicants');
		$applicant = $this->OrientationApplicants->newEntity();

		if ($this->request->is(['post', 'put'])) {
		  $this->request->data['REG_CODE'] = self::$REG_CODE;
			$applicant = $this->OrientationApplicants->patchEntity($applicant, $this->request->getData(), ['validate'=>'register']);
			if ($this->OrientationApplicants->save($applicant)) {
				//$this->emailConfirmation($applicant);
				$this->Flash->success(__('Saved.'));
				$this->set('applicant', $applicant);
				$this->render('confirm');
				return;
			}
			$this->Flash->error(__('Sorry. Your request contains errors.'));
		}
		$this->set('applicant', $applicant);
	}

	private function emailConfirmation($applicant)
	{
	  $file = new File(WWW_ROOT . env('cssBaseUrl','css/') . 'waf.css');
    $css = str_replace('.web-app-wrapper ','',$file->read());
		$email = new Email();
  	$email
  	  ->template('new_orientation_applicant')
  	  ->viewVars(['applicant' => $applicant, 'waf' => $this->Waf, 'css'=>$css ])
			->subject('Oxford University Travel Request')
      ->from(['purchasing@admin.ox.ac.uk' => 'University of Oxford Purchasing Team'])
      // TODO: Remove test email
      ->to('al@cache.co.uk')
			//->to($to)
			->replyTo(!empty($applicant->reqemail) ? $applicant->reqemail : $applicant->email)
      ->emailFormat('html')
			->send();
	}

}