<?php
// src/Controller/JobsController.php

namespace App\Controller;

use App\Form\JobsForm;

class JobsController extends AppController
{

	public function index()
	{
    $jobs = new JobsForm();
    $this->set('file', $jobs->getJobsFeedContents());
    $this->set('feed', $jobs->getJobsFeedArray());
		if ($this->request->is('post')) {
			if ($jobs->execute($this->request->getData())) {
				$this->Flash->success('Thank you for your submission.');
			} else {
				$this->Flash->error('There was a problem submitting your form.');
			}
		}
		$this->set('jobs', $jobs);
	}

	public function view($jobID = null)
	{

	}

}