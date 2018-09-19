<?php
// src/Model/Table/UASEventsLocationsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class UASEventsLocationsTable extends Table
{

	public static function defaultConnectionName() {
		return 'uas_events-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('uas_events_location');
		$this->setPrimaryKey('locationID');
		$this->setDisplayField('location');
	}

	public function getByID($locationID = null) {
		$location = $this->get($locationID);
		return $location;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'location' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		return $query->all();
	}

}