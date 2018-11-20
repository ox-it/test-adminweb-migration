<?php
// src/Controller/SafetyController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class SafetyController extends AppController
{

	public function index()
	{
	  // Respond to GET parameters
  	$course = $this->request->getQuery('course');
  	if (!empty($course)) return $this->course($course);
  	$book = $this->request->getQuery('book');
  	if (!empty($book)) return $this->book($book);
  	$action = $this->request->getQuery('action');
  	if (!empty($action) && $action=='cancel') return $this->cancel();

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
			$this->Flash->error(__('Unable to process your application. Please check the form for errors.'));
		}
		$this->set('applicant', $applicant);
		$this->render('book');
	}

	public function cancel()
	{
		$this->loadModel('SafetyEvents');
		$events = $this->SafetyEvents->cancellableEvents();
		$this->set('events', $events);

		$this->loadModel('SafetyApplicants');
		$applicant = $this->SafetyApplicants->newEntity();
		if ($this->request->is('post')) {
			$applicant = $this->SafetyApplicants->patchEntity($applicant, $this->request->getData(), ['validate'=>'cancel']);
			$eventID = $applicant->eventID;
			if (!empty($eventID)) {
				$event = $this->SafetyEvents->getByID($eventID);
				$this->set('event', $event);
				if (!empty($event->courseID)) {
					$this->loadModel('SafetyCourses');
					$course = $this->SafetyCourses->get($event->courseID);
					$this->set(compact('course'));
				}
			}
			$applicant->statuscode = 'X';
			if ($this->SafetyApplicants->save($applicant)) {
				$this->Flash->success(__('Your cancellation has been logged.'));
				//return $this->redirect(['action' => 'cancelled', $applicant->applicantID]);
    		$this->set('applicant', $applicant);
				return $this->render('cancelled');
			}
			$this->Flash->error(__('Unable to process your cancellation. Please check the form for errors.'));
		}
		$this->set('applicant', $applicant);
		$this->render('cancel');
	}

}