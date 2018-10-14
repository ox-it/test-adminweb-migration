<?php
// src/Model/Entity/OrientationApplicant.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class OrientationApplicant extends Entity
{

  public static function spacer() {
    return '<div class="spacer">&nbsp;</div>';
  }

  public static function yesNoOptions($yes='Y',$no='N') {
    return [ $yes => 'Yes', $no => 'No' ];
  }

  public static function coursetypeOptions() {
    return [ 'P'=>'Graduate Degree', 'U'=>'Undergraduate Degree / Second BA' ];
  }

  public static function dateformat_notes() {
    return '<div class="notes">In the format Day/Month/Year (dd/mm/yyyy)</div>';
  }

  public static function timeformat_notes() {
    return '<div class="notes">(24 hour clock hh:mm)</div>';
  }

  public static function all_degrees() {
    $all = array_merge(self::pg_degrees(), self::ug_degrees());
    sort($all);
    return $all;
  }

  public static function pg_degrees() {
    return [
      'BCL' => 'B.C.L.',
			'BPHIL' => 'B.Phil.',
			'DCLINPSYCH' => 'D.Clin.Psych.',
			'DPHIL' => 'D.Phil.',
			'MJUR' => 'M.Juris.',
			'MLITT' => 'M.Litt.',
			'MPHIL' => 'M.Phil.',
			'MPP' => 'M.Pub.Pol.',
			'MSC_RES' => 'M.Sc. (Research)',
			'MSC' => 'M.Sc. (Taught)',
			'MST' => 'M.St.',
			'MTH' => 'M.Th.',
			'PGCE' => 'PGCE',
			'PGCERT' => 'Certificate (Graduate)',
			'PGDIP' => 'Diploma (Graduate)',
			'ERASP' => 'Erasmus (Graduate)',
			'RS' => 'Recognised Student',
			'VSP' => 'Visiting Student (Graduate)'
    ];
  }

  public static function ug_degrees() {
    return [
      'BA' => 'B.A.',
			'BFA' => 'B.F.A',
			'BTH' => 'B.Th.',
			'MBIOCHEM' => 'M.Biochem.',
			'MCHEM' => 'M.Chem.',
			'MENG' => 'M.Eng.',
			'MMATH' => 'M.Math.',
			'MPHYS' => 'M.Phys.',
			'MPHYSPHIL' => 'M.Phys.Phil.',
			'UGCERT' => 'Certificate (Undergraduate)',
			'UGDIP' => 'Diploma (Undergraduate)',
			'ERASU' => 'Erasmus (Undergraduate)',
			'RS' => 'Recognised Student',
			'VSU' => 'Visiting Student (Undergraduate)'
    ];
  }

}