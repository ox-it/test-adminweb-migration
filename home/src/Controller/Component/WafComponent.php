<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class WafComponent extends Component
{

	public function template_wrappers($field, $notes='', $classes=[], $type='{{type}}') {
	  if (!is_array($classes)) $classes = explode(' ', $classes);
    return [
			'inputContainer'=>'<div id="'.$field.'_wrapper" class="webform-component form-item form-type-input form-type-'.$type.' '.$type.'{{required}} '.implode(' ',$classes).(!empty($notes)?' with-notes':'').'">{{content}}'.$notes.'</div>',
			'inputContainerError'=>'<div id="'.$field.'_wrapper" class="webform-component form-item form-type-input form-type-'.$type.' '.$type.'{{required}} '.implode(' ',$classes).(!empty($notes)?' with-notes':'').' error">{{content}}{{error}}'.$notes.'</div>'
    ];
  }

  public static function postValueWithLabel($value, $label='', $lookup=null) {
    if (isset($lookup)) {
      if (!is_array($lookup) && is_object($lookup) && method_exists($lookup, 'toArray')) $lookup = $lookup->toArray();
      if (!empty($lookup[$value])) $value = $lookup[$value];
    }
    if (!empty($value)) echo '
			<p class="display-p">
				<span class="'.(empty($label)?'':'display-label').'">'.($label==' '?'&nbsp;':h($label)).(empty(trim($label))||empty(trim($value))?'':':').'</span>
				<span class="display-value">'.h($value).'</span>
				<span class="display-end"></span>
			</p>
';
  }

  public function postValueWithLabelIfNotZero($value, $label='') {
    if (!empty($value) && $value!=0) echo '
			<p class="display-p">
				<span class="'.(empty($label)?'':'display-label').'">'.($label==' '?'&nbsp;':h($label)).(empty($label)?'':':').'</span>
				<span class="display-value">'.h($value).'</span>
				<span class="display-end"></span>
			</p>
';
  }

  public function postHeadersWithLabel($headers=[],$label='') {
    if (!is_array($headers)) $headers = [$headers];
    echo '  				<div class="column_wrapper">'  . "\n" . '					<div class="label_wrapper"><p>'.$label.'</p></div>' . "\n" . '					<div class="column_wrapper">' . "\n";
    foreach ($headers as $header) {
      echo '						<div class="webform-component form-item form-type-header">'.$header.'</div>' . "\n";
    }
    echo '					</div>' . "\n" . '				</div>' . "\n";
  }

  private function stripQuery($url) {
    $p = parse_url($url);
    unset($p['query']);
    return $this->unparse_url($p);
  }

  private function unparse_url($parsed_url) {
		$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
		$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
		$pass     = ($user || $pass) ? "$pass@" : '';
		$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		$query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
		$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
		return "$scheme$user$pass$host$port$path$query$fragment";
	}

  public function postButtonToReferer($context, $text='Back', $strip_query=false) {
    $url = $strip_query ? $this->stripQuery($context->request->referer()) : $context->request->referer();
    echo $context->Html->link($text, $url, ['class'=>'button btn']);
  }

  public function postLinkToReferer($context, $text='Back', $strip_query=false) {
    $url = $strip_query ? $this->stripQuery($context->request->referer()) : $context->request->referer();
    echo $context->Html->link($text, $url);
  }

  public function postLinkToControllerRoot($context, $text='Back') {
    echo $context->Html->link($text, ['action' => 'index']);
  }

  public function monthFromNumber($n) {
    if (empty($n) || !is_numeric($n) || $n<1 || $n>12) return '';
    $months = ["1" => "January", "2" => "February", "3" => "March", "4" => "April",
    "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September",
    "10" => "October", "11" => "November", "12" => "December"];
    return $months[strval($n)];
  }

  // Function to convert a date in dd/mm/yyyy format to a unix timestamp.
  // The time flag should be "start" or "end" to indicate what point in the
  // day the timestamp should represent
	public function date_to_stamp($date_string, $time_flag='start') {
	  if (strlen($date_string)<10) return 0;
	  if (substr($date_string,2,1)=='/') {
			$day = substr($date_string,0,2);
			$month = substr($date_string,3,2);
			$year = substr($date_string,6,4);
			if (strtolower(trim($time_flag)) == 'end') $result = mktime(23, 59, 59, $month, $day, $year);
			else $result = mktime(0, 0, 0, $month, $day, $year);
		} else {
		  $result = strtotime($date_string);
		  if (strtolower(trim($time_flag)) == 'end') $result = mktime(23, 59, 59, date('m',$result), date('d',$result), date('Y',$result));
		}
		return $result;
	}

  // Function to convert a date in dd/mm/yyyy format and time in hh:mm format
  // to a unix timestamp. If :ss is appended to the time this will be added
	public function date_and_time_to_stamp($date_string, $time_string) {
	  if (strlen($date_string)<10) return 0;
	  if (substr($date_string,2,1)=='/') {
			$day = substr($date_string,0,2);
			$month = substr($date_string,3,2);
			$year = substr($date_string,6,4);
			$timebits = explode(':',$time_string);
			$hour = intval($timebits[0]);
			$mins = (count($timebits)>1) ? intval($timebits[1]) : 0;
			$secs = (count($timebits)>2) ? intval($timebits[2]) : 0;
			$result = mktime($hour, $mins, $secs, $month, $day, $year);
		} else {
		  $result = strtotime($date_string.' '.$time_string);
		}
		return $result;
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

  public function camelToProperCase($input='') {
    $parts = preg_split('/(?=[A-Z])/', $input, -1, PREG_SPLIT_NO_EMPTY);
    return ucwords(implode(' ',$parts));
  }

}
