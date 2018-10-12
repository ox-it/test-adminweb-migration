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
		$agents = $this->FinanceTravelAgents->getAllAlphabetically();
		$this->set('agents', $agents);

		$this->loadModel('FinanceTravelApplicants');
		$applicant = $this->FinanceTravelApplicants->newEntity();

		if ($this->request->is(['post', 'put'])) {
			$applicant = $this->FinanceTravelApplicants->patchEntity($applicant, $this->request->getData(), ['validate'=>'register']);
			if ($this->FinanceTravelApplicants->save($applicant)) {
				$this->emailConfirmation($applicant, $agents);
				$this->Flash->success(__('Saved.'));
				$this->set('applicant', $applicant);
				$this->render('confirm');
				return;
			}
			$this->Flash->error(__('Sorry. Your request contains errors.'));
		}
		$this->set('applicant', $applicant);
	}

	private function emailConfirmation($applicant, $agents)
	{
	  $to = [];
	  foreach($agents as $a) $to[] = $a->agentemail;
	  $file = new File(WWW_ROOT . env('cssBaseUrl','css/') . 'waf.css');
    $css = str_replace('.web-app-wrapper ','',$file->read());
		$email = new Email();
  	$email
  	  ->template('new_finance_travel_applicant')
  	  ->viewVars(['applicant' => $applicant, 'agents' => $agents, 'waf' => $this->Waf, 'css'=>$css ])
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