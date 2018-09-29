<?php
// src/Controller/PrasController.php

namespace App\Controller;

use App\Form\PrasForm;
use Cake\Utility\Xml;
use Cake\Utility\Exception\XmlException;

class PrasController extends AppController
{

	public function index()
	{
    $pras = new PrasForm();
		if ($this->request->is('post')) {
		  $post = $this->request->getData();
		  $data = $pras->execute($post);
		  //$this->Flash->success('POST: ' . print_r($post,true));
		  //$this->Flash->success('DATA: ' . print_r($data,true));
			$this->set('pras', $pras);
			$this->set('data', $data);

		  if ($post['stage']==1) {
		  	if ($data) {
					if ( !empty( $data['entity'] ) && $data['safeType'] ) {
						$this->set('changeType', $data['changeType']);
						$this->set('entity', $data['entity']);
						return $this->render($data['changeType']);
					}

				  if ( !empty($data['entityType']) && $data['safeType'] ) {
						$this->set('changeType', $data['changeType']);
						$this->set('entityType', $data['entityType']);
						return $this->render($data['changeType']);
				  }
				}
		  }

		  if ($post['stage']==2) {
				if ($data) {
					if ( (!empty($data['entity']) || !empty($data['entityType'])) && $data['safeType'] ) {
						$this->Flash->success('Thank you for your submission.');
						// To debug use this
  					//return $this->render($post['changeType']);
						return $this->render('success');
					} else {
						$this->Flash->error('Unknown error.');
						return $this->render('index');
					}
				} else {
    			$this->set('data', $post);
				  $this->Flash->error('Please check the form for errors.');
					return $this->render($post['changeType']);
				}
			}

      // No success in stage 1
			$this->Flash->error('Please select a change type.');
		}
		$this->set('pras', $pras);
	}

}