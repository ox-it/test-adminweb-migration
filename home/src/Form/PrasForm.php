<?php
// src/Form/PrasForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\Email;
use Cake\Utility\Xml;
use Cake\Utility\Exception\XmlException;
use Cake\Validation\Validator;

class PrasForm extends Form
{

    static $divisions;
    static $divisionsOptions;
    static $units;
    static $unitsOptions;
    static $shortUnitsOptions;
    static $subUnits;
    static $subUnitsOptions;
    static $shortSubUnitsOptions;
    static $costCentres;
    static $costCentresOptions;
    static $costCentresPercentageOptions;

    protected function _buildSchema(Schema $schema)
    {
        return $schema
          ->addField('changeType', 'string')
          ->addField('entity', 'string')
          ->addField('entityType', 'string')

          ->addField('changeDate', ['type' => 'date'])
          ->addField('approverName', 'string')
          ->addField('approverJobTitle', ['type' => 'string'])
          ->addField('approverEmail', ['type' => 'string'])

          ->addField('body', ['type' => 'text']);
    }

    public static function yesNoOptions() {
      return ['yes'=>'Yes', 'no'=>'No'];
    }

		public static function changeTypeOptions() {
			return [
					'create' => 'Create',
					'amend'  => 'Amend',
					'remove' => 'Remove'
			];
		}

    public static function entityTypeOptions() {
      return [
        'level1'      => 'Level 1 Entity',
        'level2'      => 'Level 2 Entity',
        'level3'      => 'Level 3 Entity',
        'cost-centre' => 'HESA Cost Centre'
      ];
    }

    public static function entityNameOptions($key='') {
      $options = [
        'level1'      => 'Division',
        'level2'      => 'Unit',
        'level3'      => 'SubUnit',
        'cost-centre' => 'Cost Centre'
      ];
      if (empty($options[$key])) return $options;
      else return $options[$key];
    }

    function costCentresOptions() {
      if (!is_array(self::$costCentresOptions)) $this->setOrgStructureCostCentres();
      return self::$costCentresOptions;
    }

    function costCentresPercentageOptions($code=null) {
      if (!is_array(self::$costCentresPercentageOptions)) $this->setOrgStructureCostCentres();
      if (empty(self::$costCentresPercentageOptions[$code])) return self::$costCentresPercentageOptions;
      else return self::$costCentresPercentageOptions[$code];
    }

    function getCostCentresArray($code='') {
      if (!is_array(self::$costCentres)) $this->setOrgStructureCostCentres();
      if (empty(self::$costCentres[$code])) return self::$costCentres;
      else return self::$costCentres[$code];
    }

    function setOrgStructureCostCentres() {
			$subUnits = $this->getSubUnitsArray();
			self::$costCentres = [];
			self::$costCentresOptions = [];
			self::$costCentresPercentageOptions = [];
			foreach($subUnits as $subUnit) {
			  if (!empty($subUnit['Level3HESACostCentres']['CostCentre']) && is_array($subUnit['Level3HESACostCentres']['CostCentre'])) {
			    if (isset($subUnit['Level3HESACostCentres']['CostCentre']['CostCentreCode']) && $subUnit['Level3HESACostCentres']['CostCentre']['CostCentreCode']!='Note') {
							self::$costCentres[$subUnit['Level3HESACostCentres']['CostCentre']['CostCentreCode']] = $subUnit['Level3HESACostCentres']['CostCentre'];
							self::$costCentresOptions[$subUnit['Level3HESACostCentres']['CostCentre']['CostCentreCode']] = $subUnit['Level3HESACostCentres']['CostCentre']['CostCentreName'];
							self::$costCentresPercentageOptions[$subUnit['Level3HESACostCentres']['CostCentre']['CostCentreCode']] = $subUnit['Level3HESACostCentres']['CostCentre']['CostCentrePercentage'];
			    } else {
						foreach($subUnit['Level3HESACostCentres']['CostCentre'] as $cc) {
						  if (!empty($cc['CostCentreCode']) && $cc['CostCentreCode']!='Note') {
							  self::$costCentres[$cc['CostCentreCode']] = $cc;
							  self::$costCentresOptions[$cc['CostCentreCode']] = $cc['CostCentreName'];
							  self::$costCentresPercentageOptions[$cc['CostCentreCode']] = $cc['CostCentrePercentage'];
							}
						}
				  }
				}
			}
    }

