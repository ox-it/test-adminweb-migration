<?php
// src/Controller/GraduateAccommodationController.php

namespace App\Controller;

use App\Form\GraduateAccommodationForm;
use Cake\Filesystem\File;
use Cake\Mailer\Email;

class GraduateAccommodationController extends AppController
{

	public function index()
	{
		$form = new GraduateAccommodationForm();

		if ($this->request->is('post')) {
		  $result = $form->execute($this->request->getData());

			if ($result) {
				$this->Flash->success('Thank you for your submission.');
				$this->emailConfirmation($result);
				return $this->render('success');
			} else {
				$this->Flash->error('There was a problem submitting your form. Please check for missing information.');
			}

		}
		$this->set('form', $form);
	}

	private function emailConfirmation($data)
	{
		$file = new File(WWW_ROOT . env('cssBaseUrl','css/') . 'waf.css');
		$css = str_replace('.web-app-wrapper ','',$file->read());
		$email = new Email();
		$email->template('new_graduate_accomodation_applicant');
		$email->viewVars(['data' => $data, 'waf' => $this->Waf, 'css'=>$css ]);
		$email->subject($data['email_subject']);
		$email->from([$data['preferred_email'] => 'Accommodation Applicant']);
		$email->to($data['email_to']);

		// Test emails
		if (!empty($_SERVER['SERVER_NAME'])) {
			if ($_SERVER['SERVER_NAME']=='waf-td.nsms.ox.ac.uk') {
				$email->to([ "samuel.press@it.ox.ac.uk"]);
			}
		}

		$email->emailFormat('html');
		$email->attachments($data['xmlfile']);
		$email->send();
	}

}
