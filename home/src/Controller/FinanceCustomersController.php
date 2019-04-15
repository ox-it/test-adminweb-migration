<?php
// src/Controller/FinanceCustomersController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;

class FinanceCustomersController extends AppController
{

	public static function defaultConnectionName() {
			return 'finance_customer';
	}

	public function index()
	{
		$this->loadModel('FinanceCustomersCountries');
		$countries = $this->FinanceCustomersCountries->getSelectOptions();
		$this->set('countries', $countries);

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
			    $this->emailConfirmation($customer, $countries);
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

	private function emailConfirmation($customer, $countries)
	{
	  $file = new File(WWW_ROOT . env('cssBaseUrl','css/') . 'waf.css');
    $css = str_replace('.web-app-wrapper ','',$file->read());
		$email = new Email();
		$email->template('new_finance_customer');
		$email->viewVars(['customer' => $customer, 'countries'=>$countries, 'waf' => $this->Waf, 'css'=>$css ]);
		$email->subject('New Customer Account');
		$email->to(['ar.cust.setup@admin.ox.ac.uk' => 'Accounts Receivable (AR) Team']);

		// TODO: Remove test email
    $email->to([ "al.pirrie@it.ox.ac.uk" => 'Al Pirrie', 'al@cache.co.uk' => 'Al' ]);

		$email->from($customer->email);
		$email->emailFormat('html');
		$email->attachments($customer->POfilepath);
  	$email->send();
	}

}