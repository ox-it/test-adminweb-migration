<?php
// src/Form/JobsForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Xml;
use Cake\Utility\Exception\XmlException;

class JobsForm extends Form
{

  static $replace = [
		["\xc2\x96","\xc2\x91","\xc2\x92","\n","\r"],
		['&ndash;' ,'&lsquo;' ,'&rsquo;', '',  '' ]
	];

    function getHierarchyArray() {
			static $hierarchy;
			if (is_array($hierarchy)) return $hierarchy;

			$hierarchy = [];
			$org = $this->getOrgStructureDataArray();
			$divisions = $org['OrganisationStructure']['Level1Entities']['Level1'];
			foreach($divisions as $division) {
			  $d_key = $division['Level1EntityCode'];
			  $hierarchy[$d_key] = ['name'=>$division['Level1EntityName']];

			  if (!empty($division['Level2Entities']['Level2']) && is_array($division['Level2Entities']['Level2'])) {
			    $units = $division['Level2Entities']['Level2'];
			    $hierarchy[$d_key]['units'] = [];

			    foreach($units as $unit) {
						$u_key = $unit['Level2EntityCode'];
						$hierarchy[$d_key]['units'][$u_key] = ['full'=>$unit['Level2EntityFullName'], 'name'=>$unit['Level2EntityName']];

						if (!empty($unit['Level3Entities']['Level3']) && is_array($unit['Level3Entities']['Level3'])) {
						  if (isset($unit['Level3Entities']['Level3']['Level3EntityCode'])) {
						    $subunits = [$unit['Level3Entities']['Level3']];
						  } else {
						    $subunits = $unit['Level3Entities']['Level3'];
							}
							$hierarchy[$d_key]['units'][$u_key]['subunits'] = [];
							foreach($subunits as $subunit) {
							  $s_key = $subunit['Level3EntityCode'];
							  $hierarchy[$d_key]['units'][$u_key]['subunits'][$s_key] = ['full'=>$subunit['Level3EntityFullName'], 'name'=>$subunit['Level3EntityName']];

								if (!empty($subunit['Level3HESACostCentres']['CostCentre']) && is_array($subunit['Level3HESACostCentres']['CostCentre'])) {
  								if (isset($subunit['Level3HESACostCentres']['CostCentre']['CostCentreCode'])) {
  								  $costcentres = [$subunit['Level3HESACostCentres']['CostCentre']];
  								} else {
  								  $costcentres = $subunit['Level3HESACostCentres']['CostCentre'];
  								}
                  $hierarchy[$d_key]['units'][$u_key]['subunits'][$s_key]['ccs'] = [];
									foreach($costcentres as $cc) {
									  $c_key = $cc['CostCentreCode'];
									  $hierarchy[$d_key]['units'][$u_key]['subunits'][$s_key]['ccs'][$c_key] = ['name'=>$cc['CostCentreName'], 'prec'=>$cc['CostCentrePercentage']];
									}
								}
							}
						}
				  }
				}
			}
			return $hierarchy;
    }

    function getJobsFeedContents() {
			static $contents;
			if (!empty($contents)) return $contents;

			$file = new File(ROOT . '/includes/jobs-feed.xml');
      $contents = $file->read();
      $contents = mb_convert_encoding($contents, 'UTF-8', 'ISO-8859-1');
      $contents = str_replace(self::$replace[0], self::$replace[1], $contents);

			return $contents;
    }

    function getJobsFeedArray() {
			static $feed;
			if (is_array($feed)) return $feed;
			$feedxml = $this->getJobsFeedContents();
			try {
				$xml = Xml::build($feedxml);
			} catch (Cake\Utility\Exception\XmlException $e) {
				throw new InternalErrorException();
			}
			$feed = Xml::toArray($xml);
			return $feed;
    }

    public function validationSomething() {
      $validator = new Validator();
      $validator ->requirePresence('email') ->notEmpty('email', 'Please enter a valid email address');

        $validator
          ->add('changeType', 'length', [ 'rule' => ['minLength', 5], 'message' => 'Please select a change type' ])
          ->add('entityType', 'length', [ 'rule' => ['minLength', 6], 'message' => 'Please select a change type' ])

          ->add('changeDate', 'required', ['rule' => 'notBlank', 'message' => 'Please enter a date'])
          ->add('approverName', 'required', ['rule' => 'notBlank', 'message' => 'Please enter the approver\'s name'])
          ->add('approverJobTitle', 'required', ['rule' => 'notBlank', 'message' => 'Please enter the approver\'s job title'])
          ->add('approverEmail', 'required', ['rule' => 'email', 'message' => 'Please enter a valid email address']);

        return $validator;
    }


}