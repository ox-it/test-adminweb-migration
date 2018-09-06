<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class WafComponent extends Component
{

	public function template_wrappers($field, $notes='', $classes=[]) {
    return [
			'inputContainer'=>'<div id="'.$field.'_wrapper" class="input {{type}}{{required}} '.implode(' ',$classes).'">{{content}}'.$notes.'</div>',
			'inputContainerError'=>'<div id="'.$field.'_wrapper" class="input {{type}}{{required}} '.implode(' ',$classes).' error">{{content}}{{error}}'.$notes.'</div>'
    ];
  }

  public function postValueWithLabel($value, $label) {
    if (!empty($value)) echo '
			<p class="display-p">
				<span class="'.(empty($label)?'':'display-label').'">'.h($label).(empty($label)?'':':').'</span>
				<span class="display-value">'.h($value).'</span>
				<span class="display-end"></span>
			</p>
';
  }

  public function postValueWithLabelIfNotZero($value, $label) {
    if (!empty($value) && $value!=0) echo '
			<p class="display-p">
				<span class="'.(empty($label)?'':'display-label').'">'.h($label).(empty($label)?'':':').'</span>
				<span class="display-value">'.h($value).'</span>
				<span class="display-end"></span>
			</p>
';
  }

  public function monthFromNumber($n) {
    if (empty($n) || !is_numeric($n) || $n<1 || $n>12) return '';
    $months = ["1" => "January", "2" => "February", "3" => "March", "4" => "April",
    "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September",
    "10" => "October", "11" => "November", "12" => "December"];
    return $months[strval($n)];
  }

  public function postObjectFieldsAsList($object, $fields) {
    $results = [];
    foreach ($fields as $k=>$f) {
      if (is_numeric($k)) {
        if (!empty($object->{$f})) $results[] = $object->{$f};
      } else {
        if ( !empty($object->{$k}) && ($object->{$k}==1 || $object->{$k}=='Y') ) $results[] = $f;
      }
    }
    if (count($results)>0) {
      echo "\n" . '			<ul class="display-ul">' . "\n";
      foreach ($results as $r) echo "				<li>" . $r . "</li>\n";
      echo "\n			</ul>\n";
    }
  }

  public function renderWafAction($controller) {
    if (!empty($_GET['waf'])) {
      $parts = explode('/',$_GET['waf']);
      $action = $parts[0];
      $data = [];
      if (count($parts)>1) {
        for ( $i=1; $i<count($parts); $i++ ) {
          $data[] = $parts[$i];
        }
      }
      call_user_func_array([$controller, $action], $data);
      $controller->render($action);
      return true;
    }
    return false;
  }

}
