<!-- File: src/Template/FinanceTravel/confirm.ctp -->

<div class="row">
	<div class="waf-include">

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

    <?php if (!empty($applicant->air) && $applicant->air=='Y') : ?>
    	<h3>Air Travel</h3>
    	<?= $waf->postValueWithLabel($applicant->airportout, 'Outbound from') ?>
    	<?= $waf->postValueWithLabel($applicant->airportback, 'Destination') ?>
    	<?= $waf->postValueWithLabel($applicant->airdeparting, 'Departing') ?>
    	<?= $waf->postValueWithLabel($applicant->airdirectverbose, 'Direct flight needed?') ?>
    	<?= $waf->postValueWithLabel($applicant->airreturnverbose, 'Return flight?') ?>
    	<?= $waf->postValueWithLabel($applicant->airreturning, 'Returning') ?>
    	<?= $waf->postValueWithLabel($applicant->destaddress, 'Other information') ?>
    	<?= $waf->postValueWithLabel($applicant->airline, 'Preferred airline') ?>
    	<?= $waf->postValueWithLabel($applicant->airclassverbose, 'Travel class') ?>
    <?php endif; ?>

    <?php if (!empty($applicant->train) && $applicant->train=='Y') : ?>
    	<h3>Train Journey</h3>
    	<?= $waf->postValueWithLabel($applicant->stationout, 'Outbound from') ?>
    	<?= $waf->postValueWithLabel($applicant->stationback, 'Destination') ?>
    	<?= $waf->postValueWithLabel($applicant->traindeparting, 'Departing') ?>
    	<?= $waf->postValueWithLabel($applicant->trainreturning, 'Returning') ?>
    	<?= $waf->postValueWithLabel($applicant->trainclassverbose, 'Travel class') ?>
    <?php endif; ?>

    <?php if (!empty($applicant->car) && $applicant->car=='Y') : ?>
    	<h3>Overseas Hire Car</h3>
    	<?= $waf->postValueWithLabel($applicant->carpickup, 'Pick-up location') ?>
    	<?= $waf->postValueWithLabel($applicant->cardatestart, 'Start date') ?>
    	<?= $waf->postValueWithLabel($applicant->cardropoff, 'Drop-off point') ?>
    	<?= $waf->postValueWithLabel($applicant->cardateend, 'Return date') ?>
    <?php endif; ?>

    <?php if (!empty($applicant->hotel) && $applicant->hotel=='Y') : ?>
    	<h3>Hotel</h3>
    	<?= $waf->postValueWithLabel($applicant->hotellocation, 'Location') ?>
    	<?= $waf->postValueWithLabel($applicant->hoteldatestart, 'Arrival date') ?>
    	<?= $waf->postValueWithLabel($applicant->hoteldateend, 'Departure date') ?>
    	<?= $waf->postValueWithLabel($applicant->hoteladditional, 'Additional Details') ?>
    <?php endif; ?>

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