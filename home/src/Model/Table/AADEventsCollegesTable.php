<?php
// src/Model/Table/AADEventsCollegesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class AADEventsCollegesTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');

		$this->setTable('college');
		$this->table('college');    			// Prior to 3.4.0

		$this->setPrimaryKey('collcode');
		$this->primaryKey('collcode');		// Prior to 3.4.0

		$this->setDisplayField('college');
	}

	public function getByCode($collcode = null) {
		$college = $this->get($collcode);
		return $college;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'college' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		return $query->all();
	}

}