<?php
// src/Model/Table/HarassmentDepartmentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class HarassmentDepartmentsTable extends Table
{

	public static function defaultConnectionName() {
		return 'harassment-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('department');
		$this->setPrimaryKey('deptcode');
		$this->setDisplayField('deptalpha');
		$this->belongsToMany('HarassmentUsers',[
      'through' => 'HarassmentUsersDepartments',
      'foreignKey' => 'deptcode',
      'targetForeignKey' => 'userID'
    ]);
	}

	public function getByCode($deptcode = null) {
		$department = $this->get($deptcode);
		return $department;
	}

	public function getByOxfordID()
	{
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all')
			->matching( 'HarassmentUsers' )
			->where([ 'HarassmentUsers.oxfordID' => $oxfordID ])
			->order([ 'HarassmentDepartments.deptalpha' => 'ASC' ])
			;
    $userdepts = $query->all();
    //$user->department = (!empty($person->a_a_d_events_department)) ? $person->a_a_d_events_department->deptalpha : $person->depttext;
    //$user->college = (!empty($person->a_a_d_events_college)) ? $person->a_a_d_events_college->college : '';
    return $userdepts;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'deptalpha' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		$departments = $query->toArray();
		//$departments['00'] = '-- Not Listed --';
		return $departments;
	}

}