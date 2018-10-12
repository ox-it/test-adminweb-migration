<!-- File: src/Template/FinanceTravel/index.ctp -->

<div class="row">

	<h3>
		Online Travel Quote
	</h3>

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
			<?= $this->Form->control('reqphone', [ 'label'=>'Telephone', 'templates'=>$waf->template_wrappers('reqphone',$applicant->telephone_notes()) ]) ?>
			<?= $this->Form->control('reqemail', [ 'label'=>'Email' ]) ?>

			<hr class="line">

			<h4>
        Traveller details (as per passport)
			</h4>
			<?= $this->Form->control('surname', [ 'label'=>'Surname' ]) ?>
			<?= $this->Form->control('forename', [ 'label'=>'First name' ]) ?>
			<?php	$title_notes = '<div class="notes">(Dr, Mr, Ms etc.)</div>'; ?>
			<?= $this->Form->control('title', [ 'label'=>'Title', 'templates'=>$waf->template_wrappers('title',$title_notes) ]) ?>
			<?= $this->Form->control('phone', [ 'label'=>'Contact number', 'templates'=>$waf->template_wrappers('phone',$applicant->telephone_notes()) ]) ?>
			<?= $this->Form->control('email', [ 'label'=>'Email' ]) ?>
			<?= $this->Form->control('deptcode', [ 'type'=>'select', 'options'=>$departments, 'empty'=>'-- Please select --', 'label'=>'Department' ]) ?>

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
			<?= $this->Form->control('air', [ 'type'=>'checkbox', 'label'=>'Air', 'value'=>'Y', 'hiddenField'=>'N', 'checked'=>($applicant->air=='Y') ]) ?>
			<fieldset id="air_wrapper">
				<?= $this->Form->control('airportout', [ 'label'=>'Outbound airport or city', 'templates'=>$waf->template_wrappers('airportout','',['required']) ]) ?>
				<?= $this->Form->control('airportback', [ 'label'=>'Destination airport or city', 'templates'=>$waf->template_wrappers('airportback','',['required']) ]) ?>
				<?= $this->Form->control('airdateout', [ 'label'=>'Departure date', 'templates'=>$waf->template_wrappers('airdateout',$applicant->dateformat_notes(),['required']) ]) ?>
				<?= $this->Form->control('airtimeout', [ 'label'=>'Preferred departure time (if any)', 'templates'=>$waf->template_wrappers('airtimeout',$applicant->timeformat_notes()) ]) ?>
				<?= $this->Form->control('airdirect', [ 'type'=>'radio', 'label'=>'Direct flight needed?', 'options'=>$applicant->yesnoOptions(), 'templates'=>$waf->template_wrappers('airdirect',$applicant->spacer()) ]) ?>
				<?= $this->Form->control('airreturn', [ 'type'=>'radio', 'label'=>'Return flight?', 'options'=>$applicant->yesnoOptions(), 'templates'=>$waf->template_wrappers('airreturn',$applicant->spacer()) ]) ?>
				<div id="air_return_info">
					<?= $this->Form->control('airdateback', [ 'label'=>'Return date', 'templates'=>$waf->template_wrappers('airdateback',$applicant->dateformat_notes()) ]) ?>
					<?= $this->Form->control('airtimeback', [ 'label'=>'Preferred return time (if any)', 'templates'=>$waf->template_wrappers('airtimeback',$applicant->timeformat_notes()) ]) ?>
				</div>
				<?php	$destaddress_notes = '<div class="notes">(e.g. details if multi-leg journey, group booking, destination address if required by visa and no hotel is being booked)</div>'; ?>
				<?= $this->Form->control('destaddress', [ 'type'=>'textarea', 'label'=>'Other information', 'rows'=>'5', 'templates'=>$waf->template_wrappers('destaddress',$destaddress_notes)  ]); ?>
				<?= $this->Form->control('airline', [ 'label'=>'Preferred airline' ]) ?>
				<?= $this->Form->control('airclass', [ 'type'=>'select', 'options'=>$applicant->airclassOptions(), 'label'=>'Travel class', 'default'=>'E' ]) ?>
			</fieldset>

			<hr class="line">

			<!-- Train Travel -->
			<?= $this->Form->control('train', [ 'type'=>'checkbox', 'label'=>'Train', 'value'=>'Y', 'hiddenField'=>'N', 'checked'=>($applicant->train=='Y') ]) ?>
			<fieldset id="train_wrapper">
				<?= $this->Form->control('stationout', [ 'label'=>'Outbound station', 'templates'=>$waf->template_wrappers('stationout','',['required']) ]) ?>
				<?= $this->Form->control('stationback', [ 'label'=>'Destination station', 'templates'=>$waf->template_wrappers('stationback','',['required']) ]) ?>
				<?= $this->Form->control('traindateout', [ 'label'=>'Departure date', 'templates'=>$waf->template_wrappers('traindateout',$applicant->dateformat_notes(),['required']) ]) ?>
				<?= $this->Form->control('traintimeout', [ 'label'=>'Preferred time (if any)', 'templates'=>$waf->template_wrappers('traintimeout',$applicant->timeformat_notes()) ]) ?>
				<?= $this->Form->control('traindateback', [ 'label'=>'Return date', 'templates'=>$waf->template_wrappers('traindateback',$applicant->dateformat_notes()) ]) ?>
				<?= $this->Form->control('traintimeback', [ 'label'=>'Return time (if any)', 'templates'=>$waf->template_wrappers('traintimeback',$applicant->timeformat_notes()) ]) ?>
				<?= $this->Form->control('trainclass', [ 'type'=>'select', 'options'=>$applicant->trainclassOptions(), 'label'=>'Travel class', 'default'=>'2' ]) ?>
			</fieldset>

			<hr class="line">

			<!-- Car Hire -->
			<?= $this->Form->control('car', [ 'type'=>'checkbox', 'label'=>'Overseas car hire', 'value'=>'Y', 'hiddenField'=>'N' ], [ 'val'=>$applicant->car ]) ?>
			<fieldset id="car_wrapper">
				<?= $this->Form->control('carpickup', [ 'label'=>'Pick-up location', 'templates'=>$waf->template_wrappers('carpickup','',['required']) ]) ?>
				<?= $this->Form->control('cardatestart', [ 'label'=>'Start date', 'templates'=>$waf->template_wrappers('cardatestart',$applicant->dateformat_notes(),['required']) ]) ?>
				<?= $this->Form->control('cardropoff', [ 'label'=>'Drop-off point', 'templates'=>$waf->template_wrappers('cardropoff','',['required']) ]) ?>
				<?= $this->Form->control('cardateend', [ 'label'=>'Return date', 'templates'=>$waf->template_wrappers('cardateend',$applicant->dateformat_notes(),['required']) ]) ?>
			</fieldset>

			<hr class="line">


			<!-- Accommodation  -->
			<h4>
				Accommodation
			</h4>
			<?= $this->Form->control('hotel', [ 'type'=>'checkbox', 'label'=>'Hotel required', 'value'=>'Y', 'hiddenField'=>'N' ]) ?>
			<fieldset id="hotel_wrapper">
				<?= $this->Form->control('hotellocation', [ 'label'=>'Location', 'templates'=>$waf->template_wrappers('hotellocation','<div class="notes">(City/Town)</div>',['required']) ]) ?>
				<?= $this->Form->control('hoteldatestart', [ 'label'=>'Arrival date', 'templates'=>$waf->template_wrappers('hoteldatestart',$applicant->dateformat_notes(),['required']) ]) ?>
				<?= $this->Form->control('hoteldateend', [ 'label'=>'Departure date', 'templates'=>$waf->template_wrappers('hoteldateend',$applicant->dateformat_notes(),['required']) ]) ?>
				<?= $this->Form->control('hoteladditional', [ 'type'=>'textarea', 'label'=>'Additional Details', 'rows'=>'4' ]); ?>
      </fieldset>

			<!-- Additional  -->
			<h4>
				Any additional information
			</h4>
      <?= $this->Form->control('additional', [ 'type'=>'textarea', 'label'=>false, 'rows'=>'4' ]); ?>

			<!-- Submit -->
			<?php
					echo $this->Form->button(__('Submit Request'));
					echo $this->Form->button('Clear From', [ 'type'=>'reset' ]);
			?>

			<!-- Travel Agent information -->
      <a name="agents"></a>
      <p>&nbsp;</p>
      <p>
        When you press Submit Request, these details will be sent to our regular travel agent<?= (count($agents)>1 ? 's' : ''); ?>:</a>
      <p>
      <ul>
				<?php
					$compound_email = '';
					foreach ($agents as $i=>$agent) {
						echo '<li><a href="mailto:'.$agent->agentemail.'">'.$agent->agentname.'</a>';
						echo ' (Tel: '.$agent->agentphone.')</li>' . "\n";
						// Add the address to compound string
						$compound_email .= ($i==0 ? '' : ';') . $agent->agentemail;
					}
				?>
      </ul>
      <p>
        If you have urgent or complex requirements, and wish to contact them directly,
        you can <a href="mailto:<?= $compound_email ?>">send an email to the above
        agent<?= (count($agents)>1 ? 's' : '') ?></a>.
      </p>


		<?php
				echo $this->Form->end();
		?>

	</div>
</div>