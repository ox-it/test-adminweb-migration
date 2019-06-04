<?php
// src/Model/Table/SafetyCoursesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class SafetyCoursesTable extends Table
{

    public static function defaultConnectionName() {
      return 'safety';
    }

    public function initialize(array $config)
    {
        $db_config = $config['connection']->config();
        $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
        $table = $prefix . 'course';
        $this->setTable($table);
        $this->addBehavior('Timestamp');
        $this->setPrimaryKey('courseID');
        $this->hasMany('SafetyEvents')->setForeignKey('eventID');
    }

    public function getAllAlphabetically() {
      $query = $this->find('all', [ 'order' => [ 'SafetyCourses.course' => 'ASC' ] ]);
      $courses = $query->all();
      return $courses;
    }

    public function getByID($courseID = null) {
      //$course = $this->get($courseID);
      $query = $this->find('all', ['conditions' => ['courseID' => $courseID]] );
      $course = $query->first();

      if (!empty($course->description)) {
        // Clean up the any \r \n
        $from = array('\\r', '\\n');
        $to   = array(''   , ''   );
        $course->description = str_replace($from, $to, $course->description);
      }

      return $course;
    }

}