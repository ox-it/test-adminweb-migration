<?php
// src/Model/Table/TracGroupsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class TracGroupsTable extends Table
{

  private $airclassOptions = [ 'E'=>'Economy', 'B'=>'Business' ];
  private $trainclassOptions = [ '2'=>'Standard', '1'=>'1st Class' ];
  private $yesnoOptions = [ 'Y'=>'Yes', 'N'=>'No' ];

  public static function defaultConnectionName() {
    return 'trac';
  }

  public function initialize(array $config)
  {
    $db_config = $config['connection']->config();
    $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
    $table = $prefix . 'group';
    if (!empty($db_config['tables']) && is_array($db_config['tables']) && count($db_config['tables'])==2) $table = str_replace($db_config['tables'][0], $db_config['tables'][1], $table);
    $this->addBehavior('Timestamp');
    $this->setTable($table);
    $this->setPrimaryKey('weekly_group');
    //$this->hasOne('HarassmentUsers') ->setForeignKey('userID') ->setBindingKey('personID');
    //$this->hasOne('HarassmentDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
  }

  public function getByID($groupID = null) {
    $query = $this->find('all') ->where(['weekly_group'=>$groupID]);
    $group = $query->first();
    return $group;
  }

  public function getByDeptAndYear($deptcode, $acyear) {
    $query = $this->find('all') ->where(['HarassmentDepartments.deptcode'=>$deptcode,'year'=>$acyear]) -> contain(['HarassmentUsers','HarassmentDepartments']);
    $survey = $query->first();
    return $survey;
  }

  public function getByDept($deptcode) {
    $query = $this->find('all') ->where(['HarassmentDepartments.deptcode'=>$deptcode]) ->order(['year'=>'ASC']) -> contain(['HarassmentUsers','HarassmentDepartments']);
    $surveys = $query->all();
    return $surveys;
  }

  public function validationReport($validator) {
    $validator ->notEmpty(['official_role','12inqdeptcode','same_dept','eoo_satisfaction']);

    // Conditional validation
    $validator->notEmpty('22fadviceotherdetails', null, function ($context) { return (!empty($context['data']['22fadviceother']) && $context['data']['22fadviceother']=='1'); });
    $validator->notEmpty('3hotherdetails', null, function ($context) { return (!empty($context['data']['3hother']) && $context['data']['3hother']=='1'); });
    $validator->notEmpty('4gotherdetails', null, function ($context) { return (!empty($context['data']['4gother']) && $context['data']['4gother']=='1'); });

    $validator->notEmpty('grievance', null, function ($context) { return (!empty($context['data']['62agrievance']) && $context['data']['62agrievance']=='1'); });
    $validator->notEmpty('62bdisciplinaryaction', null, function ($context) { return (!empty($context['data']['62bdisciplinary']) && $context['data']['62bdisciplinary']=='1'); });
    $validator->notEmpty('62cformalotherdetails', null, function ($context) { return (!empty($context['data']['62cformalother']) && $context['data']['62cformalother']=='1'); });
    $validator->notEmpty('72fotherdetails', null, function ($context) { return (!empty($context['data']['72eother']) && $context['data']['72eother']=='1'); });
    $validator->notEmpty('81bapproachthirddetails', null, function ($context) { return (!empty($context['data']['81bapproachthird']) && $context['data']['81bapproachthird']=='1'); });
    $validator->notEmpty('81cotheractiondetails', null, function ($context) { return (!empty($context['data']['81cotheraction']) && $context['data']['81cotheraction']=='1'); });
    $validator->notEmpty('82creferreddetails', null, function ($context) { return (!empty($context['data']['82creferred']) && $context['data']['82creferred']=='1'); });

    return $validator;
  }

  public function beforeSave($event, $entity, $options) {
    if ($entity->isNew()) {
      //$entity->webdate = date('d/m/Y');
    }
  }

}