<?php
// src/Model/Table/HarassmentUsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class HarassmentUsersTable extends Table
{

	public static function defaultConnectionName() {
		return 'harassment';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'user';
		$this->addBehavior('Timestamp');
		$this->setTable($table);
		$this->setPrimaryKey('userID');
		$this->belongsToMany('HarassmentDepartments', [
		  'joinTable' => 'harassment_user_dept',
		  'foreignKey' => 'userID',
		  'targetForeignKey' => 'deptcode'
		]);
	}

	public function getByOxfordID()
	{
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all') ->where(['oxfordID'=>$oxfordID]) -> contain(['HarassmentDepartments']);
    $user = $query->first();
    return $user;
	}

	public function validationRegister()
	{
		$validator = new Validator();
		$validator ->requirePresence('name') ->notBlank('name', 'Please complete this field');
		return $validator;
	}

	public function beforeSave($event, $entity, $options)
	{
		if ($entity->isNew()) {
			$entity->oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? $_SERVER['HTTP_WAF_WEBAUTH'] : 'notgiven';
		}
	}

}