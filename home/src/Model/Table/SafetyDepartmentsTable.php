<?php
// src/Model/Table/SafetyDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SafetyDepartmentsTable extends Table
{

		public static function defaultConnectionName() {
			return 'safety-test';
		}

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->setTable('safety_department');
        $this->setPrimaryKey('deptcode');
        $this->setDisplayField('deptalpha');
    }

    public function getByCode($deptcode = null) {
      $department = $this->get($deptcode);
      return $department;
    }

    public function getSelectOptions() {
      $query = $this->find('all', [ 'order' => [ 'SafetyDepartments.deptalpha' => 'ASC' ] ]);
      $query = $this->findList($query, []);
      return $query->all();
    }

}