<?php
// src/Model/Table/SafetyDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SafetyDepartmentsTable extends Table
{

  public static function defaultConnectionName() {
    return 'safety';
  }

  public function initialize(array $config)
  {
      $db_config = $config['connection']->config();
      $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
      $table = $prefix . 'department';
      $this->setTable($table);
      $this->addBehavior('Timestamp');
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
    $departments = $query->toArray();
    $departments['00'] = '-- Not Listed --';
    return $departments;
  }

}