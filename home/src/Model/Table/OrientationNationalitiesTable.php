<?php
// src/Model/Table/OrientationNationalitiesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class OrientationNationalitiesTable extends Table
{

	public static function defaultConnectionName() {
		return 'orientation-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('orientation_nationality');
		$this->setPrimaryKey('natcode');
		$this->setDisplayField('nationality');
	}

	public function getByCode($natcode = null) {
		$nationality = $this->get($natcode);
		return $nationality;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'nationality' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		return $query->all();
	}

}