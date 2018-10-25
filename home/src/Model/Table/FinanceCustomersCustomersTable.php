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
		$this->setTable('finance_customer_customer');
		$this->setPrimaryKey('customerID');
		$this->belongsTo('FinanceCustomersCountries') ->setForeignKey(['billdomcode','shipdomcode']) ->setBindingKey('domcode');
		$this->belongsTo('FinanceCustomersDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
		$this->addBehavior('Josegonzalez/Upload.Upload', [
			'POfile' => []
		]);
	}

	public function getByID($customerID = null)
	{
		$customer = $this->get($customerID);
		return $customer;
	}

	public function beforeMarshal($event, $data, $options)
	{
	  // Save the result of the dept inputs in a convenient display parameter ->department
	  if (!empty($data['deptcode'])) {
   	  $departments = $this->FinanceCustomersDepartments->getSelectOptions();
	    if ($data['deptcode']==='00' && !empty($data['depttext'])) $data['department'] = $data['depttext'] . ' (custom)';
	    else {
	      if (isset($departments[$data['deptcode']])) $data['department'] = $departments[$data['deptcode']];
	      else $data['department'] = $data['deptcode'];
	    }
	  } else {
	    $data['department'] = '';
	  }

	  if (!empty($data['billdomcode'])) {
	    $countries = $this->FinanceCustomersCountries->getSelectOptions()->toArray();
			if (isset($countries[$data['billdomcode']])) $data['billcountry'] = $countries[$data['billdomcode']] . ' (' . $data['billdomcode'] . ')';
			else $data['billcountry'] = $data['billdomcode'];

			$data['EUVAT'] = $this->FinanceCustomersCountries->getEUVATByCode($data['billdomcode']);
	  }

	  if (empty($data['shipaddress1'])) $data['shipaddress1'] = '';

	  //print 'beforeMarshal' . print_r($data,true);

	}

	public function validationRegister()
	{
		$validator = new Validator();

	  $require = ['forename','surname','email','phone','custname','category','accounttype','custtype','payterms','sendcon','transaction','POupload','billaddress1','billtown','billpostcode','billdomcode','VATflag','billcontact','billemail','billphone','billcopy'];
		//foreach($require as $r) $validator ->notEmpty($r);

	  $conditionals = [ ['custtitle', 'category', 'P'], ['accountnum', 'accounttype', ['A','E']], ['custVAT','VATflag','Y'], ['countrycode','VATflag','Y'], ['invoiceemail','PDFinvoice','Y'], ['shipaddress1','billcopy','N'], ['shiptown','billcopy','N'], ['shippostcode','billcopy','N'], ['shipdomcode','billcopy','N'] ];
		foreach($conditionals as $i=>$c) {
			if (!is_array($c[2])) $c[2] = [$c[2]];
		  //print 'CREATE: ' . $c[0] . ': ' . $c[1] . ' in ' . print_r($c[2],true) . '<br>';
		  $validator->allowEmpty($c[0]);
			$validator ->notEmpty($c[0], null, function ($context) use ($c) {
			    $value = !empty($context['data'][$c[1]]) ? $context['data'][$c[1]] : '';
					$result = (!empty($value) && in_array($value, $c[2]));
					//print 'CHECK: ' . $c[0] . ': ' . $c[1] . ' = ' . $value . ' in [' . implode(', ',$c[2]) . '] ' . ($result?'YES':'NO') . '<br>';
          return $result;
      });
    }

		$validator ->add('email', 'validFormat', [ 'rule'=>'email', 'message' => 'Please enter a valid email' ]);
		$validator ->add('creditcheck', 'mustCheck', [ 'rule'=>['comparison', '!=', 0], 'message'=>'Please agree to the credit check statement', 'allowEmpty' => false, 'required' => true, 'last' => true ]);

		return $validator;
	}

	public static function uploadPOfile($customer, $maxfiles=1)
	{

	  $file = $customer->POtemp;

	  // Quick checks
	  if (empty($file) || !is_array($file) || $file['size'] == 0 || $file['error'] !== 0) return false;

    // Set target location
    $now = new Time();
    $POfilename = strtolower('pofile_' . $now->format('ymdhisu') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION));
		$POfilepath = self::getPOFilepathForFilename($POfilename);

    // Move file
		if ( move_uploaded_file($file['tmp_name'], $POfilepath) ) {
		  if (!empty($customer->POfiles) && is_array($customer->POfiles)) $customer->POfiles[] = $POfilename;
		  else $customer->POfiles = [$POfilename];
		  // Prevent limitless uploads
		  while (count($customer->POfiles)>$maxfiles) {
		    $unwanted_file = array_shift($customer->POfiles);
		    // TODO: Delete $unwanted_file
		  }
		  $customer->POfile = $customer->POfiles[0];
		  $customer->POfilepath = $POfilepath;
		  return $POfilename;
		}

    // Or fail
    return false;
	}

	public static function getPOFilepathForFilename($filename)
	{
	  return TMP . $filename;
	}

	public function beforeSave($event, $entity, $options)
	{
		if ($entity->isNew()) {
			$entity->webdate = date('d/m/Y');
			$entity->webdatesort = date('Y/m/d');
			$entity->webtime = date('H:i');
			if (!empty($entity->POfiles) && count($entity->POfiles)>0) $entity->POfile = $entity->POfiles[0];
		}
	}

}