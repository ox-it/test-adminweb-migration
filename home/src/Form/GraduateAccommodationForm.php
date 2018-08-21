<?php
// src/Form/GraduateAccommodationForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class GraduateAccommodationForm extends Form
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
			->addField('application_type', 'string')

			->addField('title', 'string')
			->addField('title_other', ['type' => 'string'])
			->addField('surname', ['type' => 'string'])
			->addField('firstname', ['type' => 'string'])
			->addField('othernames', ['type' => 'string'])
			->addField('address_line1', ['type' => 'string'])
			->addField('address_line2', ['type' => 'string'])
			->addField('address_line3', ['type' => 'string'])
			->addField('postcode', ['type' => 'string'])
			->addField('contact_number', ['type' => 'string'])
			->addField('preferred_email', ['type' => 'string'])
			->addField('nationality', ['type' => 'string'])
			->addField('college', ['type' => 'string'])
			->addField('degree', ['type' => 'string'])
			->addField('subject', ['type' => 'string'])
			->addField('supervisor', ['type' => 'string'])
			->addField('oss_number', ['type' => 'string'])
			->addField('term', ['type' => 'string'])
			->addField('term_year', ['type' => 'string'])

			->addField('spouse_title', 'string')
			->addField('spouse_title_other', ['type' => 'string'])
			->addField('spouse_lastname', ['type' => 'string'])
			->addField('spouse_firstname', ['type' => 'string'])
			->addField('spouse_maiden_name', ['type' => 'string'])
			->addField('spouse_relationship', ['type' => 'string'])
			->addField('spouse_nationality', ['type' => 'string'])
			->addField('spouse_preferred_email', ['type' => 'string'])
			->addField('spouse_contact_no', ['type' => 'string'])
			->addField('spouse_college', ['type' => 'string'])
			->addField('spouse_degree', ['type' => 'string'])
			->addField('spouse_subject', ['type' => 'string'])
			->addField('spouse_supervisor', ['type' => 'string'])
			->addField('spouse_oss_number', ['type' => 'string'])
			->addField('spouse_degree_start', ['type' => 'string'])
			->addField('spouse_term', ['type' => 'string'])
			->addField('spouse_term_year', ['type' => 'string'])

			->addField('partner_title', 'string')
			->addField('partner_title_other', ['type' => 'string'])
			->addField('partner_lastname', ['type' => 'string'])
			->addField('partner_firstname', ['type' => 'string'])
			->addField('partner_maiden_name', ['type' => 'string'])
			->addField('partner_relationship', ['type' => 'string'])
			->addField('partner_nationality', ['type' => 'string'])

			->addField('select_child_1', ['type' => 'string'])
			->addField('child_dob_1', ['type' => 'string'])
			->addField('select_child_2', ['type' => 'string'])
			->addField('child_dob_2', ['type' => 'string'])
			->addField('select_child_3', ['type' => 'string'])
			->addField('child_dob_3', ['type' => 'string'])
			->addField('select_child_4', ['type' => 'string'])
			->addField('child_dob_4', ['type' => 'string'])
			->addField('select_child_5', ['type' => 'string'])
			->addField('child_dob_5', ['type' => 'string'])
			->addField('select_child_6', ['type' => 'string'])
			->addField('child_dob_6', ['type' => 'string'])

			->addField('acc_prefer_1', ['type' => 'string'])
			->addField('acc_prefer_2', ['type' => 'string'])
			->addField('acc_prefer_3', ['type' => 'string'])
			->addField('acc_prefer_4', ['type' => 'string'])

			->addField('tenancy_accept', ['type' => 'string'])
			->addField('comments', ['type' => 'text']);
	}

	protected function _buildValidator(Validator $validator)
	{
    $validator ->notEmpty('application_type');
		$validator ->notEmpty(['title','surname','firstname','contact_number','preferred_email','nationality','college','degree','subject','term','term_year','acc_prefer_1','acc_prefer_2','tenancy_accept']);

		// Conditional validation
		foreach(['spouse_title','spouse_firstname','spouse_lastname','spouse_relationship','spouse_nationality','spouse_preferred_email','spouse_contact_no','spouse_college','spouse_degree','spouse_subject','spouse_degree_start'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['application_type']) && $context['data']['application_type']=='Joint'); });
		}
		foreach(['partner_title','partner_lastname','partner_firstname','partner_relationship','partner_nationality'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['application_type']) && $context['data']['application_type']=='Couple/Family'); });
		}

		return $validator;
	}

	protected function _execute(array $data)
	{
		// TODO: Create XML file & send in an email.
		$type = $data['application_type'];
		if ($type == 'Single'){
			$data['email_to'] = [ "singles.accommodation@admin.ox.ac.uk" => 'Singles Accommodation' ];
		} else {
			$data['email_to'] = [ "couples.accommodation@admin.ox.ac.uk" => 'Couples Accommodation' ];
		}
		$title = $data['title']!='Other' ? $data['title'] . ' ' : $data['title_other'];
		$name  = $data['firstname'] . ' ' . $data['surname'] . (!empty($data['othernames']) ? ' (nee ' . $data['othernames'] . ')' : '');
		$data['email_subject'] = 'New '.$type.' Application from ' . $name;
		$data['name'] = $name;
		return $data;
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

}