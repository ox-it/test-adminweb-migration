<?php
// src/Form/GraduateAccomodationForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class GraduateAccomodationForm extends Form
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