    function subUnitsOptions() {
      if (!is_array(self::$subUnitsOptions)) $this->setOrgStructureSubUnits();
      return self::$subUnitsOptions;
    }

    function shortSubUnitsOptions() {
      if (!is_array(self::$shortSubUnitsOptions)) $this->setOrgStructureSubUnits();
      return self::$shortSubUnitsOptions;
    }

    function getSubUnitsArray($code='') {
      if (!is_array(self::$subUnits)) $this->setOrgStructureSubUnits();
      if (empty(self::$subUnits[$code])) return self::$subUnits;
      else return self::$subUnits[$code];
    }

    function setOrgStructureSubUnits() {
			$units = $this->getUnitsArray();
			self::$subUnits = [];
			self::$subUnitsOptions = [];
			self::$shortSubUnitsOptions = [];
			foreach($units as $unit) {
			  if (!empty($unit['Level3Entities']['Level3']) && is_array($unit['Level3Entities']['Level3'])) {
			    if (isset($unit['Level3Entities']['Level3']['Level3EntityCode'])) {
							self::$subUnits[$unit['Level3Entities']['Level3']['Level3EntityCode']] = $unit['Level3Entities']['Level3'];
							self::$subUnitsOptions[$unit['Level3Entities']['Level3']['Level3EntityCode']] = $unit['Level3Entities']['Level3']['Level3EntityFullName'];
        			self::$shortSubUnitsOptions[$unit['Level3Entities']['Level3']['Level3EntityCode']] = $unit['Level3Entities']['Level3']['Level3EntityName'];
			    } else {
						foreach($unit['Level3Entities']['Level3'] as $s) {
							self::$subUnits[$s['Level3EntityCode']] = $s;
							self::$subUnitsOptions[$s['Level3EntityCode']] = $s['Level3EntityFullName'];
							self::$shortSubUnitsOptions[$s['Level3EntityCode']] = $s['Level3EntityName'];
						}
				  }
				}
			}
    }

    function unitsOptions() {
      if (!is_array(self::$unitsOptions)) $this->setOrgStructureUnits();
      return self::$unitsOptions;
    }

    function shortUnitsOptions() {
      if (!is_array(self::$shortUnitsOptions)) $this->setOrgStructureUnits();
      return self::$shortUnitsOptions;
    }

    function getUnitsArray($code='') {
      if (!is_array(self::$units)) $this->setOrgStructureUnits();
      if (empty(self::$units[$code])) return self::$units;
      else return self::$units[$code];
    }

    function setOrgStructureUnits() {
			$divisions = $this->getDivisionsArray();
			self::$units = [];
			self::$unitsOptions = [];
			self::$shortUnitsOptions = [];
			foreach($divisions as $division) {
			  if (!empty($division['Level2Entities']['Level2']) && is_array($division['Level2Entities']['Level2'])) {
			    foreach($division['Level2Entities']['Level2'] as $u) {
				    self::$units[$u['Level2EntityCode']] = $u;
				    self::$unitsOptions[$u['Level2EntityCode']] = $u['Level2EntityFullName'];
				    self::$shortUnitsOptions[$u['Level2EntityCode']] = $u['Level2EntityName'];
				  }
				}
			}
    }

    function divisionsOptions() {
      if (!is_array(self::$divisionsOptions)) $this->setOrgStructureDivisions();
      return self::$divisionsOptions;
    }

    function getDivisionsArray($code='') {
      if (!is_array(self::$divisions)) $this->setOrgStructureDivisions();
      if (empty(self::$divisions[$code])) return self::$divisions;
      else return self::$divisions[$code];
    }

    function setOrgStructureDivisions() {
			$org = $this->getOrgStructureDataArray();
			$entities = $org['OrganisationStructure']['Level1Entities']['Level1'];
			self::$divisions = [];
			self::$divisionsOptions = [];
			foreach($entities as $entity) {
				self::$divisions[$entity['Level1EntityCode']] = $entity;
				self::$divisionsOptions[$entity['Level1EntityCode']] = $entity['Level1EntityName'];
			}
    }

