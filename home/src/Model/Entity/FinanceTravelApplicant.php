<?php
// src/Model/Entity/FinanceTravelApplicant.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class FinanceTravelApplicant extends Entity
{

  public static function spacer() {
    return '<div class="spacer">&nbsp;</div>';
  }

  public static function yesNoOptions($yes='Y',$no='N') {
    return [ $yes => 'Yes', $no => 'No' ];
  }

  public static function airclassOptions() {
    return [ 'E'=>'Economy', 'B'=>'Business' ];
  }

  public static function trainclassOptions() {
    return [ '2'=>'Standard', '1'=>'1st Class' ];
  }

  public static function telephone_notes() {
    return '<div class="notes">(including area code)</div>';
  }

  public static function dateformat_notes() {
    return '<div class="notes">(dd/mm/yyyy)</div>';
  }

  public static function timeformat_notes() {
    return '<div class="notes">(24 hour clock hh:mm)</div>';
  }

}