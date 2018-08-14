<?php
// src/Controller/GraduateAccomodationController.php

namespace App\Controller;

//use Cake\Datasource\ConnectionManager;
use App\Form\GraduateAccomodationForm;

class GraduateAccomodationController extends AppController
{

	public function index()
	{
    $form = new GraduateAccomodationForm();
    //$this->set('hierarchy', $form->getHierarchyArray());
    //$this->set('change_type_options', $form->getChangeTypeOptions());
    //$this->set('entity_type_options', $pras->getEntityTypeOptions());
    //$this->set('division_options', $pras->getDivisionsOptions());
    //$this->set('unit_options', $pras->getUnitsOptions());
    //$this->set('sub_unit_options', $pras->getSubUnitsOptions());
    //$this->set('cost_centre_options', $pras->getCostCentresOptions());
		if ($this->request->is('post')) {
			if ($form->execute($this->request->getData())) {
				$this->Flash->success('Thank you for your submission.');
			} else {
				$this->Flash->error('There was a problem submitting your form.');
			}
		}
		$this->set('form', $form);
	}

}