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
		$this->set('organisations', $this->GcpApplicants->organisationsOptions());
		$applicant = $this->GcpApplicants->newEntity();
		if ($this->request->is(['post', 'put'])) {
			$applicant = $this->GcpApplicants->patchEntity($applicant, $this->request->getData(), ['validate'=>'register']);
			if ($this->GcpApplicants->save($applicant)) {
				$this->Flash->success(__('Saved.'));
				$this->set('applicant', $applicant);
				$this->render('success');
				return;
			}
			$this->Flash->error(__('Sorry. Your application contains errors.'));
		}
		$this->set('applicant', $applicant);
	}


	public function success($applicantID)
	{
		$this->loadModel('GcpApplicants');
		$this->set('applicant', $this->GcpApplicants->getByID($applicantID));
	}

}