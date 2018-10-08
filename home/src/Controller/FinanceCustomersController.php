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
		$customer = $this->FinanceCustomersCustomers->newEntity(['billcopy'=>'Y']);

		if ($this->request->is(['post', 'put'])) {
			$customer = $this->FinanceCustomersCustomers->patchEntity($customer, $this->request->getData(), ['validate'=>'register']);
			$this->FinanceCustomersCustomers->uploadPOfile($customer);
			//$this->Flash->success(print_r($customer,true));
			if (empty($customer->another)) {
			  if ($this->FinanceCustomersCustomers->save($customer)) {
			    $this->emailConfirmation($customer);
					$this->Flash->success(__('Saved.'));
					$this->set('customer', $customer);
					$this->render('success');
					return;
				}
				$this->Flash->error(__('Please check you have completed all the fields.'));
			}
		}
		$this->set('customer', $customer);

	}

	private function emailConfirmation($customer)
	{
		$email = new Email();
  	$email
  	  ->template('new_finance_customer')
  	  ->viewVars(['customer' => $customer, 'waf' => $this->Waf ])
			->subject('New Customer Account')
      ->from(['ar.cust.setup@admin.ox.ac.uk' => 'Accounts Receivable (AR) Team'])
      // TODO: Remove test email
      ->to('al@cache.co.uk')
			//->to($customer->email)
      ->emailFormat('html')
      ->attachments($customer->POfilepath)
			->send();
	}

}