<?php
// src/Controller/GcpController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class GcpController extends AppController
{

	public static function defaultConnectionName() {
			return 'gcp-test';
	}

	public function index()
	{
		$this->loadModel('GcpApplicants');
		$applicant = $this->GcpApplicants->newEntity();
		if ($this->request->is(['post', 'put'])) {
			$applicant = $this->GcpApplicants->patchEntity($applicant, $this->request->getData(), ['validate'=>'register']);
			if ($this->GcpApplicants->save($applicant)) {
				$this->Flash->success(__('Saved.'));
				return $this->redirect(['action' => 'success', $applicant->applicantID]);
			}
			$this->Flash->error(__('Sorry. Your application contains errors.'));
		}
		$this->set('applicant', $applicant);
		$this->set('waf', $this->Waf);
		$this->set('organisations', $this->GcpApplicants->organisationsOptions());
	}


	public function success($applicantID)
	{
		$this->loadModel('GcpApplicants');
		$this->set('applicant', $this->GcpApplicants->getByID($applicantID));
		$this->set('waf', $this->Waf);
	}

}