<?php
// src/Controller/JobsController.php

namespace App\Controller;

use App\Form\JobsForm;

class JobsController extends AppController
{

	public function index()
	{
    // Respond to GET parameters
    $page = $this->request->getQuery('page');
    if (empty($page)) $page=0;
    $this->set('page', empty($page) ? 0 : $page);

    $jobs = new JobsForm();
    $this->set('file', $jobs->getJobsFeedContents());
    $this->set('feed', $jobs->getJobsFeedArray($page));
		$this->set('jobs', $jobs);
		$this->render('info');
	}

}