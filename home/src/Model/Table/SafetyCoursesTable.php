<?php
// src/Model/Table/SafetyCoursesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class SafetyCoursesTable extends Table
{

		public static function defaultConnectionName() {
			return 'safety-test';
		}

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->setTable('course');
        $this->setPrimaryKey('courseID');
        $this->hasMany('SafetyEvents')->setForeignKey('eventID');
    }

    public function getAllAlphabetically() {
      $query = $this->find('all', [ 'order' => [ 'SafetyCourses.course' => 'ASC' ] ]);
      $courses = $query->all();
      return $courses;
    }

    public function getByID($courseID = null) {
      $course = $this->get($courseID);

      // Clean up the any \r \n
      $from = array('\\r', '\\n');
      $to   = array(''   , ''   );
      $course->description = str_replace($from, $to, $course->description);

      return $course;
    }

}