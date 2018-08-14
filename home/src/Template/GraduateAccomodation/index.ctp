<!-- File: src/Template/GraduateAccomodation/index.ctp -->

<?php
  $applcationOptions = [ 'Single','Joint','Couple/Family' ];
  $titleOptions = [ "Mr","Mrs","Miss","Ms","Dr","Other" ];
  $collegeOptions = [ "Not Yet Allocated A College","Balliol College","Blackfriars College","Brasenose College","Christ Church College","Corpus Christi College","Exeter College","Green Templeton College","Harris Manchester College","Hertford College","Jesus College","Keble College","Kellogg College","Lady Margaret Hall","Linacre College","Lincoln College","Magdalen College","Mansfield College","Merton College","New College","Nuffield College","Oriel College","Pembroke College","Regent's Park College","Somerville College","St Anne's College","St Antony's College","St Benet's College","St Catherine's College","St Cross College","St Edmund Hall","St Hilda's College","St Hugh's College","St John's College","St Peter's College","St Stephen's College","The Queen's College","Trinity College","University College","Wadham College","Wolfson College","Worcester College","Wycliffe Hall" ];
  $degreeOptions = [ "DPhil","MPhil","MSc","MSt","Masters","BPhil","MTh","PGCert","Cert","Other" ];
  $termOptions = [ 'MT - Michaelmas','HT - Hilary','TT - Trinity' ];
  $year = intval( date('Y') );
  $yearOptions = range($year, $year+15);
  $accomodationOptions = [ "Double Studio","One Bed Flat","Two Bed Flat","Three Bed Flat","Two Bed House","Three Bed House" ];
?>

<div class="row">
	<div class="waf-include">

	  <?php echo $this->Html->script('GraduateAccomodation/script.js'); ?>

		<h3>Accommodation Request Form</h3>
    <p>Data Protection Act 1998: The information contained on this form is processed in accordance with the provisions of the Data Protection Act 1998. The information will be held for the purposes of maintaining a waiting list for those requiring graduate accommodation.</p>
    <p>If you have any problems submitting this application form, please contact us at <a href="mailto:graduate.accommodation@admin.ox.ac.uk">graduate.accommodation@admin.ox.ac.uk</a>.</p>

		<!-- Form -->
		<?php
			echo $this->Form->create($form);
		?>

		<h4>Scope</h4>
		<?= $this->Form->input('application_type', ['type' => 'select', 'options' => $applcationOptions, 'empty' => '-- Please Select --', 'label' => 'Select the Application Type you wish to apply for']); ?>

    <div id="applicant1">
      <h4>Section <span class="section_number">1</span> - APPLICANT 1 INFORMATION</h4>
  		<?= $this->Form->input('title', ['type' => 'select', 'options' => $titleOptions, 'empty' => '-- Please Select --', 'label' => 'Title']); ?>
      <?= $this->Form->control('title_other', ['type'=>'text', 'label' => ['text'=>'Does the Entity require a domain name? (if yes, please provide preferred domain name ending in <strong><em>ox.ac.uk</em></strong>)','escape' => false ]]); ?>

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
  		<?= $this->Form->input('college', ['type' => 'select', 'options' => $collegeOptions, 'empty' => '-- Please Select --', 'label' => 'College']); ?>
  		<?= $this->Form->input('degree', ['type' => 'select', 'options' => $degreeOptions, 'empty' => '-- Please Select --', 'label' => 'Degree']); ?>
      <?= $this->Form->control('subject', ['type'=>'text', 'label' => 'Subject']); ?>
      <?= $this->Form->control('supervisor', ['type'=>'text', 'label' => 'Supervisor']); ?>
      <?= $this->Form->control('oss_number', ['type'=>'text', 'label' => 'Student Number']); ?>
      <?= $this->Form->input('degree_start', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Start Date of Degree Course (dd/mm/yyyy)']); ?>
  		<?= $this->Form->input('term', ['type' => 'select', 'options' => $termOptions, 'empty' => '-- Term --', 'label' => 'Expected Finish Term']); ?>
  		<?= $this->Form->input('term_year', ['type' => 'select', 'options' => $yearOptions, 'empty' => '-- Year --', 'label' => 'Expected Finish Year']); ?>
    </div>

    <div id="accomodation">
      <h4>Section <span class="section_number">2</span> - ACCOMMODATION PREFERRED</h4>
      <p>You do not have to select all 2 preferences (First preference is mandatory).</p>
      <p>Further information about University properties can be viewed on our website at <a href="http://www.admin.ox.ac.uk/graduateaccommodation/" target="_blank">http://www.admin.ox.ac.uk/graduateaccommodation/</a></p>

  		<?= $this->Form->input('acc_prefer_1', ['type' => 'select', 'options' => $accomodationOptions, 'empty' => '-- Please Select --', 'label' => 'Accomodation Type']); ?>
  		<?= $this->Form->input('acc_prefer_2', ['type' => 'select', 'options' => $accomodationOptions, 'empty' => '-- Please Select --', 'label' => 'First preference']); ?>
  		<?= $this->Form->input('acc_prefer_3', ['type' => 'select', 'options' => $accomodationOptions, 'empty' => '-- Please Select --', 'label' => 'Accomodation Type']); ?>
  		<?= $this->Form->input('acc_prefer_4_', ['type' => 'select', 'options' => $accomodationOptions, 'empty' => '-- Please Select --', 'label' => 'Second preference']); ?>
  		<p><strong>Please note that 3-bedroom properties are only for families with more than one child.</strong></p>
  		<p><i>Please note that unfortunately we cannot guarantee that you will receive an offer of accommodation.</i></p>
      <?= $this->Form->input('tenancy_accept', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Date accommodation is required from (mm/yyyy)']); ?>
  		<p><i>(N.B. Tenancies can only start a maximum of one month before your course commences.)</i></p>
      <?= $this->Form->control('comments', ['type'=>'textarea', 'label' => 'Do you have any specific requirements that we should be aware of?', 'rows' => 2]); ?>
    </div>

    <?= $this->Form->button('Submit'); ?>
		<?=	$this->Form->end(); ?>

	</div>
</div>
