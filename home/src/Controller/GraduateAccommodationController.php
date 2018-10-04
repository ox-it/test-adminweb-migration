<?php
// src/Controller/GraduateAccommodationController.php

namespace App\Controller;

use App\Form\GraduateAccommodationForm;

class GraduateAccommodationController extends AppController
{

	public function index()
	{
    $form = new GraduateAccommodationForm();
    //$example = $form->getExampleXML(); $this->Flash->success(print_r($example, true));

		if ($this->request->is('post')) {
		  $result = $form->execute($this->request->getData());

			if ($result) {
				$this->Flash->success('Thank you for your submission.');
				return $this->render('success');
			} else {
				$this->Flash->error('There was a problem submitting your form. Please check for missing information.');
			}

		}
		$this->set('form', $form);
	}

}