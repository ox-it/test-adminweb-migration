<?php
// src/Controller/FinanceCustomersController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;

class FinanceCustomersController extends AppController
{

	public static function defaultConnectionName() {
			return 'finance_customer-test';
	}

	public function index()
	{
		$this->loadModel('FinanceCustomersCountries');
		$this->set('countries', $this->FinanceCustomersCountries->getSelectOptions());

		$this->loadModel('FinanceCustomersDepartments');
		$this->set('departments', $this->FinanceCustomersDepartments->getSelectOptions());

		$this->loadModel('FinanceCustomersCustomers');
		$customer = $this->FinanceCustomersCustomers->newEntity();

		if ($this->request->is(['post', 'put'])) {
			$customer = $this->FinanceCustomersCustomers->patchEntity($customer, $this->request->getData());
			if ($this->FinanceCustomersCustomers->save($customer)) {
				$this->Flash->success(__('Saved.'));
				return $this->redirect(['action' => 'success', $customer->customerID]);
			}
			$this->Flash->error(__('Unable to process your application at this time.'));
		}
		$this->set('customer', $customer);

	}

	public function success($personID)
	{

	}

  // Allows the script file to be called individually
	public function script()
	{
	  $file = new File(WWW_ROOT . env('jsBaseUrl','js/') . 'FinanceCustomers/script.js');
    $script = $file->read();
    $response = $this->response;
    $response->body($script);
    $response = $response->withType('js');
    return $response;
	}

	private function emailConfirmation($customer)
	{
	  $message  = "<p>Dear ".$person->title." ".$person->forename." ".$person->surname.",</p>\n";
    $message .= "<p>Your event registration has been recorded. You are now confirmed to attend the following AAD events:</p>\n";

    $message .= '<ul><li>' . implode("</li><li>\n", $booked) . "</li></ul>\n";

		$message .= "<p>To cancel a booking, please call the AAD Communications team on 284847 or email us at ";
		$message .= '<a href="mailto:AcademicAdmin.Comms@admin.ox.ac.uk">AcademicAdmin.Comms@admin.ox.ac.uk</a>.</p>' . "\n";
		$message .= "<p>You may log back in to the AAD events registration form via the AAD Staff Events page ";
		$message .= '(<a href="http://www.admin.ox.ac.uk/aad/communications/events/">http://www.admin.ox.ac.uk/aad/communications/events/</a>)' . "\n";
		$message .= "to register for new events as they become available.</p>\n";

		$message .= "<p>Kind Regards,</p>\n";
		$message .= "<p><strong>Academic Administration Division Communications</strong>,<br>\n";
		$message .= "University of Oxford,<br>\n";
		$message .= "Examination Schools,<br>\n";
		$message .= "75-81 High Street,<br>\n";
		$message .= "Oxford<br>\n";
		$message .= "OX1 4BG</p>\n";
		$message .= "<p>Tel: 01865 (2)84847<br>\n";
		$message .= 'Email: <a href="mailto:AcademicAdmin.Comms@admin.ox.ac.uk">AcademicAdmin.Comms@admin.ox.ac.uk</a><br>' . "\n";
		$message .= 'Web: <a href="http://www.admin.ox.ac.uk/aad">www.admin.ox.ac.uk/aad</a></p>' . "\n";

		// Send the email
		$email = new Email('default');
  	$email->from(['AcademicAdmin.Comms@admin.ox.ac.uk' => 'Academic Administration Division Communications'])
			->to($person->email)
			->subject('AAD Event Registration')
			->emailFormat('html')
			->send($message);
	}

}