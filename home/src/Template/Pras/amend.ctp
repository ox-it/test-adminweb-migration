<!-- File: src/Template/Pras/index.ctp -->

<?php
  $yesNoOptions = ['yes'=>'Yes', 'no'=>'No'];
?>

<div class="row">
	<div class="waf-include">

	  <?php echo $this->Html->script('Pras/script.js'); ?>

		<h3>Change Organisational Structure</h3>

		<p>If you are experiencing difficulties accessing this form please email PRAS at <a href="mailto:orgstructure@admin.ox.ac.uk">orgstructure@admin.ox.ac.uk</a>.</p>

		<!-- Form -->
		<?php
			echo $this->Form->create($pras);
		?>

		<h4>Scope</h4>
		<?= $this->Form->input('changeType', ['type' => 'select', 'options' => $change_type_options, 'empty' => '-- Please Select --', 'label' => 'Change Type']); ?>
		<?= $this->Form->input('entityType', ['type' => 'select', 'options' => $entity_type_options, 'empty' => '-- Please Select --', 'label' => 'Entity To Change']); ?>

    <div id="level1">
		  <?= $this->Form->input('level1', ['type' => 'select', 'options' => $division_options, 'empty' => '-- Please Select --', 'label' => 'Level 1 - Division']); ?>
		</div>

    <div id="level2">
		  <?= $this->Form->input('level2', ['type' => 'select', 'options' => $unit_options, 'empty' => '-- Please Select --', 'label' => 'Level 2 - Unit']); ?>
		</div>

    <div id="level3">
		  <?= $this->Form->input('level3', ['type' => 'select', 'options' => $sub_unit_options, 'empty' => '-- Please Select --', 'label' => 'Level 2 - Unit']); ?>
		</div>

    <div id="newconstcentres">
      <h4>New Cost Centres</h4>
  		<?= $this->Form->input('newCostCentre1', ['type' => 'select', 'options' => $cost_centre_options, 'empty' => '-- Please Select --', 'label' => 'Proposed New Cost Centre']); ?>
      <?= $this->Form->control('costCentreSplit1', ['type'=>'text', 'label' => 'Cost Centre % Split (0-100)']); ?>
      <?= $this->Form->button('Add another cost centre', ['type'=>'button']); ?>
    </div>

    <div id="confirmation">
      <h4>Confirmation</h4>
      <?= $this->Form->control('newStaffCharge', ['type'=>'radio', 'options' => $yesNoOptions, 'label' => 'Are new staff to be charged to the Entity?']); ?>
      <?= $this->Form->control('existingStaffTransfer', ['type'=>'radio', 'options' => $yesNoOptions, 'label' => 'Are existing staff to be transferred to the Entity?']); ?>
      <?= $this->Form->control('contact', ['type'=>'text', 'label' => 'Contact name for personnel matters']); ?>
      <?= $this->Form->control('studentLoad', ['type'=>'radio', 'options' => $yesNoOptions, 'label' => 'Will the Entity have a student load?']); ?>
      <?= $this->Form->control('admitGraduates', ['type'=>'radio', 'options' => $yesNoOptions, 'label' => 'Will the unit have the power to admit graduate students?']); ?>
      <?= $this->Form->control('coursesAwards', ['type'=>'textarea', 'label' => 'List any courses/awards to be associated with the Entity', 'rows' => 4]); ?>
      <?= $this->Form->control('researchGrants', ['type'=>'radio', 'options' => $yesNoOptions, 'label' => 'Are any research grants to be charged to the Entity?']); ?>
      <?= $this->Form->control('departmentalProjects', ['type'=>'radio', 'options' => $yesNoOptions, 'label' => 'Will the entity have any departmental projects?']); ?>
      <?= $this->Form->control('domainName', ['type'=>'text', 'label' => ['text'=>'Does the Entity require a domain name? (if yes, please provide preferred domain name ending in <strong><em>ox.ac.uk</em></strong>)','escape' => false ]]); ?>
      <?= $this->Form->control('itSupport', ['type'=>'text', 'label' => 'Who will be responsible for IT support?']); ?>
      <?= $this->Form->control('physicalAddress', ['type'=>'textarea', 'label' => 'Will the new entity have dedicated physical space? (if yes, please provide address)', 'rows' => 4]); ?>
      <?= $this->Form->control('generalPurposesConfirmed', ['type'=>'checkbox', 'label' => 'Has this change been confirmed by the General Purposes Committee?']); ?>
      <?= $this->Form->control('divisionalBoardConfirmed', ['type'=>'checkbox', 'label' => 'Has this change been confirmed by the relevant Divisional Board?']); ?>
    </div>

    <h4>Approval</h4>
    <?php
      echo $this->Form->input('changeDate', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Effective date of change (dd/mm/yyyy)']);
      echo $this->Form->control('approverName', ['label' => 'Approver Name']);
      echo $this->Form->control('approverJobTitle', ['label' => 'Approver Job Title']);
      echo $this->Form->control('approverEmail', ['label' => 'Approver Email Address']);
    ?>

    <?= $this->Form->button('Submit'); ?>
		<?=	$this->Form->end(); ?>

    <textarea rows="50" style="line-height:1.2em;font-size:11px"><?php
				print_r($hierarchy);
		?></textarea>

	</div>
</div>
