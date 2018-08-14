<?php
// src/Model/Table/FinanceCustomersCustomersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class FinanceCustomersCustomersTable extends Table
{

	public static function defaultConnectionName() {
		return 'finance_customers-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('customer');
		$this->setPrimaryKey('customerID');
		$this->belongsTo('FinanceCustomersCountries') ->setForeignKey(['billdomcode','shipdomcode']) ->setBindingKey('domcode');
		$this->belongsTo('FinanceCustomersDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

	public function getByID($customerID = null)
	{
		$customer = $this->get($customerID);
		return $customer;
	}

	public function validationRegister()
	{
	  $require = ['forename','surname','custname','category','accounttype','custtype','payterms','sendcon','transaction','POupload','billaddress1','billtown','billpostcode','billdomcode','VATflag','billcontact','billemail','billphone','billcopy'];
	  $conditional = [ ['custtitle', 'category', 'P'], ['accountnum', 'accounttype', ['A','E']], ['POfile','POupload','Y'], ['invoiceemail','VATflag','Y'], ['shipaddress1','billcopy','N'], ['shiptown','billcopy','N'], ['shippostcode','billcopy','N'], ['shipdomcode','billcopy','N'] ];
		$validator = new Validator();
		foreach($require as $r) $validator ->requirePresence($r) ->notBlank($r, 'Please complete this field');
		foreach($conditional as $c) {
		  $validator->add($c[0], 'not-blank', [
				'rule' => 'not-blank',
				'message' => 'Please enter a value',
				'on' => function ($context) {
					if (!is_array($c[2])) $c[2] = [$c[2]];
					return !empty($context['data'][$c[1]]) && in_array($context['data'][$c[1]], $c[2]);
				}
			]);
    }
		$validator ->requirePresence('phone') ->add('phone', 'validValue', [ 'rule' => ['range', 1, 5], 'message' => 'Please enter a valid phone number' ]);
		$validator ->requirePresence('email') ->add('email', 'validFormat', [ 'rule' => 'email', 'message' => 'Please enter a valid email' ]);
		return $validator;
	}

	public function beforeSave($event, $entity, $options)
	{
		if ($entity->isNew()) {
			$entity->webdate = date('d/m/Y');
			$entity->webdatesort = date('Y/m/d');
			$entity->webtime = date('H:i');
		}
	}

}