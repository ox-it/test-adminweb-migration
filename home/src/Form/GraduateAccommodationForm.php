<?php
// src/Form/GraduateAccommodationForm.php

namespace App\Form;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\I18n\Date;
//use Cake\Mailer\Email;
use Cake\Utility\Xml;
use Cake\Utility\Exception\XmlException;
use Cake\Validation\Validator;

class GraduateAccommodationForm extends Form
{

  public static $single = 'Single';
  public static $joint =  'Joint';
  public static $family = 'Couple/Family';

	static $divisions;
	static $divisionsOptions;
	static $units;
	static $unitsOptions;
	static $subUnits;
	static $subUnitsOptions;
	static $costCentres;
	private static $costCentresOptions;

  public static function applicationOptions() {
    return self::keyValueOptions([ self::$single, self::$joint, self::$family ]);
  }

  public static function titleOptions() {
    return self::keyValueOptions([ 'Mr','Mrs','Miss','Ms','Dr','Other' ]);
  }

  public static function collegeOptions() {
    return self::keyValueOptions([ 'Not Yet Allocated A College','Balliol College','Blackfriars College','Brasenose College','Christ Church College','Corpus Christi College','Exeter College','Green Templeton College','Harris Manchester College','Hertford College','Jesus College','Keble College','Kellogg College','Lady Margaret Hall','Linacre College','Lincoln College','Magdalen College','Mansfield College','Merton College','New College','Nuffield College','Oriel College','Pembroke College','Regent\'s Park College','Somerville College','St Anne\'s College','St Antony\'s College','St Benet\'s College','St Catherine\'s College','St Cross College','St Edmund Hall','St Hilda\'s College','St Hugh\'s College','St John\'s College','St Peter\'s College','St Stephen\'s College','The Queen\'s College','Trinity College','University College','Wadham College','Wolfson College','Worcester College','Wycliffe Hall' ]);
  }

  public static function degreeOptions() {
    return self::keyValueOptions([ 'DPhil','MPhil','MSc','MSt','Masters','BPhil','MTh','PGCert','Cert','Other' ]);
  }

  public static function accommodationOptions() {
    return self::keyValueOptions([ 'Room',  'Ensuite', 'Bedsit', 'Double Studio','One Bed Flat','Two Bed Flat','Three Bed Flat','Two Bed House','Three Bed House' ]);
  }

  public static function termOptions() {
    return self::keyValueOptions([ 'MT - Michaelmas','HT - Hilary','TT - Trinity' ]);
  }

  public static function genderOptions() {
    return self::keyValueOptions([ 'Male','Female' ]);
  }

  public static function yearOptions() {
    $year = intval( date('Y') );
    return self::keyValueOptions(range($year, $year+15));
  }

	private static function keyValueOptions($values) {
    $result = [];
    foreach ($values as $val) $result[$val] = $val;
    return $result;
  }

	protected function _buildSchema(Schema $schema)
	{
	  $strings = [
	    'application_type',
	    'title','title_other','surname','firstname','othernames','address_line1','address_line2','address_line3','postcode','contact_number','preferred_email','nationality','college','degree','degree_other','subject','supervisor','oss_number','degree_start','term','term_year',
	    'partner_title','partner_title_other','partner_lastname','partner_firstname','partner_maiden_name','partner_relationship','partner_nationality','partner_preferred_email','partner_contact_no','partner_college','partner_degree','partner_subject','partner_supervisor','partner_oss_number','partner_degree_start','partner_term','partner_term_year',
	    'spouse_title','spouse_title_other','spouse_lastname','spouse_firstname','spouse_maiden_name','spouse_relationship','spouse_nationality',
	    'select_child_1','child_dob_1','select_child_2','child_dob_2','select_child_3','child_dob_3','select_child_4','child_dob_4','select_child_5','child_dob_5','select_child_6','child_dob_6',
	    'acc_prefer_1','acc_prefer_2','acc_prefer_3','acc_prefer_4','tenancy_accept'
	  ];
	  foreach ($strings as $string) $schema->addField($string, 'string');
		return $schema->addField('comments', ['type' => 'text']);
	}

