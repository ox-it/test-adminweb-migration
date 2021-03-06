<?php
// src/Model/Table/FinanceTravelAgentsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class FinanceTravelAgentsTable extends Table
{

	public static function defaultConnectionName() {
		return 'finance_travel';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'agent';
		$this->addBehavior('Timestamp');
		$this->setTable($table);
		$this->setPrimaryKey('agentID');
		$this->setDisplayField('agentname');
		//$this->belongsTo('AADEventsColleges') ->setForeignKey('collcode') ->setBindingKey('collcode');
		//$this->belongsTo('AADEventsDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

	public function getByID($agentID = null)
	{
		$agent = $this->get($agentID);
		return $agent;
	}

	public function getAllAlphabetically() {
		$query = $this->find('all', [ 'order' => [ 'agentname' => 'ASC' ] ]);
		$agents = $query->all();
		return $agents;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'agentname' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		$agents = $query->toArray();
		//$agents['00'] = '-- Not Listed --';
		return $agents;
	}

}