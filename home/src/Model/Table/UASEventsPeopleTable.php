<?php
// src/Model/Table/UASEventsPeopleTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class UASEventsPeopleTable extends Table
{

	public static function defaultConnectionName() {
		return 'uas_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('uas_events_person');
		$this->setPrimaryKey('personID');
		$this->belongsTo('UASEventsColleges') ->setForeignKey('collcode') ->setBindingKey('collcode');
		$this->belongsTo('UASEventsDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

	public function getByOxfordID()
	{
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all') ->where(['oxfordID'=>$oxfordID]) ->order(['timestamp'=>'DESC']) -> contain(['UASEventsColleges','UASEventsDepartments']);
    $person = $query->first();
    if ($person) {
			$person->department = (!empty($person->u_a_s_events_department)) ? $person->u_a_s_events_department->deptalpha : (!empty($person->depttext) ? $person->depttext : '');
			$person->college = (!empty($person->u_a_s_events_college)) ? $person->u_a_s_events_college->college : '';
    }
    return $person;
	}

	public function validationRegister()
	{
		$validator = new Validator();
		$validator ->notEmpty(['surname','forename','title','jobtitle','phone','email','email2','deptcode','collcode']);
		$validator ->lengthBetween('phone', [5, 16], 'Please enter a valid phone number');
		$validator ->add('email', 'validFormat', [ 'rule'=>'email', 'message' => 'Please enter a valid email' ]);
		$validator ->equalToField('email2','email','The emails do not match');
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