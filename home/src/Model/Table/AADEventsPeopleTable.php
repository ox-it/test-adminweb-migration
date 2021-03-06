<?php
// src/Model/Table/AADEventsPeopleTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class AADEventsPeopleTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('aad_events_person');
		$this->setPrimaryKey('personID');
		$this->belongsTo('AADEventsColleges') ->setForeignKey('collcode') ->setBindingKey('collcode');
		$this->belongsTo('AADEventsDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

	public function getByOxfordID()
	{
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all') ->where(['oxfordID'=>$oxfordID]) ->order(['timestamp'=>'DESC']) -> contain(['AADEventsColleges','AADEventsDepartments']);
    $person = $query->first();
    if (!empty($person)) {
      $person->department = (!empty($person->a_a_d_events_department)) ? $person->a_a_d_events_department->deptalpha : (!empty($person->depttext) ? $person->depttext : '');
      $person->college = (!empty($person->a_a_d_events_college)) ? $person->a_a_d_events_college->college : '';
    }
    return $person;
	}

	public function getByID($bookingID = null)
	{
		$booking = $this->get($bookingID);
		return $booking;
	}

	public function validationRegister()
	{
		$validator = new Validator();
		$validator ->notEmpty(['surname','forename','title','jobtitle','phone','email','email2','deptcode']);
		$validator ->lengthBetween('phone', [5, 16], 'Please enter a valid phone number');
		$validator ->add('email', 'validFormat', [ 'rule'=>'email', 'message' => 'Please enter a valid email' ]);
		$validator ->equalToField('email2','email','The emails do not match');
		$validator->notEmpty('depttext', null, function ($context) { return (!empty($context['data']['deptcode']) && $context['data']['deptcode']=='00'); });
		return $validator;
	}

	public function beforeSave($event, $entity, $options)
	{
		if ($entity->isNew()) {
			$entity->oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? $_SERVER['HTTP_WAF_WEBAUTH'] : 'notgiven';
			$entity->webdate = date('d/m/Y');
			$entity->webdatesort = date('Y/m/d');
			$entity->webtime = date('H:i');
		}
    // For all changes
		$entity->timestamp = time();
		$entity->lastupdate = date('d/m/Y');
	}

}