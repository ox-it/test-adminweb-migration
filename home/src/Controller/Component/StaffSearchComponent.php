<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * Created by Al Pirrie
 * @ 16-03-2019 11:11:00
 *
 * Follows the design of the AccessSearch WAF
 */
class StaffSearchComponent extends Component
{

	private $search_match_options = [
		'e'=>true,
		'a'=>false
	];

	public function initialize(array $config)
	{
		$this->param = [
			'apiPath' => 'https://api.m.ox.ac.uk/contact/search',
			'limit' => 10,
			'technical_support_email' => 'finlay.birnie@it.ox.ac.uk',
		];
	}

	public function CurlProcess($data)
	{
			$handle = curl_init();
			$data['query'] = $this->BuildQuery($data);
			$data['url'] = $this->param['apiPath'] . '?' . $data['query'];

			curl_setopt($handle, CURLOPT_URL, $data['url']);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($handle);
			$output = str_replace('\n', '<br/>', $output);
			curl_close($handle);

			$json = json_decode($output, TRUE);
			$persons = (!empty($json['persons'])) ? $json['persons'] : array();

			foreach ($persons as $i=>$person) {
			  $p = floor($i / $data['limit']);
			  $persons[$i]['index'] = $i+1;
			  $persons[$i]['page'] = $p+1;
			}

			if (count($persons) > $data['limit']) {
			  $data['pager_size'] = ceil(count($persons) / $data['limit']);
			}

			$result = array('data'=>$data, 'result'=>$persons, 'params'=>$this->param);
			return $result;
	}

	/**
	 * @param array $fields on the form ($_POST) or a string from A to Z
	 * @return string $query string or the search query to pass to the API
	 * Generate string to pass to CurlProcess Function
	 */
	public function BuildQuery($fields){

		if (is_array($fields)) {

		  $name = array();
		  if (!empty($fields['initial'])) $name[] = $fields['initial'];
		  if (!empty($fields['lastname'])) $name[] = $fields['lastname'];

		  $query = array();
		  $query['q'] = (!empty($name)) ? urlencode( implode(' ', $name) ) : '';
			// we need to URL encode the string of course
			// but the mobile oxford API expects initial and surname separated by space e.g. 'f birnie'
			// URL encoding the string puts a + instead of a space so replace it
			$query['q'] = str_replace('+',' ',$query['q']);

		  if (!empty($fields['medium']))  $query['medium'] = $fields['medium'];
		  if (!empty($fields['match']))   $query['match'] = $fields['match'];

			return http_build_query($query);

		}
		return $fields;
	}

}
