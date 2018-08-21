<?php
// src/Controller/GraduateAccommodationController.php

namespace App\Controller;

use App\Form\GraduateAccommodationForm;

class GraduateAccommodationController extends AppController
{

	public function index()
	{
    $form = new GraduateAccommodationForm();
		if ($this->request->is('post')) {
		  $result = $form->execute($this->request->getData());
			if ($result) {
				$this->Flash->success('Thank you for your submission.');
				$this->Flash->success(print_r($result, true));
			} else {
				$this->Flash->error('There was a problem submitting your form.');
			}
		}
		$this->set('form', $form);
	}

	private function emailConfirmation($data)
	{
	  // Message
	  $message  = "<p>Please find attached is the XML file.</p>\n";
    if (!empty($data['comments'])) {
      $message .= "<p>Below are the extra comments provided by the user.</p>\n";
      $message .= '<p><em>'.str_replace("\n","<br>\n",$data['comments'])."</em></p>\n";
    }
    if (!empty($data['expecting']) ){
				$message .= '<p><strong>The applicant(s) is/are also expecting a child.</strong></p>';
		}

		// Email
		$email = new Email('default');
		$email->to($data['email_to']);
  	$email->from(['graduate.accommodation@admin.ox.ac.uk' => 'Graduate Accommodation']);
  	$email->subject($data['email_subject']);
		$email->emailFormat('html');
		$email->send($message);
	}

}