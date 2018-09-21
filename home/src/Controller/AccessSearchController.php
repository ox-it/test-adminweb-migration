<?php
// src/Controller/AccessSearchController.php

namespace App\Controller;

use App\Form\AccessSearchForm;

class AccessSearchController extends AppController
{

	public function index()
	{
    $form = new AccessSearchForm();
		if ($this->request->is('post')) {
		  $data = $form->execute($this->request->getData());
			if ($data) {
				$this->Flash->success('Searching!');
				$this->loadComponent('AccessSearch');
				$result = $this->AccessSearch->CurlProcess($data);
    	  if (!empty($result) && !empty($result['_embedded']) && !empty($result['_embedded']['pois'])) {
    	    $buildings = $result['_embedded']['pois'];
					$this->set( 'AccessSearch', $this->AccessSearch );
					$this->set( 'buildings', $buildings );
					$this->set( 'total', count($buildings) );
					$this->set( 's', (count($buildings)==1 ? '' : 's') );
					return $this->render('found');
    	  } else {
					$this->set('data', $data);
					$this->set('result', $result);
					return $this->render('noresult');
				}
			} else {
				$this->Flash->error('There was a problem submitting your form. Please check for missing information.');
			}
		}
		$this->set('form', $form);
	}

}