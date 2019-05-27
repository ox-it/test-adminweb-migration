<?php
// src/Model/Table/TracSurveysTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class TracSurveysTable extends Table
{

  public static function defaultConnectionName() {
    return 'trac';
  }

  public function initialize(array $config)
  {
    $db_config = $config['connection']->config();
    $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
    $table = $prefix . 'survey';
    if (!empty($db_config['tables']) && is_array($db_config['tables']) && count($db_config['tables'])==2) $table = str_replace($db_config['prefix'][0], $db_config['prefix'][1], $table);
    $this->addBehavior('Timestamp');
    $this->setTable($table);
    $this->setPrimaryKey(['payroll','oxfordid','weekly_group']);
    $this->belongsTo('TracGroups') -> setForeignKey('weekly_group') -> setBindingKey('weekly_group');
  }

  public function getByOxfordID()
  {
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? trim($_SERVER['HTTP_WAF_WEBAUTH']) : 'notgiven';
    $query = $this->find('all') -> where(['oxfordid'=>$oxfordID]) -> order([ 'TracSurveys.weekly_group' => 'DESC' ]) -> contain('TracGroups');
    $survey = $query->first();
    if ($survey) {
      $survey->work_factor = (empty($survey->pftw) || $survey->pftw==0) ? 1 : (floatval($survey->pftw)/100.0);
      $survey->submitted_stamp = strtotime($survey->date_submitted);
      $survey->group_colour = $survey->trac_group->form_colour;
      $survey->group_week = $survey->trac_group->target_week;
      $survey->group_finish_date = $survey->trac_group->coll_finish_date;
      // Make sure we supply days for absences
      $absents = ['xsic','xhol','xsab','xmat','xoth'];
      foreach($absents as $a) $survey->{$a.'_d'} = round($survey->{$a.'_h'} / 7.5, 3);
      // Totals
      $xs = ['xsic','xhol','xsab','xmat','xoth']; $survey->xt_h = 0;
      foreach($xs as $x) $survey->xt_h += floatval($survey->{$x.'_h'});
      $as = ['a01','a02','a43','a53','a04','a07','a48','a58','a21','a22','a63','a73','a24','a27','a68','a78','b17','a33','b88','b98','a08']; $survey->abtd = 0; $survey->abta = 0;
      foreach($as as $a) { $survey->abtd += floatval($survey->{$a.'d'}); $survey->abta += floatval($survey->{$a.'a'}); }
      $b1s = ['b11','b12','b13','b14']; $survey->b1t_h = 0;
      foreach($b1s as $b1) $survey->b1t_h += floatval($survey->{$b1.'_h'});
      $b2s = ['b21','b22','b23','b24','b25','b26']; $survey->b2t_h = 0;
      foreach($b2s as $b2) $survey->b2t_h += floatval($survey->{$b2.'_h'});
      $survey->bt_h = $survey->b1t_h + $survey->b2t_h + $survey->b31_h;
      $cs = ['c1','c1a','c2','c3','c4','c5','c6']; $survey->ct_h = 0;
      foreach($cs as $c) $survey->ct_h += floatval($survey->{$c.'_h'});
      $ds = ['d11','d12','d21','d13']; $survey->dt_h = 0;
      foreach($ds as $d) $survey->dt_h += floatval($survey->{$d.'_h'});
      $survey->tt_h = $survey->xt_h + $survey->abtd + $survey->abta + $survey->bt_h + $survey->ct_h + $survey->dt_h;
    }
    return $survey;
  }

  public function validationBlue()
  {
    $validator = $this->validationCommon();
    return $validator;
  }

  public function validationGreen()
  {
    $validator = $this->validationCommon();
    return $validator;
  }

  public function validationCommon()
  {
    $validator = new Validator();
    $validator ->notEmpty(['surname','pin','title','initials','department']);
    $validator ->notEmpty(['gender']);
    return $validator;
  }

  public function beforeSave($event, $entity, $options)
  {
    // Make sure we have hours for absences
    $absents = ['xsic','xhol','xsab','xmat','xoth'];
    foreach($absents as $a) { $entity->{$a.'_h'} = floatval($entity->{$a.'_d'}) * 7.5; }

    // Make sure all hours are 2 dp
    $hours = ['xsic_h','xhol_h','xsab_h','xmat_h','xoth_h'];
    $teaching = ['a01','a02','a43','a53','a04','a07','a48','a58','a21','a22','a63','a73','a24','a27','a68','a78','b17','a33','b88','b98','a08'];
    foreach($teaching as $t) array_push($hours, $t.'d', $t.'1');
    $other = ['b11','b12','b13','b14','b21','b22','b23','b24','b25','b26','b31','c1','c1a','c2','c3','c4','c5','c6','d11','d12','d21','d13'];
    foreach($other as $o) $hours[] = $o.'_h';
    foreach($hours as $h) $entity->{$h} = round(floatval($entity->{$h}), 2);

    $entity->data_type = 'h';
    $entity->date_submitted = date('Y-m-d H:i:s');
    if ($entity->isNew()) {
      $entity->oxfordid = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? $_SERVER['HTTP_WAF_WEBAUTH'] : 'notgiven';
      //print 'NEW: ' . print_r($entity, true);
    } else {
      //print 'UPDATE: ' . print_r($entity, true);
    }
  }

}