<?php
// src/Controller/StaffSearchController.php

namespace App\Controller;

use App\Form\StaffSearchForm;
use Cake\Filesystem\File;

class StaffSearchController extends AppController
{

  public function small()
  {
    $this->index(true);
  }

	public function index($is_small=false)
	{
		$this->loadComponent('StaffSearch');
	  $get_limit = $this->request->getQuery('limit');
	  $limit = empty($get_limit) || intval($get_limit)<1 ? $this->StaffSearch->param['limit'] : intval($get_limit);

    $form = new StaffSearchForm();
		if ($this->request->is('post')) {
		  $data = $form->execute($this->request->getData());
			if ($data) {
			  $data['limit'] = $limit;
				//$this->Flash->success('Searching!');
				$result = $this->StaffSearch->CurlProcess($data);
				$this->set('result', $result);
			} else {
				$this->Flash->error('There was a problem submitting your form. Please check for missing information.');
			}
		}
		$this->set('api', $this->StaffSearch);
	  $this->set('limit', $limit);
	  $this->set('small', $is_small);
		$this->set('form', $form);
		$this->render('index');
	}

	// For old-times sake
	public function jsonly()
  {
  	$get_small = $this->request->getQuery('small');
	  $small = empty($get_small) ? false : true;
  	$get_inline = $this->request->getQuery('inline');
	  $inline = empty($get_inline) ? false : true;

		$this->loadComponent('StaffSearch');
		$this->set('api', $this->StaffSearch);
	  $this->set('small', $small);
    $form = new StaffSearchForm();
		$this->set('form', $form);
		if ($inline) {
			$file = new File(WWW_ROOT . env('jsBaseUrl','js/') . $this->name . '/jsonly.js');
			$script = $file->read();
			$this->set('script', $script);
		}
  }

  public function jsonlyscript()
	{
	  $file = new File(WWW_ROOT . env('jsBaseUrl','js/') . $this->name . '/jsonly.js');
    $script = $file->read();
    $response = $this->response;
    $response->body($script);
    $response = $response->withType('js');
    return $response;
	}

}