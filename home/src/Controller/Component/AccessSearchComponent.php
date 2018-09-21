<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * Created by Al Pirrie
 * @ 21-09-2018 13:03:00
 *
 * Functions lifted from engine.sys.php at
 * Created by Netbeans.
 * User: Mawunyo Awoonor
 * Date: 17/09/14
 * Time: 16:56
 *
 * Also includes config.php in the initialize function
 * Created by PhpStorm.
 * User: Mawunyo
 * Date: 19/09/14
 * Time: 10:07
 */
class AccessSearchComponent extends Component
{

	private $search_query_options = [
		'furniture'=>'accessibility_has_adapted_furniture',
		'cafe'=>'accessibility_has_cafe_refreshments',
		'parking'=>'accessibility_has_accessible_toilets',
		'hearing'=>'accessibility_has_hearing_system',
		'lift'=>'accessibility_has_lifts_to_all_floors',
		'toilets'=>'accessibility_has_access_guide_information'
	];

	public function initialize(array $config)
	{
		$this->param = [
			'apiPath' => 'http://api.m.ox.ac.uk/places/search',
			'mapURL' => 'https://ox-it.github.io/maps.ox/#/places/',

			// fixer:
			// provides the absolute path for media from the prod
			//environment since these resources are not available locally
			'fixer' => 'http://www.admin.ox.ac.uk/',
			'log' => true,
			'logFile' => 'logs/error_'.date('d-m-Y').'.log',
			'mail' => 'finlay.birnie@it.ox.ac.uk',
			'redirect' => 'err.php',
			'show' =>	false,
			'appname' => 'Access Guide',
			'action' => '/access/search/'
		];
	}

	public function CurlProcess($fields)
	{
			$handle = curl_init();
			$url = $this->param['apiPath'] . $this->BuildQuery($fields);
			curl_setopt($handle, CURLOPT_URL ,$url);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($handle);
			//replace new line with html friendly break
			$output = str_replace('\n', '<br/>', $output);
			curl_close($handle);
			$result = json_decode($output, TRUE);
			return $result;
	}

	/**
	 * @param array $fields on the form ($_POST) or a string from A to Z
	 * @return string $str string or the search query to pass to the API
	 * Generate string to pass to CurlProcess Function
	 */
	public function BuildQuery( $fields ){
			if (!is_string($fields)) {

				$str = '?q=';
				$str .= !empty($fields['keywords'])      ? urlencode($fields['keywords']) : '';

				foreach($this->search_query_options as $key => $term) {
					if ( !empty($fields[$key]) && strtolower($fields[$key])=='y' ) {
						$str .= '&'.$term.'=true';
					}
				}
				if (strpos($str, '&' ) === false) $str .= '&accessibility_has_access_guide_information=true';

			} else {
				$str = $fields;
			}
		return $str;
	}

	/**
	 * @param boolean $var
	 * @return string(yes/no)
	 * convert 0 or 1, or true or false received to yes or no
	 */
	public function YesOrNo($var){
			return ((bool)$var === true)? 'Yes':'No';
	}

	/**
	 * @param string $var
	 * @return string
	 * if a variable has no info or not set return Information Not Available
	 */
	public function Available($var){
			return ( isset($var) or is_null($var) )? $var : 'Information Not Available';
	}

}
