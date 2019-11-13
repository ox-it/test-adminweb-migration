<!-- File: src/Template/GraduateAccommodation/index.ctp -->


<div class="row">

	<?php //if (!empty($form->errors())) echo '<p>ERRORS</p><textarea rows="5" style="font-size:0.6em;line-height:1.1em">' . print_r($form->errors(), true) . '</textarea>'; ?>
	<?php // echo '<textarea rows="5" style="font-size:0.6em;line-height:1.1em">' . print_r($form, true) . '</textarea>'; ?>

  <!-- Title and info moved outside WAF on request -->
	<h3>Accommodation Request Form</h3>
	<p>Data Protection Act 1998: The information contained on this form is processed in accordance with the provisions of the Data Protection Act 1998. The information will be held for the purposes of maintaining a waiting list for those requiring graduate accommodation.</p>
	<p>If you have any problems submitting this application form, please contact us at <a href="mailto:graduate.accommodation@admin.ox.ac.uk">graduate.accommodation@admin.ox.ac.uk</a>.</p>
	<h4>Scope</h4>

	<div class="waf-include">

		<!-- Form -->
		<?=	$this->Form->create($form, [ 'novalidate' => true ]); ?>
		<div class="webform-component form-item form-type-input form-type-select select required">
			<label class="control-label" for="application_type">Select the type of application you wish to make (please note you may only make one application. Any duplicates will be deleted)</label></div>

		<?= // $this->Form->input('application_type', ['type' => 'select', 'options' => $form::applicationOptions(), 'empty' => '-- Please Select --', 'label' => 'Select the type of application you wish to make (please note you may only make one application. Any duplicates will be deleted)']);
			$this->Form->input('application_type', ['type'=>'radio','options' => $form::applicationOptions(), 'label' =>  false, 'div' =>  true]); ?>

			<fieldset id="applicant1">
				<h4>Section <span class="section-number">1</span> - APPLICANT 1 INFORMATION</h4>
				<?php echo $this->Form->control('title', ['type' => 'select', 'options' => $form::titleOptions(), 'empty' => '-- Please Select --', 'label' => 'Title', 'between' => 'Single']); ?>
				<div id="title-other-wrapper">
					<?= $this->Form->control('title_other', ['type'=>'text', 'label' => 'Other - Please specify']); ?>
				</div>
				<?= $this->Form->control('surname', ['type'=>'text', 'label' => 'Surname/Family Name']); ?>
				<?= $this->Form->control('firstname', ['type'=>'text', 'label' => 'First Name']); ?>
				<?= $this->Form->control('othernames', ['type'=>'text', 'label' => 'Maiden Name (if applicable)']); ?>

				<h5>Present Address</h5>
				<?= $this->Form->control('address_line1', ['type'=>'text', 'label' => 'Line 1']); ?>
				<?= $this->Form->control('address_line2', ['type'=>'text', 'label' => 'Line 2']); ?>
				<?= $this->Form->control('address_line3', ['type'=>'text', 'label' => 'Line 3']); ?>
				<?= $this->Form->control('postcode', ['type'=>'text', 'label' => 'Postcode/Zip Code']); ?>
				<?= $this->Form->control('contact_number', ['type'=>'text', 'label' => 'Contact Telephone Number']); ?>
				<?= $this->Form->control('preferred_email', ['type'=>'text', 'label' => 'Preferred Email']); ?>

				<h5>About You</h5>
				<?= $this->Form->control('nationality', ['type'=>'text', 'label' => 'Nationality']); ?>
				<?= $this->Form->control('college', ['type' => 'select', 'options' => $form::collegeOptions(), 'empty' => '-- Please Select --', 'label' => 'College']); ?>
				<?= $this->Form->control('degree', ['type' => 'select', 'options' => $form::degreeOptions(), 'empty' => '-- Please Select --', 'label' => 'Degree']); ?>
				<div id="degree-other-wrapper">
					<?= $this->Form->control('degree_other', ['type' => 'text', 'label' => 'Degree Other - Please specify']); ?>
				</div>
				<?= $this->Form->control('subject', ['type'=>'text', 'label' => 'Subject']); ?>
				<?= $this->Form->control('supervisor', ['type'=>'text', 'label' => 'Supervisor']); ?>
				<?= $this->Form->control('oss_number', ['type'=>'text', 'label' => 'Student Number']); ?>
				<?= $this->Form->control('degree_start', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Start Date of Degree Course (dd/mm/yyyy)']); ?>
				<?= $this->Form->control('term', ['type' => 'select', 'options' => $form::termOptions(), 'empty' => '-- Term --', 'label' => 'Expected Finish Term']); ?>
				<?= $this->Form->control('term_year', ['type' => 'select', 'options' => $form::yearOptions(), 'empty' => '-- Year --', 'label' => 'Expected Finish Year']); ?>
			</fieldset>

			<fieldset id="applicant2">
				<h4>Section <span class="section-number">2</span> - APPLICANT 2 INFORMATION</h4>
				<?= $this->Form->control('partner_title', ['type' => 'select', 'options' => $form::titleOptions(), 'empty' => '-- Please Select --', 'label' => 'Title']); ?>
				<div id="partner-title-other-wrapper">
					<?= $this->Form->control('partner_title_other', ['type'=>'text', 'label' => 'Title - Please specify']); ?>
				</div>
				<?= $this->Form->control('partner_lastname', ['type'=>'text', 'label' => 'Surname/Family Name']); ?>
				<?= $this->Form->control('partner_firstname', ['type'=>'text', 'label' => 'First Name']); ?>
				<?= $this->Form->control('partner_maiden_name', ['type'=>'text', 'label' => 'Maiden Name (if applicable)']); ?>
				<?= $this->Form->control('partner_relationship', ['type'=>'text', 'label' => 'Relationship to Applicant  ']); ?>
				<?= $this->Form->control('partner_nationality', ['type'=>'text', 'label' => 'Nationality']); ?>
				<?= $this->Form->control('partner_preferred_email', ['type'=>'text', 'label' => 'Preferred Email']); ?>
				<?= $this->Form->control('partner_contact_no', ['type'=>'text', 'label' => 'Contact Telephone Number']); ?>
				<?= $this->Form->control('partner_college', ['type' => 'select', 'options' => $form::collegeOptions(), 'empty' => '-- Please Select --', 'label' => 'College']); ?>
				<?= $this->Form->control('partner_degree', ['type' => 'select', 'options' => $form::degreeOptions(), 'empty' => '-- Please Select --', 'label' => 'Degree']); ?>
				<div id="partner-degree-other-wrapper">
					<?= $this->Form->control('partner_degree_other', ['type' => 'text', 'label' => 'Degree Other - Please specify']); ?>
				</div>
				<?= $this->Form->control('partner_subject', ['type'=>'text', 'label' => 'Subject']); ?>
				<?= $this->Form->control('partner_supervisor', ['type'=>'text', 'label' => 'Supervisor']); ?>
				<?= $this->Form->control('partner_oss_number', ['type'=>'text', 'label' => 'Student Number']); ?>
				<?= $this->Form->control('partner_degree_start', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Start Date of Degree Course (dd/mm/yyyy)']); ?>
				<?= $this->Form->control('partner_term', ['type' => 'select', 'options' => $form::termOptions(), 'empty' => '-- Term --', 'label' => 'Expected Finish Term']); ?>
				<?= $this->Form->control('partner_term_year', ['type' => 'select', 'options' => $form::yearOptions(), 'empty' => '-- Year --', 'label' => 'Expected Finish Year']); ?>
    		</fieldset>

			<fieldset id="family">
				<h4>Section <span class="section-number">3</span> - FAMILY INFORMATION</h4>
				<fieldset id="spouse">
					<h5>About Your Spouse/Partner (if applicable)</h5>
					<?= $this->Form->control('spouse_title', ['type' => 'select', 'options' => $form::titleOptions(), 'empty' => '-- Please Select --', 'label' => 'Title']); ?>
					<div id="spouse-title-other-wrapper">
						<?= $this->Form->control('spouse_title_other', ['type'=>'text', 'label' => 'Other - Please specify']); ?>
					</div>
					<?= $this->Form->control('spouse_lastname', ['type'=>'text', 'label' => 'Surname/Family Name']); ?>
					<?= $this->Form->control('spouse_firstname', ['type'=>'text', 'label' => 'First Name']); ?>
					<?= $this->Form->control('spouse_maiden_name', ['type'=>'text', 'label' => 'Maiden Name (if applicable)']); ?>
					<?= $this->Form->control('spouse_relationship', ['type'=>'text', 'label' => 'Relationship to Applicant  ']); ?>
					<?= $this->Form->control('spouse_nationality', ['type'=>'text', 'label' => 'Nationality']); ?>
				</fieldset>
				
				<fieldset id="children">
					<h5>Children (if applicable)</h5>
					<div id="expecting-child">
						<?= $this->Form->control('expecting', ['type' => 'checkbox', 'value' => 'Expecting a child', 'label' => 'Expecting a Child' ]); ?>
						<p class="notes">Please tick this box if you are expecting a child.</p>
					</div>
					<div id="child-1">
						<?= $this->Form->control('select_child_1', ['type' => 'select', 'options' => $form::genderOptions(), 'empty' => '-- Please Select --', 'label' => 'Child 1 Gender']); ?>
						<?= $this->Form->control('child_dob_1', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Date of Birth (dd/mm/yyyy)']); ?>
					</div>
					<div id="child-2">
						<?= $this->Form->control('select_child_2', ['type' => 'select', 'options' => $form::genderOptions(), 'empty' => '-- Please Select --', 'label' => 'Child 2 Gender']); ?>
						<?= $this->Form->control('child_dob_2', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Date of Birth (dd/mm/yyyy)']); ?>
					</div>
					<div id="child-3">
						<?= $this->Form->control('select_child_3', ['type' => 'select', 'options' => $form::genderOptions(), 'empty' => '-- Please Select --', 'label' => 'Child 3 Gender']); ?>
						<?= $this->Form->control('child_dob_3', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Date of Birth (dd/mm/yyyy)']); ?>
					</div>
					<div id="child-4">
						<?= $this->Form->control('select_child_4', ['type' => 'select', 'options' => $form::genderOptions(), 'empty' => '-- Please Select --', 'label' => 'Child 4 Gender']); ?>
						<?= $this->Form->control('child_dob_4', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Date of Birth (dd/mm/yyyy)']); ?>
					</div>
					<div id="child-5">
						<?= $this->Form->control('select_child_5', ['type' => 'select', 'options' => $form::genderOptions(), 'empty' => '-- Please Select --', 'label' => 'Child 5 Gender']); ?>
						<?= $this->Form->control('child_dob_5', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Date of Birth (dd/mm/yyyy)']); ?>
					</div>
					<div id="child-6">
						<?= $this->Form->control('select_child_6', ['type' => 'select', 'options' => $form::genderOptions(), 'empty' => '-- Please Select --', 'label' => 'Child 6 Gender']); ?>
						<?= $this->Form->control('child_dob_6', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Date of Birth (dd/mm/yyyy)']); ?>
					</div>
				</fieldset>
			</fieldset>

			<fieldset id="accommodation">
				<h4>Section <span class="section-number">2</span> - PREFERRED ACCOMMODATION</h4>
				<p>First preference is mandatory, second preference is optional</p>
				<p>Further information about University properties can be viewed on our website at <a href="https://gradaccommodation.admin.ox.ac.uk/accommodation/" target="_blank">https://gradaccommodation.admin.ox.ac.uk/accommodation</a></p>

				<?= $this->Form->control('acc_prefer_1', ['type' => 'select', 'options' => $form::accommodationOptions(), 'empty' => '-- Please Select --', 'label' => 'Accommodation Type']); ?>
				<?= $this->Form->control('acc_prefer_2', ['type' => 'select', 'options' => $form::accommodationOptions(), 'empty' => '-- Please Select --', 'label' => 'First preference']); ?>
				<?= $this->Form->control('acc_prefer_3', ['type' => 'select', 'options' => $form::accommodationOptions(), 'empty' => '-- Please Select --', 'label' => 'Accommodation Type']); ?>
				<?= $this->Form->control('acc_prefer_4', ['type' => 'select', 'options' => $form::accommodationOptions(), 'empty' => '-- Please Select --', 'label' => 'Second preference']); ?>
				<p><strong>Please note that 3-bedroom properties are only for families with more than one child only.</strong></p>
				<p><i>Please note that unfortunately we cannot guarantee that you will receive an offer of accommodation.</i></p>
				<?= $this->Form->control('tenancy_accept', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Date accommodation is required from (dd/mm/yyyy)' ]); ?>
				<p><i>(N.B. Tenancies can only start a maximum of one month before your course commences.)</i></p>
				<?= $this->Form->control('comments', ['type'=>'textarea', 'label' => 'Do you have any specific requirements that we should be aware of?', 'rows' => 2]); ?>
			</fieldset>

			<div id="buttons">
				<?= $this->Form->button('Submit'); ?>
			</div>

		<?=	$this->Form->end(); ?>

	</div>
</div>
