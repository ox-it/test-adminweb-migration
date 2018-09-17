<?php
// src/Model/Entity/TracSurvey.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class TracSurvey extends Entity
{

  public static function roleOptions() {
    return [
      '1adeptadviser' => 'Harassment Adviser (your role was to support the complainant/alleged harasser)',
      '1edeptadmin' => 'Departmental Administrator / Personnel officer (you were involved in the investigation/disciplinary action/formal or informal resolution)'
    ];
  }

  public static function yesNoOptions($yes='yes',$no='no') {
    return [
      $yes => 'Yes',
      $no => 'No'
    ];
  }

  public static function genderOptions() {
    return [ 'M'=>'Male', 'F'=>'Female', 'P'=>'Prefer not to say' ];
  }

  public static function yesNoUnknownOptions($yes='yes',$no='no',$unknown='unknown') {
    return [
      $yes => 'Yes',
      $no => 'No',
      $unknown => 'Unknown'
    ];
  }

  public static function grievanceOptions() {
    return [
      '62au' => 'Grievance upheld',
      '62an' => 'Grievance not upheld'
    ];
  }

  public static function monthOptions() {
    return [
			'1' =>'January',
			'2' =>'February',
			'3' =>'March',
			'4' =>'April',
			'5' =>'May',
			'6' =>'June',
			'7' =>'July',
			'8' =>'August',
			'9' =>'September',
			'10' =>'October',
			'11' =>'November',
			'12' =>'December'
    ];
  }

  public static function yearOptions() {
    $year = intval( date('Y') );
    return self::keyValueOptions(range($year-11, $year));
  }

	private static function keyValueOptions($values) {
    $result = [];
    foreach ($values as $val) $result[$val] = $val;
    return $result;
  }



  public static function hoursPercentage($form, $field, $label, $istotal=false) {
    return '
      <div class="row_item column_wrapper'.($istotal?' total':'').'">
				<div class="label_wrapper">
				  <p>' . $label . '</p>
				</div>
        <div class="column_wrapper">
			  ' . $form->Form->control($field.'_h', self::textNum($istotal, 6, 6)) . '<span class="notes">hours</span>
				' . $form->Form->control($field.'_p', self::textNum(true, 6, 6)) . '<span class="notes">%</span>
				</div>
			</div>
    ';
  }

  public static function prepHoursPercentage($form, $field, $label, $istotal=false) {
    return '
      <div class="row_item column_wrapper'.($istotal?' total':'').'">
				<div class="label_wrapper">
				  <p>' . $label . '</p>
				</div>
        <div class="column_wrapper">
			  ' . $form->Form->control($field.'a', self::textNum($istotal, 6, 6)) . '<span class="notes">hours</span>
				' . $form->Form->control($field.'_perc', self::textNum(true, 6, 6)) . '<span class="notes">%</span>
				</div>
			</div>
    ';
  }

  public static function daysHoursPercentageInput($form, $field, $label, $istotal=false) {
    return '
      <div class="row_item column_wrapper'.($istotal?' total':'').'">
				<div class="label_wrapper">
				  <p>' . $label . '</p>
				</div>
        <div class="column_wrapper">
			  ' . $form->Form->control($field.'_d', self::textNum($istotal, 4, 4)) . '<span class="notes">days</span>
				' . $form->Form->control($field.'_h', self::textNum(true, 6, 6)) . '<span class="notes">hours</span>
				' . $form->Form->control($field.'_p', self::textNum(true, 6, 6)) . '<span class="notes">%</span>
				</div>
			</div>
    ';
  }

  public static function contactPrepHoursPercentageInput($form, $field, $label, $istotal=false) {
    return '
      <div class="row_item column_wrapper'.($istotal?' total':'').'">
				<div class="label_wrapper">
				  <p>' . $label . '</p>
				</div>
        <div class="column_wrapper">
			  ' . $form->Form->control($field.'d', self::textNum($istotal, 5, 6)) . '<span class="notes">hours</span>
			  ' . $form->Form->control($field.'a', self::textNum($istotal, 5, 6)) . '<span class="notes">hours</span>
				' . $form->Form->control($field.'_hour', self::textNum(true, 6, 6)) . '<span class="notes">hours</span>
				' . $form->Form->control($field.'_perc', self::textNum(true, 6, 6)) . '<span class="notes">%</span>
				</div>
			</div>
    ';
  }


  public static function textNum($readonly=false, $size=1, $maxlength=3) {
    $options = [ 'type'=>'text', 'size'=>$size, 'maxlength'=>$maxlength, 'label'=>false, 'align'=>'right' ];
    if ($readonly) $options['readonly'] = 'readonly';
    return $options;
  }

  public function postDaysHoursPercWithLabel($value, $label, $istotal=false) {
    $max = 37.5 * (!empty($this->work_factor) ? $this->work_factor : 1.0);
    if (!empty($value) && $value!=0) echo '
      <div class="row_item column_wrapper'.($istotal?' total':'').'">
				<div class="label_wrapper">
				  <div>' . $label . '</div>
				</div>
        <div class="column_wrapper">
			    <div>' . round($value / 7.5, 2) . '<span class="notes">days</span></div>
				  <div>' . round($value, 2) . '<span class="notes">hours</span></div>
				  <div>' . round(100*($value/$max),1) . '<span class="notes">%</span></div>
				</div>
			</div>
    ';
  }

  public function postContactPrepHoursPercentageWithLabel($field, $label, $istotal=false) {
    $max = 37.5 * (!empty($this->work_factor) ? $this->work_factor : 1.0);
    $d = empty($this->{$field.'d'}) ? 0.0 : round($this->{$field.'d'},2);
    $a = empty($this->{$field.'a'}) ? 0.0 : round($this->{$field.'a'},2);
    return '
      <div class="row_item column_wrapper'.($istotal?' total':'').'">
				<div class="label_wrapper">
				  <div>' . $label . '</div>
				</div>
        <div class="column_wrapper">
			    <div>' . $d . '<span class="notes">hours</span></div>
			    <div>' . $a . '<span class="notes">hours</span></div>
				  <div>' . round($d+$a,2) . '<span class="notes">hours</span></div>
				  <div>' . round((100*($d+$a))/$max,1) . '<span class="notes">%</span></div>
				</div>
			</div>
    ';
  }

  public function postPrepHoursPercentageWithLabel($field, $label, $istotal=false) {
    $max = 37.5 * (!empty($this->work_factor) ? $this->work_factor : 1.0);
    $h = empty($this->{$field.'a'}) ? 0.0 : round($this->{$field.'a'},2);
    $p = round((100*$h)/$max,1);
    return '
      <div class="row_item column_wrapper'.($istotal?' total':'').'">
				<div class="label_wrapper">
				  <div>' . $label . '</div>
				</div>
        <div class="column_wrapper">
			    <div>&nbsp;</div>
			    <div>' . $h . '<span class="notes">hours</span></div>
			    <div>&nbsp;</div>
				  <div>' . $p . '<span class="notes">%</span></div>
				</div>
			</div>
    ';
  }

  public function postHoursPercentageWithLabel($field, $label, $istotal=false) {
    $max = 37.5 * (!empty($this->work_factor) ? $this->work_factor : 1.0);
    $h = empty($this->{$field.'_h'}) ? 0.0 : round($this->{$field.'_h'},2);
    $p = round((100*$h)/$max,1);
    return '
      <div class="row_item column_wrapper'.($istotal?' total':'').'">
				<div class="label_wrapper">
				  <div>' . $label . '</div>
				</div>
        <div class="column_wrapper">
			    <div>' . $h . '<span class="notes">hours</span></div>
				  <div>' . $p . '<span class="notes">%</span></div>
				</div>
			</div>
    ';
  }

}