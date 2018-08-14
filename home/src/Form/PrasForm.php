<?php
// src/Form/PrasForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Utility\Xml;
use Cake\Utility\Exception\XmlException;

class PrasForm extends Form
{

    static $divisions;
    static $divisionsOptions;
    static $units;
    static $unitsOptions;
    static $subUnits;
    static $subUnitsOptions;
    static $costCentres;
    private static $costCentresOptions;

    protected function _buildSchema(Schema $schema)
    {
        return $schema
          ->addField('changeType', 'string')
          ->addField('entityType', ['type' => 'string'])

          ->addField('changeDate', ['type' => 'date'])
          ->addField('approverName', ['type' => 'string'])
          ->addField('approverJobTitle', ['type' => 'string'])
          ->addField('approverEmail', ['type' => 'string'])

          ->addField('body', ['type' => 'text']);
    }

    function getChangeTypeOptions() {
      return [
        'create' => 'Create',
        'amend'  => 'Amend',
        'remove' => 'Remove'
      ];
    }

    function getEntityTypeOptions() {
      return [
        'level1'      => 'Level 1 Entity',
        'level2'      => 'Level 2 Entity',
        'level3'      => 'Level 3 Entity',
        'cost-centre' => 'HESA Cost Centre'
      ];
    }

    function getCostCentresOptions() {
      if (!is_array(self::$costCentresOptions)) $this->setOrgStructureCostCentres();
      return self::$costCentresOptions;
    }

    function getCostCentresArray() {
      if (!is_array(self::$costCentres)) $this->setOrgStructureCostCentres();
      return self::$costCentres;
    }

    function setOrgStructureCostCentres() {
			$subUnits = $this->getSubUnitsArray();
			self::$costCentres = [];
			self::$costCentresOptions = [];
			foreach($subUnits as $subUnit) {
			  if (!empty($subUnit['Level3HESACostCentres']['CostCentre']) && is_array($subUnit['Level3HESACostCentres']['CostCentre'])) {
			    if (isset($subUnit['Level3HESACostCentres']['CostCentre']['CostCentreCode'])) {
							self::$costCentres[$subUnit['Level3HESACostCentres']['CostCentre']['CostCentreCode']] = $subUnit['Level3HESACostCentres']['CostCentre'];
							self::$costCentresOptions[$subUnit['Level3HESACostCentres']['CostCentre']['CostCentreCode']] = $subUnit['Level3HESACostCentres']['CostCentre']['CostCentreName'];
			    } else {
						foreach($subUnit['Level3HESACostCentres']['CostCentre'] as $cc) {
							self::$costCentres[$cc['CostCentreCode']] = $cc;
							self::$costCentresOptions[$cc['CostCentreCode']] = $cc['CostCentreName'];
						}
				  }
				}
			}
    }

    function getSubUnitsOptions() {
      if (!is_array(self::$subUnitsOptions)) $this->setOrgStructureSubUnits();
      return self::$subUnitsOptions;
    }

    function getSubUnitsArray() {
      if (!is_array(self::$subUnits)) $this->setOrgStructureSubUnits();
      return self::$subUnits;
    }

    function setOrgStructureSubUnits() {
			$units = $this->getUnitsArray();
			self::$subUnits = [];
			self::$subUnitsOptions = [];
			foreach($units as $unit) {
			  if (!empty($unit['Level3Entities']['Level3']) && is_array($unit['Level3Entities']['Level3'])) {
			    if (isset($unit['Level3Entities']['Level3']['Level3EntityCode'])) {
							self::$subUnits[$unit['Level3Entities']['Level3']['Level3EntityCode']] = $unit['Level3Entities']['Level3'];
							self::$subUnitsOptions[$unit['Level3Entities']['Level3']['Level3EntityCode']] = $unit['Level3Entities']['Level3']['Level3EntityFullName'];
			    } else {
						foreach($unit['Level3Entities']['Level3'] as $s) {
							self::$subUnits[$s['Level3EntityCode']] = $s;
							self::$subUnitsOptions[$s['Level3EntityCode']] = $s['Level3EntityFullName'];
						}
				  }
				}
			}
    }

    function getUnitsOptions() {
      if (!is_array(self::$unitsOptions)) $this->setOrgStructureUnits();
      return self::$unitsOptions;
    }

    function getUnitsArray() {
      if (!is_array(self::$units)) $this->setOrgStructureUnits();
      return self::$units;
    }

    function setOrgStructureUnits() {
			$divisions = $this->getDivisionsArray();
			self::$units = [];
			self::$unitsOptions = [];
			foreach($divisions as $division) {
			  if (!empty($division['Level2Entities']['Level2']) && is_array($division['Level2Entities']['Level2'])) {
			    foreach($division['Level2Entities']['Level2'] as $u) {
				    self::$units[$u['Level2EntityCode']] = $u;
				    self::$unitsOptions[$u['Level2EntityCode']] = $u['Level2EntityFullName'];
				  }
				}
			}
    }

    function getDivisionsOptions() {
      if (!is_array(self::$divisionsOptions)) $this->setOrgStructureDivisions();
      return self::$divisionsOptions;
    }

    function getDivisionsArray() {
      if (!is_array(self::$divisions)) $this->setOrgStructureDivisions();
      return self::$divisions;
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

    function getOrgStructureDataArray() {
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
			$validator->requirePresence('changeType');
			return $validator;
    }

    protected function _execute(array $data)
    {
        // Send an email.
        return true;
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