<?php
// src/Model/Table/SystemsAvailabilityRelationsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SystemsAvailabilityRelationsTable extends Table
{

	public static function defaultConnectionName() {
		return 'systems_availability';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'relations';

		$this->addBehavior('Timestamp');
		$this->setTable($table);
		$this->setPrimaryKey('id');
		$this->belongsTo('SystemsAvailabilitySystems')->setForeignKey('system_id');
		$this->belongsTo('SystemsAvailabilityViews')->setForeignKey('view_id');
	}

}