	protected function _buildValidator(Validator $validator)
	{
    $validator ->notEmpty('application_type');
		$validator ->notEmpty(['title','surname','firstname','contact_number','preferred_email','nationality','college','degree','subject','term','term_year','acc_prefer_1','acc_prefer_2','tenancy_accept']);
		$validator ->add('preferred_email', 'validFormat', [ 'rule'=>'email', 'message' => 'Please enter a valid email' ]);
		$validator ->allowEmpty('partner_preferred_email');
		$validator ->add('partner_preferred_email', 'validFormat', [ 'rule'=>'email', 'message' => 'Please enter a valid email' ]);

		// Date validation
		$validator ->allowEmpty(['child_dob_1','child_dob_2','child_dob_3','child_dob_4','child_dob_5','child_dob_6']);
		$format = 'd/m/Y';
		$fields = ['degree_start','child_dob_1','child_dob_2','child_dob_3','child_dob_4','child_dob_5','child_dob_6','tenancy_accept'];
		foreach($fields as $field) {
			$validator->add($field, 'custom', [
				'rule' => function ($value, $context) use ($format,$field) {
					$m = [];
					$date = $context['data'][$field];
					preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $date, $m);
					if (empty($m) || count($m)!=4 || strlen($m[1])!=2 || strlen($m[2])!=2 || strlen($m[3])!=4) return false;
					$t = mktime (0,0,0,$m[2],$m[1],$m[3]);
					return ($date === date($format, $t));
				},
				'message' => 'This date is not valid'
			]);
		}