    public static function getHierarchyArray() {
			static $hierarchy;
			if (is_array($hierarchy)) return $hierarchy;

			$hierarchy = [];
			$org = self::getOrgStructureDataArray();
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
									  if ($c_key=='Note') continue;
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

    public static function getOrgStructureDataArray() {
			static $org;
			if (is_array($org)) return $org;
			try {
				$xml = Xml::build(ROOT . '/includes/org-structure-data.xml');
			} catch (Cake\Utility\Exception\XmlException $e) {
				throw new InternalErrorException();
			}
			$org = Xml::toArray($xml);
			return $org;
    }

    protected function _buildValidator(Validator $validator)
    {
      // Universal validation
			$validator ->notEmpty('changeType');
  		$validator ->notEmpty(['changeDate','approverName','approverJobTitle','approverEmail']);
  		$validator ->email('approveremail');

			// Conditional field validation ...
			// ... if not Cost Centre
			foreach(['newFullName','newShortName'] as $target) {
				$validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['entityType']) && $context['data']['entityType']!='cost-centre'); });
			}

			// ... if create
			foreach(['newStaffCharge','existingStaffTransfer','contact','studentLoad','admitGraduates','coursesAwards','researchGrants','departmentalProjects','domainName','itSupport','physicalAddress'] as $target) {
				$validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['changeType']) && $context['data']['changeType']=='create'); });
			}

      // Date validation
      $format = 'd/m/Y';
			$validator->add('changeDate', 'custom', [
				'rule' => function ($value, $context) use ($format) {
				  $m = [];
				  $date = $context['data']['changeDate'];
          preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $date, $m);
          if (empty($m) || count($m)!=4 || strlen($m[1])!=2 || strlen($m[2])!=2 || strlen($m[3])!=4) return false;
          $t = mktime (0,0,0,$m[2],$m[1],$m[3]);
          return ($date === date($format, $t));
				},
				'message' => 'The date is not valid'
			]);

			return $validator;
    }

    protected function _execute(array $data)
    {

      $is_create = 0;
      if ( !empty($data['changeType']) ) {
        $data['safeType'] = in_array( $data['changeType'], array_keys(self::changeTypeOptions()) );
        $is_create = ($data['changeType'] === 'create') ? 1 : 0;
      }

      if (!empty($data['entity'])) {
        $levels = explode('|', $data['entity']);
        $depth = count($levels) + $is_create;
        if ($depth>4) $depth = 4;
        $level_keys = array_keys(self::entityTypeOptions());
        $data['entityType'] = ($depth<=count($level_keys)) ? $level_keys[$depth-1] : 'unknown';

        //$divs = self::divisionsOptions();
        $data['division'] = ($depth>$is_create) ? $levels[0] : '';
        $data['unit'] = ($depth>($is_create+1)) ? $levels[1] : '';
        $data['subunit'] = ($depth>($is_create+2)) ? $levels[2] : '';
        $data['costcentre'] = ($depth>($is_create+3)) ? $levels[3] : '';

        switch ($depth) {
          case ($is_create+1): $data['info'] = $this->getDivisionsArray($levels[0]); break;
          case ($is_create+2): $data['info'] = $this->getUnitsArray($levels[1]); break;
          case ($is_create+3): $data['info'] = $this->getSubUnitsArray($levels[2]); break;
          case ($is_create+4): $data['info'] = $this->getCostCentresArray($levels[3]); break;
        }
      }

      if (!empty($data['stage']) && $data['stage']==2) {
        // Send an email.
    		// TODO: Remove test email
        $email = [
          'to' => ['al@cache.co.uk' => 'Al Pirrie'],
          'from' => ['orgstructure@admin.ox.ac.uk' => 'Planning & Resource Allocation'],
          'subject' => 'Organisational Structure - ' . strtoupper($data['changeType'])
        ];
        $message = '<p>A new submission has been received from the PRAS Organisational Structure Change Form</p>' . "\n";
        $message .= '<p>&nbsp;</p>' . "\n";
        foreach ($data as $k => $v) {
          if (empty($v)) continue;
          if (in_array($k, ['stage','entity','info','safeType'])) continue;
          $message .= '<p>' . $k . ': <strong>' . $v . '</strong></p>' . "\n";
        }
        $message .= '<p>&nbsp;</p>' . "\n";
        $message .= '<p>&nbsp;</p>' . "\n";
        $email['message'] = $message;
        $this->sendEmailConfirmation($email);
        $data['email'] = $email;
      }

      return $data;
    }

  private function sendEmailConfirmation($data)
	{
		$email = new Email('default');
		$email->to($data['to']);
  	$email->from($data['from']);
  	$email->subject($data['subject']);
		$email->emailFormat('html');
		$email->send($data['message']);
	}

}