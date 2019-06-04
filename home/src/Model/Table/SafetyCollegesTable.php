<?php
// src/Model/Table/SafetyCollegesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class SafetyCollegesTable extends Table
{

    public static function defaultConnectionName() {
      return 'safety';
    }

    public function initialize(array $config)
    {
        $db_config = $config['connection']->config();
        $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
        $table = $prefix . 'college';
        $this->setTable($table);
        $this->addBehavior('Timestamp');
        $this->setPrimaryKey('collcode');
        $this->setDisplayField('college');
    }

    public function getByCode($collcode = null) {
      $college = $this->get($collcode);
      return $college;
    }

    public function getSelectOptions() {
      $query = $this->find('all', [ 'order' => [ 'SafetyColleges.college' => 'ASC' ] ]);
      $query = $this->findList($query, []);
      return $query->all();
    }

}