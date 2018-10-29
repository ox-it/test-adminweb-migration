<?php
/*\
 * Called from src/Controller/FinanceTravelController.php
 * Receives $applicant, $agents, $waf
 */
?>

<p>Can you please supply an estimate for the cost the following journey:</p>
<p>&nbsp;</p>


<h4>Contact Details</h4>
<?php
	echo $waf->postValueWithLabel($applicant->title, 'Title');
	echo $waf->postValueWithLabel($applicant->forename, 'Forename');
	echo $waf->postValueWithLabel($applicant->surname, 'Surname');
	echo $waf->postValueWithLabel(!empty($applicant->reqemail) ? $applicant->reqemail : $applicant->email, 'Email');
	echo $waf->postValueWithLabel(!empty($applicant->reqphone) ? $applicant->reqphone : $applicant->phone, 'Telephone');
?>
<p>&nbsp;</p>

<?php
  // Air Travel
	if ($applicant->air == 'Y') :
		echo '<h4>Air Travel</h4>' . "\n";
		echo $waf->postValueWithLabel($applicant->airclass, 'Class', $applicant->airclassOptions());
		echo $waf->postValueWithLabel($applicant->airdirect, 'Direct', $applicant->yesNoOptions());
		echo $waf->postValueWithLabel($applicant->airportout, 'From');
		echo $waf->postValueWithLabel($applicant->airportback, 'To');
		echo $waf->postValueWithLabel($applicant->airdateout . (!empty($applicant->airtimeout) ? ' at ' . $applicant->airtimeout : ''), 'Departing');
    if ($applicant->airreturn == 'Y') :
  		echo $waf->postValueWithLabel($applicant->airdateback . (!empty($applicant->airtimeback) ? ' at ' . $applicant->airtimeback : ''), 'Returning');
  	endif;
		echo $waf->postValueWithLabel($applicant->airline, 'Preferred airline');
		echo $waf->postValueWithLabel($applicant->destaddress, 'Other Information');
	endif;
?>

<?php
  // Train Travel
	if ($applicant->train == 'Y') :
		echo '<h4>Train Travel</h4>' . "\n";
		echo $waf->postValueWithLabel($applicant->trainclass, 'Class', $applicant->trainclassOptions());
		echo $waf->postValueWithLabel($applicant->stationout, 'From');
		echo $waf->postValueWithLabel($applicant->stationback, 'To');
		echo $waf->postValueWithLabel($applicant->traindateout . (!empty($applicant->traintimeout) ? ' at ' . $applicant->traintimeout : ''), 'Departing');
    if (!empty($applicant->traindateback)) :
  		echo $waf->postValueWithLabel($applicant->traindateback . (!empty($applicant->traintimeback) ? ' at ' . $applicant->traintimeback : ''), 'Returning');
  	endif;
	endif;
?>

<?php
  // Car Hire
	if ($applicant->car == 'Y') :
		echo '<h4>Car Hire</h4>' . "\n";
		echo $waf->postValueWithLabel($applicant->cardatestart, 'From');
		echo $waf->postValueWithLabel($applicant->cardateend, 'To');
		echo $waf->postValueWithLabel($applicant->carpickup, 'Pick-up from');
		echo $waf->postValueWithLabel($applicant->cardropoff, 'Drop off at');
	endif;
?>

<?php
  // Hotel details
	if ($applicant->hotel == 'Y') :
		echo '<h4>Hotel Accommodation</h4>' . "\n";
		echo $waf->postValueWithLabel($applicant->hotellocation, 'Location');
		echo $waf->postValueWithLabel($applicant->hoteldatestart, 'Arriving');
		echo $waf->postValueWithLabel($applicant->hoteldateend, 'Departing');
		echo $waf->postValueWithLabel($applicant->hoteladditional, 'Special Requirements');
	endif;
?>

<p>&nbsp;</p>
<?php
	echo $waf->postValueWithLabel($applicant->additional, 'Additional Information');
?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
