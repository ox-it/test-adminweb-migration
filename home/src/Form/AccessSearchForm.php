<?php
// src/Form/AccessSearchForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class AccessSearchForm extends Form
{

  public static function searchOptions() {
    return [
      'furniture'=>'Adapted furniture',
      'cafe'=>'Accessible cafe',
      'parking'=>'Disabled parking',
      'hearing'=>'Hearing support system',
      'lift'=>'Lift to all floors',
      'toilets'=>'Accessible toilets'
    ];
  }

	protected function _buildSchema(Schema $schema)
	{
	  $checkboxes = $this->searchOptions();
	  foreach ($checkboxes as $key=>$label) $schema->addField($key,'string');
	  return $schema->addField('keywords','string');
	}

	protected function _buildValidator(Validator $validator)
	{
    $validator ->notEmpty(
              'keywords',
              'Please enter the name to search or select one or more features to search by',
              function ($context) {
                foreach($context['data'] as $value) {
                  if (!empty($value) && $value!='N') return false;
                }
								return true;
							});
		return $validator;
	}

	protected function _execute(array $data)
	{
    return $data;
	}

}