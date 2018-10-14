<?php
// src/Model/Table/OrientationCountriesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class OrientationCountriesTable extends Table
{

	public static function defaultConnectionName() {
		return 'orientation-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('orientation_country');
		$this->setPrimaryKey('domcode');
		$this->setDisplayField('country');
	}

	public function getByCode($domcode = null) {
		$country = $this->get($domcode);
		return $country;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'country' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		return $query->all();
	}

}