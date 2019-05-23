<?php
// src/Form/StaffSearchForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class StaffSearchForm extends Form
{

  public static function spacer() {
    return '<div class="spacer">&nbsp;</div>';
  }

  public static function matchOptions() {
    return [
      'e'=>'Exact',
      'a'=>'Approximate'
    ];
  }

  public static function searchHeaderText($small=false) {
    return $small ? 'Contact search' : 'Search Contacts';
  }

  public static function lastnameLabel($small=false) {
    return $small ? 'Surname' : false;
  }

  public static function initialLabel($small=false) {
    return $small ? 'Initial' : false;
  }

  public static function lastnamePlaceholder($small=false) {
    return $small ? 'e.g. Smith' : 'Surname';
  }

  public static function initialPlaceholder($small=false) {
    return $small ? 'e.g. J' : 'Initial';
  }

  public static function emailButtonText($small=false) {
    return $small ? 'Email' : 'Email Addresses';
  }

  public static function phoneButtonText($small=false) {
    return $small ? 'Phone' : 'Phone Numbers';
  }

  public static function incorrectDetailsHTML($small=false) {
    $url = '//staff.admin.ox.ac.uk/how-do-i/update-my-details-in-contact-search-on-the-staff-gateway';
    $text = 'Contact details incorrect?';
    return '<a href="' . $url . '">' . $text . '</a>';
  }

  public static function emergencyContactHTML($small=false, $context=null) {
    $url = '//www.admin.ox.ac.uk/ouss/contactus/';
    $text = 'Emergency numbers';

    if (($small&&isset($context)) || (!$small&&!isset($context))) return '';
    if (empty($context)) return '<a href="' . $url . '" name="emergency_numbers" title="' . $text . '" id="emergency_numbers"><span class="exclamation"></span>' . $text . '</a>';
    return $context->Form->button($text, [ 'type'=>'classbutton', 'onclick'=>"window.location.href='$url';", 'class' => 'emergency-numbers button btn' ]);
  }

	protected function _buildSchema(Schema $schema) {
	  $schema->addField('lastname',[]);
	  $schema->addField('initial',[]);
	  $schema->addField('exact',[]);
	  $schema->addField('match',[]);
	  return $schema;
	}

  /*
	protected function _buildValidator(Validator $validator) {
    $validator ->notEmpty( 'lastname', 'Please enter the name to search for' );
		return $validator;
	}
	//*/

	protected function _execute(array $data) {
	  $data['match'] = empty($data['exact']) || $data['exact']=='e' ? 'exact' : 'approximate';
	  $data['medium'] = isset($data['email']) ? 'email' : 'phone';
    return $data;
	}

}