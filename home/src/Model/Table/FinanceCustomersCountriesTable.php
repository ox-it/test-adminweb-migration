<?php
// src/Model/Table/FinanceCustomersCountriesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class FinanceCustomersCountriesTable extends Table
{

	public static function defaultConnectionName() {
		return 'finance_customers';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'country';
		$this->addBehavior('Timestamp');
		$this->setTable($table);
		$this->setPrimaryKey('domcode');
		$this->setDisplayField('domicile');
	}

	public function getByCode($domcode = null) {
		$country = $this->get($domcode);
		return $country;
	}

	public function getSelectOptions() {
		$query = $this->find('all', [ 'order' => [ 'domicile' => 'ASC' ] ]);
		$query = $this->findList($query, []);
		return $query->all();
	}

	public function getEUVATByCode($domcode = null) {
	  if ($domcode) {
	    $country = $this->get($domcode);
	    return $country->EUVAT;
	  }
	  return 'N';
	}

}