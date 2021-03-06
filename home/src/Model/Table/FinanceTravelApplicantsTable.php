<?php
// src/Model/Table/FinanceTravelApplicantsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class FinanceTravelApplicantsTable extends Table
{

  private $airclassOptions = [ 'E'=>'Economy', 'B'=>'Business' ];
  private $trainclassOptions = [ '2'=>'Standard', '1'=>'1st Class' ];
  private $yesnoOptions = [ 'Y'=>'Yes', 'N'=>'No' ];


	public static function defaultConnectionName() {
		return 'finance_travel';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'applicant';
    $this->addBehavior('Waf');  				// src/Model/Behavior/WafBehavior.php
		$this->addBehavior('Timestamp');
		$this->setTable($table);
		$this->setPrimaryKey('applicantID');
		$this->belongsTo('FinanceTravelDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

	public function getByID($applicantID = null) {
		$query = $this->find('all') ->where(['applicantID'=>$applicantID]) -> contain(['FinanceTravelDepartments']);
    $applicant = $query->first();
		$applicant->name = (!empty($applicant->title)?$applicant->title.' ':'') . (!empty($applicant->forename)?$applicant->forename.' ':'') . (!empty($applicant->surname)?$applicant->surname:'');
    $applicant->department = (!empty($applicant->finance_travel_department)) ? $applicant->finance_travel_department->deptalpha : '';
    $applicant->airdeparting = $applicant->airdateout . ( empty($applicant->airtimeout) ? '' : ', ' . $applicant->airtimeout );
    $applicant->airreturning = $applicant->airdateback . ( empty($applicant->airtimeback) ? '' : ', ' . $applicant->airtimeback );
    $applicant->airdirectverbose = !empty($applicant->airdirect) ?    $this->yesnoOptions[$applicant->airdirect] : '';
    $applicant->airreturnverbose = !empty($applicant->airreturn) ?    $this->yesnoOptions[$applicant->airreturn] : '';
    $applicant->airclassverbose =  !empty($applicant->airclass)  ? $this->airclassOptions[$applicant->airclass]  : '';
    $applicant->traindeparting = $applicant->traindateout . ( empty($applicant->traintimeout) ? '' : ', ' . $applicant->traintimeout );
    $applicant->trainreturning = $applicant->traindateback . ( empty($applicant->traintimeback) ? '' : ', ' . $applicant->traintimeback );
    $applicant->trainclassverbose = (!empty($applicant->trainclass) && !empty($this->trainclassOptions[$applicant->trainclass])) ? $this->trainclassOptions[$applicant->trainclass] : '';
		return $applicant;
	}

	public function validationRegister($validator) {
		$validator ->allowEmpty('reqphone') ->add('reqphone', 'validValue', [ 'rule' => ['lengthBetween', 11, 16], 'message' => 'Please enter a valid phone number, including area code' ]);
		$validator ->allowEmpty('reqemail') ->add('reqemail', 'validValue', [ 'rule' => 'email', 'message' => 'Please enter a valid email address' ]);
		$validator ->notEmpty(['surname','forename','title','email','deptcode']);
		$validator ->allowEmpty('phone') ->add('phone', 'validValue', [ 'rule' => ['lengthBetween', 11, 16], 'message' => 'Please enter a valid phone number, including area code' ]);
		$validator ->add('email', 'validValue', [ 'rule' => 'email', 'message' => 'Please enter a valid email address' ]);
		foreach(['airdateout','airdateback','traindateout','traindateback','cardatestart','cardateend','hoteldatestart','hoteldateend'] as $target) {
		  $validator ->allowEmpty($target);
			$validator ->add($target, 'validateDateFormat', [ 'rule'=>[$this,'validateDateFormat'], 'message' => 'Please enter a valid date' ]);
    }
		foreach(['airportout','airportback','airdateout'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['air']) && $context['data']['air']=='Y'); });
		}
		$validator->notEmpty('airdateback', null, function ($context) { return ( !empty($context['data']['air']) && $context['data']['air']=='Y' && !empty($context['data']['airreturn']) && $context['data']['airreturn']=='Y' ); });
		foreach(['stationout','stationback','traindateout'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['train']) && $context['data']['train']=='Y'); });
		}
		foreach(['carpickup','cardatestart','cardropoff','cardateend'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['car']) && $context['data']['car']=='Y'); });
		}
		foreach(['hotellocation','hoteldatestart','hoteldateend'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['hotel']) && $context['data']['hotel']=='Y'); });
		}
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