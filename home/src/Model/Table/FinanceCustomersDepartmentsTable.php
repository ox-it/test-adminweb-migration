<?php
// src/Model/Table/FinanceCustomersDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class FinanceCustomersDepartmentsTable extends Table
{

	public static function defaultConnectionName() {
		return 'finance_customers';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'department';
		$this->addBehavior('Timestamp');
		$this->setTable($table);
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
		$departments = $query->toArray();
		$departments[''] = '';
		$departments['00'] = '-- Not Listed --';
		return $departments;
	}

}