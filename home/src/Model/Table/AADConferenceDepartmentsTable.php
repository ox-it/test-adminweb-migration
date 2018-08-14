<?php
// src/Model/Table/AADConferenceDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class AADConferenceDepartmentsTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_conference-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('department');
		$this->setPrimaryKey('deptcode');
		$this->setDisplayField('deptalpha');
	}

	public function getByCode($deptcode = null) {
		$department = $this->get($deptcode);
		return $department;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'deptalpha' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		$departments = $query->toList();
		$departments[''] = '';
		$departments['00'] = '-- Not Listed --';
		return $departments;
	}

}