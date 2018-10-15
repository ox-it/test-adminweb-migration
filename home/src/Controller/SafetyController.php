<?php
// src/Controller/SafetyController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class SafetyController extends AppController
{

	public static function defaultConnectionName() {
			return 'safety-test';
	}

	public function index()
	{
	  // Respond to GET parameters
  	$course = $this->request->getQuery('course');
  	if (!empty($course)) return $this->course($course);
  	$book = $this->request->getQuery('book');
  	if (!empty($book)) return $this->book($book);

		$this->loadModel('SafetyCourses');
    $courses = $this->SafetyCourses->getAllAlphabetically();
    $this->set(compact('courses'));
	}

	public function course($courseID = null)
	{
		$this->loadModel('SafetyCourses');
		$course = $this->SafetyCourses->getByID($courseID);
		$this->set(compact('course'));

		$this->loadModel('SafetyEvents');
		$events = $this->SafetyEvents->futureEventsForCourseID($courseID);
		$this->set('events', $events);

		$this->render('course');
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
			$applicant = $this->SafetyApplicants->patchEntity($applicant, $this->request->getData(), ['validate'=>'register']);
			$applicant->eventID = $eventID;
			$applicant->statuscode = ($event->waiting) ? 'L' : 'A';
			if ($this->SafetyApplicants->save($applicant)) {
				$this->Flash->success(__('Your application has been saved.'));
				//$this->Flash->success(print_r('APPLICANT: ' . $applicant, true));
				$this->set('applicant', $applicant);
				$this->render('success');
				return;
			}
			$this->Flash->error(__('Unable to process your application.'));
		}
		$this->set('applicant', $applicant);
		$this->render('book');
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


}