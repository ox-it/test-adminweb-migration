<?php
// src/Model/Table/SystemsAvailabilityViewsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SystemsAvailabilityViewsTable extends Table
{

	public static function defaultConnectionName() {
			return 'systems_availability';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'views';

		$this->addBehavior('Timestamp');
		$this->setTable($table);
		$this->setPrimaryKey('id');
		$this->belongsToMany('SystemsAvailabilitySystems',[
      'through' => 'SystemsAvailabilityRelations',
      'joinTable' => $prefix . 'relations',
      'foreignKey' => 'view_id',
      'targetForeignKey' => 'system_id'
    ]);
	}

	public function getAllAlphabetically() {
		$query = $this->find('all', [ 'order' => [ 'SystemsAvailabilityViews.name' => 'ASC' ] ]);
		$views = $query->all();
		return $views;
	}

}