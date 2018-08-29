<?php
// src/Model/Table/HarassmentSurveysTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class HarassmentSurveysTable extends Table
{

  private $airclassOptions = [ 'E'=>'Economy', 'B'=>'Business' ];
  private $trainclassOptions = [ '2'=>'Standard', '1'=>'1st Class' ];
  private $yesnoOptions = [ 'Y'=>'Yes', 'N'=>'No' ];

	public static function defaultConnectionName() {
		return 'harassment-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('harassment_survey');
		$this->setPrimaryKey('surveyID');
		$this->hasOne('HarassmentUsers') ->setForeignKey('userID') ->setBindingKey('personID');
		$this->hasOne('HarassmentDepartments') ->setForeignKey('deptcode') ->setBindingKey('deptcode');
	}

	public function getByID($surveyID = null) {
		$query = $this->find('all') ->where(['surveyID'=>$surveyID]) -> contain(['HarassmentUsers','HarassmentDepartments']);
    $survey = $query->first();
		return $survey;
	}

	public function getByDeptAndYear($deptcode, $acyear) {
		$query = $this->find('all') ->where(['HarassmentDepartments.deptcode'=>$deptcode,'year'=>$acyear]) -> contain(['HarassmentUsers','HarassmentDepartments']);
    $survey = $query->first();
		return $survey;
	}

	public function getByDept($deptcode) {
		$query = $this->find('all') ->where(['HarassmentDepartments.deptcode'=>$deptcode]) ->order(['year'=>'ASC']) -> contain(['HarassmentUsers','HarassmentDepartments']);
    $surveys = $query->all();
		return $surveys;
	}

	public function validationReport($validator) {
    $validator ->notEmpty(['official_role','12inqdeptcode','same_dept','eoo_satisfaction']);

		// Conditional validation
		$validator->notEmpty('22fadviceotherdetails', null, function ($context) { return (!empty($context['data']['22fadviceother']) && $context['data']['22fadviceother']=='1'); });
		$validator->notEmpty('3hotherdetails', null, function ($context) { return (!empty($context['data']['3hother']) && $context['data']['3hother']=='1'); });
		$validator->notEmpty('4gotherdetails', null, function ($context) { return (!empty($context['data']['4gother']) && $context['data']['4gother']=='1'); });

		$validator->notEmpty('grievance', null, function ($context) { return (!empty($context['data']['62agrievance']) && $context['data']['62agrievance']=='1'); });
		$validator->notEmpty('62bdisciplinaryaction', null, function ($context) { return (!empty($context['data']['62bdisciplinary']) && $context['data']['62bdisciplinary']=='1'); });
		$validator->notEmpty('62cformalotherdetails', null, function ($context) { return (!empty($context['data']['62cformalother']) && $context['data']['62cformalother']=='1'); });
		$validator->notEmpty('72fotherdetails', null, function ($context) { return (!empty($context['data']['72eother']) && $context['data']['72eother']=='1'); });
		$validator->notEmpty('81bapproachthirddetails', null, function ($context) { return (!empty($context['data']['81bapproachthird']) && $context['data']['81bapproachthird']=='1'); });
		$validator->notEmpty('81cotheractiondetails', null, function ($context) { return (!empty($context['data']['81cotheraction']) && $context['data']['81cotheraction']=='1'); });
		$validator->notEmpty('82creferreddetails', null, function ($context) { return (!empty($context['data']['82creferred']) && $context['data']['82creferred']=='1'); });

		return $validator;
	}

	public function beforeSave($event, $entity, $options) {
		if ($entity->isNew()) {

			$entity->{'1adeptadviser'} = ($entity->official_role == '1adeptadviser') ? 'Y' : 'N';
			$entity->{'1edeptadmin'} = ($entity->official_role == '1edeptadmin') ? 'Y' : 'N';

			$entity->{'52samedept'} = ($entity->same_dept == '52y') ? 1 : 0;
			$entity->{'52samedeptno'} = ($entity->same_dept == '52n') ? 1 : 0;
			$entity->{'52samedeptunknown'} = ($entity->same_dept == '52u') ? 1 : 0;

			$entity->{'62aupheld'} = ($entity->grievance == '62au') ? 1 : 0;
			$entity->{'62anotupheld'} = ($entity->grievance == '62an') ? 1 : 0;

			$entity->{'73yessatisfaction'} = ($entity->matter_resolved == '73y') ? 1 : 0;
			$entity->{'73nosatisfaction'} = ($entity->matter_resolved == '73n') ? 1 : 0;
			$entity->{'73notknown'} = ($entity->matter_resolved == '73u') ? 1 : 0;

			$entity->{'9yessatisfiedeo'} = ($entity->eoo_satisfaction == '91y') ? 1 : 0;
			$entity->{'9notsatisfiedeo'} = ($entity->eoo_satisfaction == '91n') ? 1 : 0;

			$entity->webdate = date('d/m/Y');
			$entity->webdatesort = date('Y/m/d');
			$entity->webtime = date('H:i');

		}
	}

}