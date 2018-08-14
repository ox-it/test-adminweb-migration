<?php
// src/Model/Table/AADEventsDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class AADEventsDepartmentsTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');

		$this->setTable('department');
		$this->table('department');    			// Prior to 3.4.0

		$this->setPrimaryKey('deptcode');
		$this->primaryKey('deptcode');		// Prior to 3.4.0

		$this->setDisplayField('deptalpha');
	}

	public function getByCode($deptcode = null) {
		$department = $this->get($deptcode);
		return $department;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'deptalpha' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		$departments = $query->toArray();
		$departments[''] = '';
		$departments['00'] = '-- Not Listed --';
		return $departments;
	}

}