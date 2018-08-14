<!-- File: src/Template/FinanceTravel/index.ctp -->

<?php
  $spacer = '<div class="spacer">&nbsp;</div>';
  $airclassOptions = [ 'E'=>'Economy', 'B'=>'Business' ];
  $trainclassOptions = [ '2'=>'Standard', '1'=>'1st Class' ];
  $yesnoOptions = [ 'Y'=>'Yes', 'N'=>'No' ];
	$dateformat_notes = '<div class="notes">(dd/mm/yyyy)</div>';
	$timeformat_notes = '<div class="notes">(24 hour clock hh:mm)</div>';

  function template_wrappers($field, $notes='', $classes=[]) {
    return [
			'inputContainer'=>'<div id="'.$field.'_wrapper" class="input {{type}}{{required}} '.implode(' ',$classes).'">{{content}}'.$notes.'</div>',
			'inputContainerError'=>'<div id="'.$field.'_wrapper" class="input {{type}}{{required}} '.implode(' ',$classes).' error">{{content}}{{error}}'.$notes.'</div>'
    ];
  }
?>

<div class="row">

	<h3>
		Online Travel Quote
	</h3>

	<?= $this->Html->script($this->name . '/script.js') ?>

	<div class="waf-include">

    <!-- Information -->
	  <p>
	    This is an online request for quotation form that will be sent to the University's preferred travel agent who will
	    send you a quotation by email for the requested journey. If you wish to travel within the next 24 hours you are
	    advised to contact the <a href="#agents">travel agent</a> directly.
	  </p>
    <p>
      <strong>Note:</strong> Please be advised that you will have to register for
      <a href="http://www.admin.ox.ac.uk/finance/insurance/travel.shtml">travel insurance</a>
			<strong>before</strong> you depart, otherwise you will <strong>not</strong> be
			insured by the University.
		</p>
	  <p>
	    When you have received the email quotes you will need to accept the
	    quote directly with that travel agent by requesting to HOLD the chosen itinerary whilst a purchase order is raised.
	    The purchase order description should include the 6 character booking reference shown on the itinerary email.
	  </p>
	  <p>
	    If your journey involves multiple stages, please <a href="#agents">contact the travel agent directly</a>.
    </p>


    <!-- Form --><?php // Create form with validation set in FinanceTravelApplicantsTable::validationRegister() ?>
		<?= $this->Form->create($applicant, [ 'type'=>'file', 'context'=>[ 'validator'=>'register' ], 'novalidate' => true ]) ?>

			<h4>
				Your contact details (if you are not the traveller)
			</h4>
			<?php	$reqphone_notes = '<div class="notes">(including area code)</div>'; ?>
			<?= $this->Form->control('reqphone', [ 'label'=>'Telephone', 'default'=>$applicant->reqphone, 'class'=>'with-notes', 'templates'=>template_wrappers('reqphone',$reqphone_notes) ]) ?>
			<?= $this->Form->control('reqemail', [ 'label'=>'Email', 'default'=>$applicant->reqemail]) ?>

			<hr class="line">

			<h4>
        Traveller details (as per passport)
			</h4>
			<?= $this->Form->control('surname', [ 'label'=>'Surname', 'default'=>$applicant->surname ]) ?>
			<?= $this->Form->control('forename', [ 'label'=>'First name', 'default'=>$applicant->forename ]) ?>
			<?php	$title_notes = '<div class="notes">(Dr, Mr, Ms etc.)</div>'; ?>
			<?= $this->Form->control('title', [ 'label'=>'Title', 'default'=>$applicant->title, 'class'=>'with-notes', 'templates'=>template_wrappers('title',$title_notes) ]) ?>
			<?php	$phone_notes = '<div class="notes">(including area code)</div>'; ?>
			<?= $this->Form->control('phone', [ 'label'=>'Contact number', 'default'=>$applicant->phone, 'class'=>'with-notes', 'templates'=>template_wrappers('phone',$phone_notes) ]) ?>
			<?= $this->Form->control('email', [ 'label'=>'Email', 'default'=>$applicant->email ]) ?>
			<?= $this->Form->input('deptcode', [ 'type'=>'select', 'options'=>$departments, 'empty'=>'-- Please select --', 'label'=>'Department' ], [ 'val'=>$applicant->deptcode ]) ?>

			<hr class="line">

			<h4>
				Journey details
			</h4>
			<p>
			  Please indicate which method(s) of travel you will be using and fill in the
			  additional details for those methods (compulsory fields marked with a *):
      </p>

			<hr class="line">

			<!-- Air Travel -->
			<?= $this->Form->input('air', [ 'type'=>'checkbox', 'label'=>'Air', 'value'=>'Y', 'hiddenField'=>'N', 'checked'=>($applicant->air=='Y') ]) ?>
			<fieldset id="air_wrapper">
				<?= $this->Form->control('airportout', [ 'label'=>'Outbound airport or city', 'default'=>$applicant->airportout, 'templates'=>template_wrappers('airportout','',['required']) ]) ?>
				<?= $this->Form->control('airportback', [ 'label'=>'Destination airport or city', 'default'=>$applicant->airportback, 'templates'=>template_wrappers('airportback','',['required']) ]) ?>
				<?= $this->Form->control('airdateout', [ 'label'=>'Departure date', 'default'=>$applicant->airdateout, 'class'=>'with-notes', 'templates'=>template_wrappers('airdateout',$dateformat_notes,['required']) ]) ?>
				<?= $this->Form->control('airtimeout', [ 'label'=>'Preferred departure time (if any)', 'default'=>$applicant->airtimeout, 'class'=>'with-notes', 'templates'=>template_wrappers('airtimeout',$timeformat_notes) ]) ?>
				<?= $this->Form->input('airdirect', [ 'type'=>'radio', 'label'=>'Direct flight needed?', 'options'=>$yesnoOptions, 'class'=>'with-notes', 'templates'=>template_wrappers('airdirect',$spacer) ], [ 'val'=>$applicant->airdirect]) ?>
				<?= $this->Form->input('airreturn', [ 'type'=>'radio', 'label'=>'Return flight?', 'options'=>$yesnoOptions, 'class'=>'with-notes', 'templates'=>template_wrappers('airreturn',$spacer) ], [ 'val'=>$applicant->airreturn]) ?>
				<?= $this->Form->control('airdateback', [ 'label'=>'Return date', 'default'=>$applicant->airdateback, 'class'=>'with-notes', 'templates'=>template_wrappers('airdateback',$dateformat_notes) ]) ?>
				<?= $this->Form->control('airtimeback', [ 'label'=>'Preferred return time (if any)', 'default'=>$applicant->airtimeback, 'class'=>'with-notes', 'templates'=>template_wrappers('airtimeback',$timeformat_notes) ]) ?>
				<?php	$destaddress_notes = '<div class="notes">(e.g. details if multi-leg journey, group booking, destination address if required by visa and no hotel is being booked)</div>'; ?>
				<?= $this->Form->control('destaddress', [ 'type'=>'textarea', 'label'=>'Other information', 'rows'=>'5', 'class'=>'with-notes', 'value'=>$applicant->destaddress, 'templates'=>template_wrappers('destaddress',$destaddress_notes)  ]); ?>
				<?= $this->Form->control('airline', [ 'label'=>'Preferred airline', 'default'=>$applicant->airline ]) ?>
				<?= $this->Form->input('airclass', [ 'type'=>'select', 'options'=>$airclassOptions, 'label'=>'Travel class', 'default'=>'E' ], [ 'val'=>$applicant->airclass]) ?>
			</fieldset>

			<hr class="line">

			<!-- Train Travel -->
			<?= $this->Form->input('train', [ 'type'=>'checkbox', 'label'=>'Train', 'value'=>'Y', 'hiddenField'=>'N', 'checked'=>($applicant->train=='Y') ]) ?>
			<fieldset id="train_wrapper">
				<?= $this->Form->control('stationout', [ 'label'=>'Outbound station', 'default'=>$applicant->stationout, 'templates'=>template_wrappers('stationout','',['required']) ]) ?>
				<?= $this->Form->control('stationback', [ 'label'=>'Destination station', 'default'=>$applicant->stationback, 'templates'=>template_wrappers('stationback','',['required']) ]) ?>
				<?= $this->Form->control('traindateout', [ 'label'=>'Departure date', 'default'=>$applicant->traindateout, 'class'=>'with-notes', 'templates'=>template_wrappers('traindateout',$dateformat_notes,['required']) ]) ?>
				<?= $this->Form->control('traintimeout', [ 'label'=>'Preferred time (if any)', 'default'=>$applicant->traintimeout, 'class'=>'with-notes', 'templates'=>template_wrappers('traintimeout',$timeformat_notes) ]) ?>
				<?= $this->Form->control('traindateback', [ 'label'=>'Return date', 'default'=>$applicant->traindateback, 'class'=>'with-notes', 'templates'=>template_wrappers('traindateback',$dateformat_notes) ]) ?>
				<?= $this->Form->control('traintimeback', [ 'label'=>'Return time (if any)', 'default'=>$applicant->traintimeback, 'class'=>'with-notes', 'templates'=>template_wrappers('traintimeback',$timeformat_notes) ]) ?>
				<?= $this->Form->input('trainclass', [ 'type'=>'select', 'options'=>$trainclassOptions, 'label'=>'Travel class', 'default'=>'2' ], [ 'val'=>$applicant->trainclass]) ?>
			</fieldset>

			<hr class="line">

			<!-- Car Hire -->
			<?= $this->Form->input('car', [ 'type'=>'checkbox', 'label'=>'Overseas car hire', 'value'=>'Y', 'hiddenField'=>'N' ], [ 'val'=>$applicant->car ]) ?>
			<fieldset id="car_wrapper">
				<?= $this->Form->control('carpickup', [ 'label'=>'Pick-up location', 'default'=>$applicant->carpickup, 'templates'=>template_wrappers('carpickup','',['required']) ]) ?>
				<?= $this->Form->control('cardatestart', [ 'label'=>'Start date', 'default'=>$applicant->cardatestart, 'class'=>'with-notes', 'templates'=>template_wrappers('cardatestart',$dateformat_notes,['required']) ]) ?>
				<?= $this->Form->control('cardropoff', [ 'label'=>'Drop-off point', 'default'=>$applicant->cardropoff, 'templates'=>template_wrappers('cardropoff','',['required']) ]) ?>
				<?= $this->Form->control('cardateend', [ 'label'=>'Return date', 'default'=>$applicant->cardateend, 'class'=>'with-notes', 'templates'=>template_wrappers('cardateend',$dateformat_notes,['required']) ]) ?>
			</fieldset>

			<hr class="line">


			<!-- Accommodation  -->
			<h4>
				Accommodation
			</h4>
			<?= $this->Form->input('hotel', [ 'type'=>'checkbox', 'label'=>'Hotel required', 'value'=>'Y', 'hiddenField'=>'N' ], [ 'val'=>$applicant->hotel ]) ?>
			<fieldset id="hotel_wrapper">
				<?php	$hotellocation_notes = '<div class="notes">(City/Town)</div>'; ?>
				<?= $this->Form->control('hotellocation', [ 'label'=>'Location', 'default'=>$applicant->hotellocation, 'templates'=>template_wrappers('hotellocation','',['required']) ]) ?>
				<?= $this->Form->control('hoteldatestart', [ 'label'=>'Arrival date', 'default'=>$applicant->hoteldatestart, 'class'=>'with-notes', 'templates'=>template_wrappers('hoteldatestart',$dateformat_notes,['required']) ]) ?>
				<?= $this->Form->control('hoteldateend', [ 'label'=>'Departure date', 'default'=>$applicant->hoteldateend, 'class'=>'with-notes', 'templates'=>template_wrappers('hoteldateend',$dateformat_notes,['required']) ]) ?>
				<?= $this->Form->control('hoteladditional', [ 'type'=>'textarea', 'label'=>'Additional Details', 'rows'=>'4', 'default'=>$applicant->hoteladditional ]); ?>
      </fieldset>

			<!-- Additional  -->
			<h4>
				Any additional information
			</h4>
      <?= $this->Form->control('additional', [ 'type'=>'textarea', 'label'=>false, 'rows'=>'4', 'default'=>$applicant->additional ]); ?>

			<!-- Submit -->
			<?php
					echo $this->Form->button(__('Submit Request'));
					echo $this->Form->button('Clear From', [ 'type'=>'reset' ]);
			?>

		<?php
				echo $this->Form->end();
		?>

	</div>
</div>