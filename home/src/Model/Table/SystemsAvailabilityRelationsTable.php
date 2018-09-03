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
		$this->setTable('systems_availability_relations');
		$this->setPrimaryKey('id');
		$this->belongsTo('SystemsAvailabilitySystems')->setForeignKey('system_id');
		$this->belongsTo('SystemsAvailabilityViews')->setForeignKey('view_id');
	}

}