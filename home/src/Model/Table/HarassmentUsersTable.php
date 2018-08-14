<?php
// src/Model/Table/HarassmentUsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class HarassmentUsersTable extends Table
{

	public static function defaultConnectionName() {
		return 'harassment-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');

		$this->setTable('user');
		$this->setPrimaryKey('userID');
		//$this->belongsTo('AADEventsColleges') ->setForeignKey('collcode') ->setBindingKey('collcode');
		//$this->belongsTo('AADEventsDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

	public function getByOxfordID()
	{
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all') ->where(['oxfordID'=>$oxfordID]); // -> contain(['AADEventsColleges','AADEventsDepartments']);
    $user = $query->first();
    //$user->department = (!empty($person->a_a_d_events_department)) ? $person->a_a_d_events_department->deptalpha : $person->depttext;
    //$user->college = (!empty($person->a_a_d_events_college)) ? $person->a_a_d_events_college->college : '';
    return $user;
	}

	public function validationRegister()
	{
		$validator = new Validator();
		$validator ->requirePresence('name') ->notBlank('name', 'Please complete this field');
		return $validator;
	}

	public function beforeSave($event, $entity, $options)
	{
		if ($entity->isNew()) {
			$entity->oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? $_SERVER['HTTP_WAF_WEBAUTH'] : 'notgiven';
		}
	}

}