<?php
// src/Model/Table/SystemsAvailabilityRelationsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SystemsAvailabilityRelationsTable extends Table
{

	public static function defaultConnectionName() {
			return 'systems_availability-test';
	}

	public function initialize(array $config)
	{
			$this->addBehavior('Timestamp');

			$this->setTable('relations');
			$this->table('relations');    			// Prior to 3.4.0

			$this->belongsTo('SystemsAvailabilitySystems')->setForeignKey('system_id');
			$this->belongsTo('SystemsAvailabilityViews')->setForeignKey('view_id');
	}

	/*
	public function getSystemsForViewID($viewID = null) {
		$nowstamp = time();
		$query = $this->find('all')
			->where([ 'SystemsAvailabilityRelations.view_id' => $viewID ])
			->order([ 'SystemsAvailabilityRelations.position' => 'ASC' ]);
		$systems = $query->all();
		return $systems;
	}
	//*/

}