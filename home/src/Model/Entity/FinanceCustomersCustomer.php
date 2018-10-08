<?php
// src/Model/Entity/FinanceCustomersCustomer.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class FinanceCustomersCustomer extends Entity
{

  public static function spacer() {
    return '<div class="spacer">&nbsp;</div>';
  }

  public static function yesNoOptions($yes='Y',$no='N') {
    return [ $yes => 'Yes', $no => 'No' ];
  }

  public static function categoryOptions() {
    return [ 'O'=>'Organization', 'P'=>'Person' ];
  }

  public static function accounttypeOptions() {
    return [ 'N'=>'New Account', 'A'=>'Additional Site', 'E'=>'Amendment to Existing Site' ];
  }

  public static function custtypeOptions() {
    return [ 'U'=>'UK Commercial', 'F'=>'Foreign Commercial', 'E'=>'Employee', 'S'=>'Student' ];
  }

  public static function paytermsOptions() {
    return [ 'I'=>'Immediate', 'D'=>'30 Days', 'O'=>'Other' ];
  }

}