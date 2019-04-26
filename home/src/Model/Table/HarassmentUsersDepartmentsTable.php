<?php
// src/Model/Table/HarassmentUsersDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class HarassmentUsersDepartmentsTable extends Table
{

	public static function defaultConnectionName() {
		return 'harassment';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'user_dept';
		$this->addBehavior('Timestamp');
		$this->setTable($table);
		$this->setPrimaryKey('user_deptID');
		$this->belongsTo('HarassmentDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

}