<?php
// src/Model/Behavior/WafBehavior.php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;

class WafBehavior extends Behavior {

    // Date validation
    public function validateDateFormat($date, $context, $regex="/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $format='d/m/Y') {
				$m = [];
				preg_match($regex, $date, $m);
				if (empty($m) || count($m)!=4 || strlen($m[1])!=2 || strlen($m[2])!=2 || strlen($m[3])!=4) return false;
				$t = mktime (0,0,0,$m[2],$m[1],$m[3]);
				return ($date === date($format, $t));
    }

}