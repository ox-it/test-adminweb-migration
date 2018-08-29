<?php
// src/Model/Table/HarassmentUsersDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class HarassmentUsersDepartmentsTable extends Table
{

	public static function defaultConnectionName() {
		return 'harassment-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('harassment_user_dept');
		$this->setPrimaryKey('user_deptID');
		$this->belongsTo('HarassmentDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

}