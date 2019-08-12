<?php
// src/Model/Entity/HarassmentSurvey.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class HarassmentSurvey extends Entity
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

  public static function textNum($tab='', $size=1, $maxlength=3) {
    $options = [ 'type' => 'text', 'size' => $size, 'maxlength' => $maxlength, 'label' => false, 'class' => 'nomargin' ];
    if (!empty($tab)) $options['tabindex'] = $tab;
    if ($size==1) $options['class'] .= ' center';
    return $options;
  }

	private static function keyValueOptions($values) {
    $result = [];
    foreach ($values as $val) $result[$val] = $val;
    return $result;
  }

  public static function maleFemaleTextNums($form, $m, $f, $label, $tab='', $size=1, $maxlength=3) {
    return '
      <div class="inline_wrapper">
			  ' . $form->Form->control($m, self::textNum($tab, $size, $maxlength)) . '
				' . $form->Form->control($f, self::textNum($tab, $size, $maxlength)) . '
				<p>' . $label . '</p>
			</div>
    ';
  }

  public static function maleFemaleOtherUnknownTextNums($form, $m, $f, $o, $u, $label, $tab='', $size=1, $maxlength=3) {
    $row = '<tr><th scope="row">'.$label.'</th>';
    $row .= '<td>'.$form->Form->control($m, self::textNum($tab, $size, $maxlength)).'</td>';
    $row .= '<td>'.$form->Form->control($f, self::textNum($tab, $size, $maxlength)).'</td>';
    $row .= '<td>'.$form->Form->control($o, self::textNum($tab, $size, $maxlength)).'</td>';
    $row .= '<td>'.$form->Form->control($u, self::textNum($tab, $size, $maxlength)).'</td>';
    $row .= '</tr>';
    return $row;     
  }


}