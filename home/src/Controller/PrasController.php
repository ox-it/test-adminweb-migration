<?php
// src/Controller/PrasController.php

namespace App\Controller;

use App\Form\PrasForm;
use Cake\Utility\Xml;
use Cake\Utility\Exception\XmlException;

class PrasController extends AppController
{

	// public static function defaultConnectionName() { return 'pras-web-dev-tst'; }

	public function index()
	{
    $pras = new PrasForm();
    $this->set('hierarchy', $pras->getHierarchyArray());
    $this->set('change_type_options', $pras->getChangeTypeOptions());
    //$this->set('entity_type_options', $pras->getEntityTypeOptions());
    //$this->set('division_options', $pras->getDivisionsOptions());
    //$this->set('unit_options', $pras->getUnitsOptions());
    //$this->set('sub_unit_options', $pras->getSubUnitsOptions());
    //$this->set('cost_centre_options', $pras->getCostCentresOptions());
		if ($this->request->is('post')) {
			if ($pras->execute($this->request->getData())) {
				$this->Flash->success('Thank you for your submission.');
			} else {
				$this->Flash->error('There was a problem submitting your form.');
			}
		}
		$this->set('pras', $pras);
	}

  /*
	public function view($courseID = null)
	{
			$this->loadModel('SafetyCourses');
			$course = $this->SafetyCourses->getByID($courseID);
			$this->set(compact('course'));

			$this->loadModel('SafetyEvents');
      $events = $this->SafetyEvents->futureEventsForCourseID($courseID);
      $this->set('events', $events);
	}

	public function book($eventID = null)
	{
			$this->loadModel('SafetyDepartments');
      $departments = $this->SafetyDepartments->getSelectOptions();
      $this->set('departments', $departments);

			$this->loadModel('SafetyColleges');
      $colleges = $this->SafetyColleges->getSelectOptions();
      $this->set('colleges', $colleges);

			$this->loadModel('SafetyEvents');
      $event = $this->SafetyEvents->getByID($eventID);
      $this->set('event', $event);

      if (!empty($event->courseID)) {
			  $this->loadModel('SafetyCourses');
			  $course = $this->SafetyCourses->get($event->courseID);
			  $this->set(compact('course'));
			}

			$this->loadModel('SafetyApplicants');
			$applicant = $this->SafetyApplicants->newEntity();
      if ($this->request->is('post')) {
        $applicant = $this->SafetyApplicants->patchEntity($applicant, $this->request->getData());
				$applicant->eventID = $eventID;
				$applicant->statuscode = ($event->waiting) ? 'L' : 'A';
				if ($this->SafetyApplicants->save($applicant)) {
					$this->Flash->success(__('Your application has been saved.'));
					return $this->redirect(['action' => 'success', $applicant->applicantID]);
				}
				$this->Flash->error(__('Unable to process your application.'));
			}
			$this->set('applicant', $applicant);
	}

	public function success($applicantID = null)
	{
			$this->loadModel('SafetyApplicants');
      $applicant = $this->SafetyApplicants->getByID($applicantID);
			$this->set(compact('applicant'));

			if (!empty($applicant->eventID)) {
				$this->loadModel('SafetyEvents');
				$event = $this->SafetyEvents->getByID($applicant->eventID);
				$this->set(compact('event'));
			}

      if (!empty($event->courseID)) {
			  $this->loadModel('SafetyCourses');
			  $course = $this->SafetyCourses->get($event->courseID);
			  $this->set(compact('course'));
			}

      if (!empty($applicant->deptcode)) {
				$this->loadModel('SafetyDepartments');
				$department = $this->SafetyDepartments->getByCode($applicant->deptcode);
			  $this->set(compact('department'));
			}

      if (!empty($applicant->collcode)) {
				$this->loadModel('SafetyColleges');
				$college = $this->SafetyColleges->getByCode($applicant->collcode);
			  $this->set(compact('college'));
			}

	}

	public function cancel($eventID = null)
	{
			$this->loadModel('SafetyEvents');
			$events = $this->SafetyEvents->cancellableEvents();
			$this->set('events', $events);

      $this->loadModel('SafetyApplicants');
			$applicant = $this->SafetyApplicants->newEntity();
      if ($this->request->is('post')) {
        $applicant = $this->SafetyApplicants->patchEntity($applicant, $this->request->getData());
				$eventID = $applicant->eventID;
	      if (!empty($eventID)) {
					$event = $this->SafetyEvents->getByID($eventID);
					$this->set('event', $event);
				}
				$applicant->statuscode = 'X';
				if ($this->SafetyApplicants->save($applicant)) {
					$this->Flash->success(__('Your cancellation has been logged.'));
					return $this->redirect(['action' => 'cancelled', $applicant->applicantID]);
				}
				$this->Flash->error(__('Unable to process your cancellation.'));
			}
			$this->set('applicant', $applicant);

	}

	public function cancelled($applicantID = null)
	{
			$this->loadModel('SafetyApplicants');
      $applicant = $this->SafetyApplicants->getByID($applicantID);
			$this->set(compact('applicant'));

			if (!empty($applicant->eventID)) {
				$this->loadModel('SafetyEvents');
				$event = $this->SafetyEvents->getByID($applicant->eventID);
				$this->set(compact('event'));
			}

      if (!empty($event->courseID)) {
			  $this->loadModel('SafetyCourses');
			  $course = $this->SafetyCourses->get($event->courseID);
			  $this->set(compact('course'));
			}

	}
  //*/

}