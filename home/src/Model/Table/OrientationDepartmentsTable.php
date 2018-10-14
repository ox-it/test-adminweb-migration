<?php
// src/Model/Table/OrientationDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class OrientationDepartmentsTable extends Table
{

	public static function defaultConnectionName() {
		return 'orientation-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('orientation_department');
		$this->setPrimaryKey('deptcode');
		$this->setDisplayField('deptalpha');
	}

	public function getByCode($deptcode = null) {
		$department = $this->get($deptcode);
		return $department;
	}

	public function getByDivCode($divcode = null) {
		$query = $this->find('all', [ 'where' => [ 'divcode' => $divcode ] ]);
		$department = $query->first();
		return $department;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'deptalpha' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		$departments = $query->toList();
		$departments['00'] = '-- Not Listed --';
		return $departments;
	}

}