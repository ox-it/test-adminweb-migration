<?php
// src/Controller/PrasController.php

namespace App\Controller;

use App\Form\PrasForm;
use Cake\Filesystem\File;
use Cake\Mailer\Email;
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
  					$this->emailConfirmation($data);
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

	private function emailConfirmation($data)
	{
	  $file = new File(WWW_ROOT . env('cssBaseUrl','css/') . 'waf.css');
    $css = str_replace('.web-app-wrapper ','',$file->read());
    $type = !empty($data['changeType']) ? $data['changeType'] : 'UNKNOWN TYPE';
		$email = new Email();
		$email->template('new_pras_submission');
		$email->viewVars(['data' => $data, 'waf' => $this->Waf, 'css'=>$css ]);
  	$email->subject('Organisational Structure - ' . strtoupper($type));
  	$email->from(['orgstructure@admin.ox.ac.uk' => 'Planning & Resource Allocation']);
    $email->to(['orgstructure@admin.ox.ac.uk' => 'Planning & Resource Allocation']);

		// TODO: Remove test email
    $email->to([ "al.pirrie@it.ox.ac.uk" => 'Al Pirrie', 'al@cache.co.uk' => 'Al' ]);

		$email->emailFormat('html');
  	$email->send();
	}

  // Easy access to jQuery Menu Widget script file
	public function jquerymenu()
	{
	  $file = new File(WWW_ROOT . env('jsBaseUrl','js/') . $this->name . '/jquery-ui.widget.menu.min.js');
    $script = $file->read();
    $response = $this->response;
    $response->body($script);
    $response = $response->withType('js');
    return $response;
	}

  // Easy access to jQuery Menu Widget css file
	public function jquerymenucss()
	{
	  $file = new File(WWW_ROOT . env('jsBaseUrl','css/') . $this->name . '/jquery-ui.widget.menu.structure.css');
    $css = $file->read();
    $response = $this->response;
    $response->body($css);
    $response = $response->withType('css');
    return $response;
	}

}