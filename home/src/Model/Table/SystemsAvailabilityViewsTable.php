<?php
// src/Model/Table/SystemsAvailabilityViewsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SystemsAvailabilityViewsTable extends Table
{

	public static function defaultConnectionName() {
			return 'systems_availability-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('systems_availability_views');
		$this->setPrimaryKey('id');
		$this->belongsToMany('SystemsAvailabilitySystems',[
      'through' => 'SystemsAvailabilityRelations',
      'joinTable' => 'systems_availability_relations',
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