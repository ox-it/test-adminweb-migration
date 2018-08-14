<!-- File: src/Template/FinanceTravel/confirm.ctp -->

<?php

  function postValueWithLabel($value, $label) {
    if (!empty($value)) echo '
			<p>
				<span class="'.(empty($label)?'':'label').'"><strong>'.$label.(empty($label)?'':':').'</strong></span>
				<span class="value">'.h($value).'</span>
			</p>
';
  }

?>

<div class="row">
	<div class="waf-include">

		<h3>
		  Thank you!
		</h3>

    <!-- Initial instructions -->
    <p>Thank you for entering your details, a copy of which is shown below.</p>
    <p><strong>Please print this page if you wish to keep a permanent record of your application.</strong></p>

		<h3>Traveller details</h3>
    <?= postValueWithLabel($applicant->name, 'Name') ?>
    <?= postValueWithLabel($applicant->phone, 'Telephone') ?>
    <?= postValueWithLabel($applicant->email, 'Email') ?>
    <?= postValueWithLabel($applicant->department, 'Department') ?>

    <?php if (!empty($applicant->reqphone) || !empty($applicant->reqemail)) : ?>
    	<h4>Contact Details</h4>
    	<?= postValueWithLabel($applicant->reqphone, 'Telephone') ?>
    	<?= postValueWithLabel($applicant->reqemail, 'Email') ?>
    <?php endif; ?>

    <?php if (!empty($applicant->air) && $applicant->air=='Y') : ?>
    	<h3>Air Travel</h3>
    	<?= postValueWithLabel($applicant->airportout, 'Outbound from') ?>
    	<?= postValueWithLabel($applicant->airportback, 'Destination') ?>
    	<?= postValueWithLabel($applicant->airdeparting, 'Departing') ?>
    	<?= postValueWithLabel($applicant->airdirectverbose, 'Direct flight needed?') ?>
    	<?= postValueWithLabel($applicant->airreturnverbose, 'Return flight?') ?>
    	<?= postValueWithLabel($applicant->airreturning, 'Returning') ?>
    	<?= postValueWithLabel($applicant->destaddress, 'Other information') ?>
    	<?= postValueWithLabel($applicant->airline, 'Preferred airline') ?>
    	<?= postValueWithLabel($applicant->airclassverbose, 'Travel class') ?>
    <?php endif; ?>

    <?php if (!empty($applicant->train) && $applicant->train=='Y') : ?>
    	<h3>Train Journey</h3>
    	<?= postValueWithLabel($applicant->stationout, 'Outbound from') ?>
    	<?= postValueWithLabel($applicant->stationback, 'Destination') ?>
    	<?= postValueWithLabel($applicant->traindeparting, 'Departing') ?>
    	<?= postValueWithLabel($applicant->trainreturning, 'Returning') ?>
    	<?= postValueWithLabel($applicant->trainclassverbose, 'Travel class') ?>
    <?php endif; ?>

    <?php if (!empty($applicant->car) && $applicant->car=='Y') : ?>
    	<h3>Overseas Hire Car</h3>
    	<?= postValueWithLabel($applicant->carpickup, 'Pick-up location') ?>
    	<?= postValueWithLabel($applicant->cardatestart, 'Start date') ?>
    	<?= postValueWithLabel($applicant->cardropoff, 'Drop-off point') ?>
    	<?= postValueWithLabel($applicant->cardateend, 'Return date') ?>
    <?php endif; ?>

    <?php if (!empty($applicant->hotel) && $applicant->hotel=='Y') : ?>
    	<h3>Hotel</h3>
    	<?= postValueWithLabel($applicant->hotellocation, 'Location') ?>
    	<?= postValueWithLabel($applicant->hoteldatestart, 'Arrival date') ?>
    	<?= postValueWithLabel($applicant->hoteldateend, 'Departure date') ?>
    	<?= postValueWithLabel($applicant->hoteladditional, 'Additional Details') ?>
    <?php endif; ?>

    <?php if (!empty($applicant->additional)) : ?>
    	<h3>Additional Information</h3>
    	<?= postValueWithLabel($applicant->additional, '') ?>
    <?php endif; ?>

    <p>&nbsp;</p>
    <p>
      <?= $this->Html->link('Return to Travel Booking Form', ['action' => 'index'], ['class'=>'button']) ?>
    </p>

	</div>
</div>