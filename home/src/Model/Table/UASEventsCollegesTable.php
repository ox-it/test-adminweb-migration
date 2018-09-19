<?php
// src/Model/Table/UASEventsCollegesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class UASEventsCollegesTable extends Table
{

	public static function defaultConnectionName() {
		return 'uas_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('uas_events_college');
		$this->setPrimaryKey('collcode');
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