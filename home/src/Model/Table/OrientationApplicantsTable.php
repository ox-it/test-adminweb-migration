<?php
// src/Model/Table/OrientationApplicantsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class OrientationApplicantsTable extends Table
{

	public static function defaultConnectionName() {
		return 'orientation-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('orientation_applicant');
		$this->setPrimaryKey('ID');
		$this->belongsTo('OrientationColleges') ->setForeignKey('collcode') ->setBindingKey('collcode');
		$this->belongsTo('OrientationCountries') ->setForeignKey('domcode') ->setBindingKey('domcode');
		$this->belongsTo('OrientationDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
		$this->belongsTo('OrientationNationalites') ->setForeignKey('natcode') ->setBindingKey('natcode');
	}

	public function getByID($applicantID = null) {
		$query = $this->find('all') ->where(['applicantID'=>$applicantID]) -> contain(['OrientationColleges','OrientationCountries','OrientationDepartments','OrientationNationalites']);
    $applicant = $query->first();
		return $applicant;
	}

	public function validationRegister($validator) {
		$validator->add('registration', 'regcode', [
			'rule' => function ($value, $context) {
				return $value == $context['data']['REG_CODE'];
			},
			'message' => 'The registration code is not valid'
		]);
		$validator ->notEmpty(['registration','firstname','surname','DOB','collcode','natcode','domcode','deptcode','course_type','degree','subject','email']);
		$validator ->email('email');
		foreach(['arrival_date','arrival_time','flight_num','flight_from'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['meet']) && $context['data']['meet']=='Y'); });
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
		$entity->orient_course = $entity->course_type;
		$entity->dept = !empty($entity->deptcode) ? $this->OrientationDepartments->getByCode($entity->deptcode) : null;
		$entity->department = !empty($entity->dept) ? $entity->dept->deptalpha : '';
		$entity->divcode = !empty($entity->dept) ? $entity->dept->divcode : '';
    if ($entity->course_type == 'P' && $entity->divcode == '3C') $entity->orient_course = 'S';
		$entity->college = !empty($entity->collcode) ? $this->OrientationColleges->getByCode($entity->collcode)->college : '';
	}

}