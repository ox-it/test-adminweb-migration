<?php
// src/Model/Table/AADConferenceCollegesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class AADConferenceCollegesTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_conference-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('college');
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