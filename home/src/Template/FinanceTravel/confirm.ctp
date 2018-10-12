<!-- File: src/Template/FinanceTravel/confirm.ctp -->

<div class="row">
	<div class="waf-include">

    <?php echo '<textarea rows="10" style="line-height:1.1em">' . print_r($applicant, true) . '</textarea>'; ?>

		<h3>
		  Thank you!
		</h3>

    <!-- Initial instructions -->
    <p>Thank you for entering your details, a copy of which is shown below.</p>
    <p><strong>Please print this page if you wish to keep a permanent record of your application.</strong></p>

		<h3>Traveller details</h3>
    <?= $waf->postValueWithLabel(trim($applicant->title . ' ' . $applicant->forename . ' ' . $applicant->surname), 'Name') ?>
    <?= $waf->postValueWithLabel($applicant->phone, 'Telephone') ?>
    <?= $waf->postValueWithLabel($applicant->email, 'Email') ?>
    <?= $waf->postValueWithLabel($applicant->department, 'Department') ?>

    <?php if (!empty($applicant->reqphone) || !empty($applicant->reqemail)) : ?>
    	<h4>Contact Details</h4>
    	<?= $waf->postValueWithLabel($applicant->reqphone, 'Telephone') ?>
    	<?= $waf->postValueWithLabel($applicant->reqemail, 'Email') ?>
    <?php endif; ?>

    <?php
      if (!empty($applicant->air) && $applicant->air=='Y') {
    	  echo '<h3>Air Travel</h3>' . "\n";
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
  		}
    ?>

		<?php
			if (!empty($applicant->train) && $applicant->train == 'Y') :
				echo '<h3>Train Travel</h3>' . "\n";
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
			if (!empty($applicant->car) && $applicant->car=='Y') {
				echo '<h3>Car Hire</h3>' . "\n";
				echo $waf->postValueWithLabel($applicant->cardatestart, 'From');
				echo $waf->postValueWithLabel($applicant->cardateend, 'To');
				echo $waf->postValueWithLabel($applicant->carpickup, 'Pick-up from');
				echo $waf->postValueWithLabel($applicant->cardropoff, 'Drop off at');
			}
		?>

		<?php
			if (!empty($applicant->hotel) && $applicant->hotel=='Y') {
				echo '<h3>Hotel Accommodation</h3>' . "\n";
				echo $waf->postValueWithLabel($applicant->hotellocation, 'Location');
				echo $waf->postValueWithLabel($applicant->hoteldatestart, 'Arriving');
				echo $waf->postValueWithLabel($applicant->hoteldateend, 'Departing');
				echo $waf->postValueWithLabel($applicant->hoteladditional, 'Special Requirements');
			}
		?>

    <?php if (!empty($applicant->additional)) : ?>
    	<h3>Additional Information</h3>
    	<?= $waf->postValueWithLabel($applicant->additional, '') ?>
    <?php endif; ?>

    <p>&nbsp;</p>
    <p>
      <?= $this->Html->link('Return to Travel Booking Form', ['action' => 'index'], ['class'=>'button']) ?>
    </p>

	</div>
</div>