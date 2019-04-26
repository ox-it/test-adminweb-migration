<?php
// src/Controller/SystemsAvailabilityController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class SystemsAvailabilityController extends AppController
{

	public static function defaultConnectionName() {
		return 'systems_availability';
	}

	public function index()
	{
		$this->loadModel('SystemsAvailabilityViews');
    $views = $this->SystemsAvailabilityViews->getAllAlphabetically();
    $this->set(compact('views'));
	}

	public function view($viewID = null)
	{
		$this->loadModel('SystemsAvailabilityViews');
    $view = $this->SystemsAvailabilityViews->get($viewID);
		$this->set(compact('view'));

		$this->loadModel('SystemsAvailabilitySystems');
		$systems = $this->SystemsAvailabilitySystems->getSystemsForViewID($viewID);
		$this->set(compact('systems'));
	}

}