		// Conditional validation
		foreach(['partner_title','partner_lastname','partner_firstname','partner_relationship','partner_nationality','partner_preferred_email','partner_contact_no','partner_college','partner_degree','partner_subject','partner_degree_start'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['application_type']) && $context['data']['application_type']==self::$joint); });
		}
		foreach(['spouse_title','spouse_firstname','spouse_lastname','spouse_relationship','spouse_nationality'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['application_type']) && $context['data']['application_type']==self::$family); });
		}

    $validator->notEmpty('degree_other', null, function ($context) { return (!empty($context['data']['application_type']) && !empty($context['data']['degree']) && $context['data']['degree']=='Other'); });

		return $validator;
	}

	protected function _execute(array $data)
	{
		$type = $data['application_type'];
		$data['single'] = ($data['application_type']==self::$single);
		if ($data['single']){
			$data['email_to'] = [ "singles.accommodation@admin.ox.ac.uk" => 'Singles Accommodation' ];
		} else {
			$data['email_to'] = [ "couples.accommodation@admin.ox.ac.uk" => 'Couples Accommodation' ];
		}
		$data['noofchildren'] = (!empty($data['select_child_1'])?1:0) + (!empty($data['select_child_2'])?1:0) + (!empty($data['select_child_3'])?1:0) + (!empty($data['select_child_4'])?1:0) + (!empty($data['select_child_5'])?1:0) + (!empty($data['select_child_6'])?1:0);

		$title = $data['title']!='Other' ? $data['title'] . ' ' : $data['title_other'];
		$data['name']  = $data['firstname'] . ' ' . $data['surname'] . (!empty($data['othernames']) ? ' (nee ' . $data['othernames'] . ')' : '');
		$data['email_subject'] = 'New '.$type.' Application from ' . $data['name'];

		// Make sure all values are present
		$fields = $this->schema()->fields();
		foreach ($fields as $f) if (!isset($data[$f])) $data[$f] = '';

		// Get XML
		$xml = $this->createXMLWithData($data);
		$xmlFilename = strtolower($data['surname'] . '_' . $data['firstname']) . '_' . date('ymdhis') . '.xml';
		$xmlfile = new File(TMP . $xmlFilename, true);
		$xmlfile->write($xml, 'w', true);
		$data['xmlfile'] = TMP . $xmlFilename;

		return $data;
	}

	function createXMLWithData($data=[]) {
    $dateFormat = 'j M Y';
    $isSingle=($data['application_type']==self::$single);
    $isJoint=($data['application_type']==self::$joint);
    $isFamily=($data['application_type']==self::$family);
    $xmlArray = array(
      'Tenant-application-for-qube' => array(
				'Page1' => array(
					'Header' => array(
						'Application-type' => $data['application_type'],
					),
					'Section1' => array(
						'Applicant-surname' => $data['surname'],
						'Applicant-first-name' => $data['firstname'],
						'Applicant-title' => $data['title'],
						'Applicant-other' => $data['title_other'],
						'Address1' => $data['address_line1'],
						'Address2' => $data['address_line2'],
						'Address3' => $data['address_line3'],
						'Address4' => '',
						'Address5' => '',
						'Postcode' => $data['postcode'],
						'Degree-other' => $data['degree_other'],
						'Applicant-maiden-name' => $data['othernames'],
						'Telephone' => $data['contact_number'],
						'Supervisor' => $data['supervisor'],
						'Subject' => $data['subject'],
						'Degree' => $data['degree'],
						'College' => $data['college'],
						'Email' => $data['preferred_email'],
						'Nationality' => $data['nationality'],
						'OSSNumber' => $data['oss_number'],
						'Degree-start-date' => self::getTimeFromString($data['degree_start'], $dateFormat),
						'End-term' => $data['term'],
						'End-year' => $data['term_year'],
					),
					'Section2' => array(
						'Family' => array(
							'Spouse-maiden-name' => $isFamily ? $data['spouse_maiden_name'] : '',
							'Partner-relationship' => $isFamily ? $data['spouse_relationship'] : '',
							'Partner-nationality' => $isFamily ? $data['spouse_nationality'] : '',
							'Spouse-first-name' => $isFamily ? $data['spouse_firstname'] : '',
							'Spouse-surname' => $isFamily ? $data['spouse_lastname'] : '',
							'Spouse-title' => $isFamily ? $data['spouse_title'] : '',
							'Num-children' => $isFamily ? $data['noofchildren'] : '',
							'Spouse-other' => $isFamily ? $data['spouse_title_other'] : '',
						),
						'Child1' => array(
							'Child1-gender' => $isFamily ? $data['select_child_1'] : '',
							'Child1-dob' => $isFamily ? self::getTimeFromString($data['child_dob_1'], $dateFormat) : '',
						),
						'Child2' => array(
							'Child2-gender' => $isFamily ? $data['select_child_2'] : '',
							'Child2-dob' => $isFamily ? self::getTimeFromString($data['child_dob_2'], $dateFormat) : '',
						),
						'Child3' => array(
							'Child3-gender' => $isFamily ? $data['select_child_3'] : '',
							'Child3-dob' => $isFamily ? self::getTimeFromString($data['child_dob_3'], $dateFormat) : '',
						),
						'Child4' => array(
							'Child4-gender' => $isFamily ? $data['select_child_4'] : '',
							'Child4-dob' => $isFamily ? self::getTimeFromString($data['child_dob_4'], $dateFormat) : '',
						),
						'Child5' => array(
							'Child5-gender' => $isFamily ? $data['select_child_5'] : '',
							'Child5-dob' => $isFamily ? self::getTimeFromString($data['child_dob_5'], $dateFormat) : '',
						),
						'Child6' => array(
							'Child6-gender' => $isFamily ? $data['select_child_6'] : '',
							'Child6-dob' => $isFamily ? self::getTimeFromString($data['child_dob_6'], $dateFormat) : '',
						),
						'Family-subform' => array(
							'Family-subform-A' => array(
								'Family-prev-accom-YN' => '',
							),
							'Family-subform-B' => array(
								'Family-prev-accom-ended' => '',
								'Family-prev-accom-started' => '',
								'Family-prev-accom-details' => '',
							),
							'Family-subform-C' => array(
								'Family-first-pref' => $isFamily ? $data['acc_prefer_1'] : '',
								'Family-second-pref' => $isFamily ? $data['acc_prefer_2'] : '',
								'Family-third-pref' => $isFamily ? $data['acc_prefer_3'] : '',
								'Family-fourth-pref' => $isFamily ? $data['acc_prefer_4'] : '',
								'Family-accepted' => $isFamily ? self::getTimeFromString($data['tenancy_accept'], $dateFormat) : '',
							),
  					),
  				),
					'Section3' => array(
						'App1previousacc' => array(
							'Joint1-subform-A' => array(
								'Joint1-prev-accom-YN' => '',
							),
							'Joint1-subform-B' => array(
								'Joint1-prev-accom-ended' => '',
								'Joint1-prev-accom-started' => '',
								'Joint1-prev-accom-details' => '',
							),
  					),
						'Applicant2' => array(
							'Applicant2-surname' => $isJoint ? $data['partner_lastname'] : '',
							'Applicant2-first-name' => $isJoint ? $data['partner_firstname'] : '',
							'Applicant2-title' => $isJoint ? $data['partner_title'] : '',
							'Applicant2-maiden-name' => $isJoint ? $data['partner_maiden_name'] : '',
							'Telephone2' => $isJoint ? $data['partner_contact_no'] : '',
							'Supervisor2' => $isJoint ? $data['partner_supervisor'] : '',
							'Subject2' => $isJoint ? $data['partner_subject'] : '',
							'Degree2' => $isJoint ? $data['partner_degree'] : '',
							'College2' => $isJoint ? $data['partner_college'] : '',
							'Email2' => $isJoint ? $data['partner_preferred_email'] : '',
							'Nationality2' => $isJoint ? $data['partner_nationality'] : '',
							'OSSNumber2' => $isJoint ? $data['partner_oss_number'] : '',
							'Degree-start-date2' => $isJoint ? self::getTimeFromString($data['partner_degree_start'], $dateFormat) : '',
							'End-term2' => $isJoint ? $data['partner_term'] : '',
							'End-year2' => $isJoint ? $data['partner_term_year'] : '',
							'Applicant2-other' => $isJoint ? $data['partner_title_other'] : '',
							'Degree-other2' => $isJoint ? $data['partner_degree_other'] : '',
							'Jointrelationship' => $isJoint ? $data['partner_relationship'] : '',
						),
						'App2previousacc' => array(
							'Joint2-subform-A' => array(
								'Joint2-prev-accom-YN' => '',
							),
							'Joint2-subform-B' => array(
								'Joint2-prev-accom-ended' => '',
								'Joint2-prev-accom-started' => '',
								'Joint2-prev-accom-details' => '',
							),
						),
						'Jointnumchildren' => array(
							'JointNum-children' => $isJoint ? $data['noofchildren'] : '',
						),
						'Jointchild1' => array(
							'Child1-gender' => $isJoint ? $data['select_child_1'] : '',
							'Child1-dob' => $isJoint ? self::getTimeFromString($data['child_dob_1'], $dateFormat) : '',
						),
						'Jointchild2' => array(
							'Child2-gender' => $isJoint ? $data['select_child_2'] : '',
							'Child2-dob' => $isJoint ? self::getTimeFromString($data['child_dob_2'], $dateFormat) : '',
						),
						'Jointchild3' => array(
							'Child3-gender' => $isJoint ? $data['select_child_3'] : '',
							'Child3-dob' => $isJoint ? self::getTimeFromString($data['child_dob_3'], $dateFormat) : '',
						),
						'Jointchild4' => array(
							'Child4-gender' => $isJoint ? $data['select_child_4'] : '',
							'Child4-dob' => $isJoint ? self::getTimeFromString($data['child_dob_4'], $dateFormat) : '',
						),
						'Jointchild5' => array(
							'Child5-gender' => $isJoint ? $data['select_child_5'] : '',
							'Child5-dob' => $isJoint ? self::getTimeFromString($data['child_dob_5'], $dateFormat) : '',
						),
						'Jointchild6' => array(
							'Child6-gender' => $isJoint ? $data['select_child_6'] : '',
							'Child6-dob' => $isJoint ? self::getTimeFromString($data['child_dob_6'], $dateFormat) : '',
						),
						'Jointpreferences' => array(
							'Joint-first-pref' => $isJoint ? $data['acc_prefer_1'] : '',
							'Joint-second-pref' => $isJoint ? $data['acc_prefer_2'] : '',
							'Joint-third-pref' => $isJoint ? $data['acc_prefer_3'] : '',
							'Joint-fourth-pref' => $isJoint ? $data['acc_prefer_4'] : '',
							'Joint-accepted' => $isJoint ? self::getTimeFromString($data['tenancy_accept'], $dateFormat) : '',
						),
					),
					'Section4' => array(
						'Single-subform' => array(
							'Single-subform-A' => array(
								'Single-prev-accom-YN' => '',
							),
							'Single-subform-B' => array(
								'Single-prev-accom-ended' => '',
								'Single-prev-accom-started' => '',
								'Single-prev-accom-details' => '',
							),
							'Single-subform-C' => array(
								'Single-first-pref' => $isSingle ? $data['acc_prefer_1'] : '',
								'Single-second-pref' => $isSingle ? $data['acc_prefer_2'] : '',
								'Single-third-pref' => $isSingle ? $data['acc_prefer_3'] : '',
								'Single-fourth-pref' => $isSingle ? $data['acc_prefer_4'] : '',
								'Single-accepted' => $isSingle ? self::getTimeFromString($data['tenancy_accept'], $dateFormat) : '',
							),
						),
					),
				),
			),
		);
    $xmlObject = Xml::fromArray($xmlArray);
    $xmlString = $xmlObject->asXML();
    return $xmlString;
	}

	function getTimeFromString($date_string,$format) {
	  if (empty($date_string)) return '';
	  $date_string = str_replace('-','/',$date_string);
    $dateobj = Date::createFromFormat('d/m/Y', $date_string);
    return $dateobj->format($format);
	}

	function getExampleXML($filename) {
		static $example;
		if (is_array($example)) return $example;
		try {
			$xml = Xml::build(ROOT . '/includes/' . $filename);
		} catch (Cake\Utility\Exception\XmlException $e) {
			throw new InternalErrorException();
		}
		$example = Xml::toArray($xml);
		return $example;
	}

}
