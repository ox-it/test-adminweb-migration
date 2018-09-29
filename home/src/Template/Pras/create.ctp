<!-- File: src/Template/Pras/amend.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>Change Organisational Structure</h3>

		<p>If you are experiencing difficulties accessing this form please email PRAS at <a href="mailto:orgstructure@admin.ox.ac.uk">orgstructure@admin.ox.ac.uk</a>.</p>

		<!-- Form -->
		<?php
			echo $this->Form->create($pras, [ 'novalidate' => true ]);
		?>

		<h4>Create new <?= $pras->entityNameOptions($data['entityType']) ?><?= ($data['entityType']!='level1') ? ' within' : '' ?></h4>
		<?php
		  //echo $waf->postValueWithLabel($data['changeType'], 'Change Type', $pras->changeTypeOptions());
		  //echo $waf->postValueWithLabel($data['entityType'], 'Entity Type', $pras->entityTypeOptions());
		  echo $this->Form->control('stage', ['type' => 'hidden', 'value' => 2 ]);
		  echo $this->Form->control('entity', ['type' => 'hidden', 'value' => $data['entity'] ]);
		  echo $this->Form->control('changeType', ['type' => 'hidden', 'value' => $data['changeType'] ]);
		  echo $this->Form->control('entityType', ['type' => 'hidden', 'value' => $data['entityType'] ]);

		  if (!empty($data['division'])) {
  		  echo $waf->postValueWithLabel($data['division'], 'Division', $pras->divisionsOptions());
  		  echo $this->Form->control('division', ['type' => 'hidden', 'value' => $data['division'] ]);
		  }

		  if (!empty($data['unit'])) {
  		  echo $waf->postValueWithLabel($data['unit'], 'Unit', $pras->unitsOptions());
  		  echo $this->Form->control('unit', ['type' => 'hidden', 'value' => $data['unit'] ]);
	  }

		  if (!empty($data['subunit'])) {
  		  echo $waf->postValueWithLabel($data['subunit'], 'SubUnit', $pras->subUnitsOptions());
  		  echo $this->Form->control('subunit', ['type' => 'hidden', 'value' => $data['subunit'] ]);
		  }

		  if (!empty($data['costcentre'])) {
  		  echo $waf->postValueWithLabel($data['costcentre'], 'Cost Centre', $pras->costCentresOptions());
  		  echo $waf->postValueWithLabel($data['costcentre'], 'Code');
  		  echo $waf->postValueWithLabel($data['info']['CostCentrePercentage'] . ' %', 'Current Percentage Split');
  		  echo $this->Form->control('costcentre', ['type' => 'hidden', 'value' => $data['costcentre'] ]);
		  }

    ?>

		<?php
			if ($data['entityType']!='cost-centre') {
			  echo '<h4>Details</h4>' . "\n";
				echo $this->Form->control('newFullName', ['type'=>'text', 'label' => 'Proposed New Full Name']) . "\n";
				echo $this->Form->control('newShortName', ['type'=>'text', 'label' => 'Proposed New Short Name']) . "\n";
				echo $this->Form->control('newCode', ['type'=>'text', 'label' => 'Proposed New Code (if known)']) . "\n";
			} else {
			  echo '<h4>New Cost Centres</h4>' . "\n";
			  echo '<div id="newconstcentres">' . "\n";
				for ($i=1;$i<11;$i++) {
					echo '<div id="cost-centre-'.$i.'" class="newCostCentre">' . "\n";
					echo $this->Form->control('newCostCentre'.$i, ['type' => 'select', 'options' => $pras->costCentresOptions(), 'empty' => '-- Please Select --', 'label' => 'Proposed New Cost Centre']) . "\n";
					echo $this->Form->control('costCentreSplit'.$i, ['type'=>'number', 'label' => 'Cost Centre % Split (0-100)']) . "\n";
					echo '</div>' . "\n";
				}
				echo '</div>' . "\n";
				// echo $this->Form->button('Add another cost centre', [ 'type'=>'button', 'id'=>'add-another-cost-centre' ]);
			}
		?>

    <div id="confirmation">
      <h4>Confirmation</h4>
      <?= $this->Form->control('newStaffCharge', ['type'=>'radio', 'options' => $pras->yesNoOptions(), 'label' => 'Are new staff to be charged to the Entity?']); ?>
      <?= $this->Form->control('existingStaffTransfer', ['type'=>'radio', 'options' => $pras->yesNoOptions(), 'label' => 'Are existing staff to be transferred to the Entity?']); ?>
      <?= $this->Form->control('contact', ['type'=>'text', 'label' => 'Contact name for personnel matters']); ?>
      <?= $this->Form->control('studentLoad', ['type'=>'radio', 'options' => $pras->yesNoOptions(), 'label' => 'Will the Entity have a student load?']); ?>
      <?= $this->Form->control('admitGraduates', ['type'=>'radio', 'options' => $pras->yesNoOptions(), 'label' => 'Will the unit have the power to admit graduate students?']); ?>
      <?= $this->Form->control('coursesAwards', ['type'=>'textarea', 'label' => 'List any courses/awards to be associated with the Entity', 'rows' => 4]); ?>
      <?= $this->Form->control('researchGrants', ['type'=>'radio', 'options' => $pras->yesNoOptions(), 'label' => 'Are any research grants to be charged to the Entity?']); ?>
      <?= $this->Form->control('departmentalProjects', ['type'=>'radio', 'options' => $pras->yesNoOptions(), 'label' => 'Will the entity have any departmental projects?']); ?>
      <?= $this->Form->control('domainName', ['type'=>'text', 'label' => ['text'=>'Does the Entity require a domain name? (if yes, please provide preferred domain name ending in <strong><em>ox.ac.uk</em></strong>)','escape' => false ]]); ?>
      <?= $this->Form->control('itSupport', ['type'=>'text', 'label' => 'Who will be responsible for IT support?']); ?>
      <?= $this->Form->control('physicalAddress', ['type'=>'textarea', 'label' => 'Will the new entity have dedicated physical space? (if yes, please provide address)', 'rows' => 4]); ?>
    </div>

    <h4>Approval</h4>
    <?php
      if ($data['entityType']!='cost-centre') {
        echo $this->Form->control('generalPurposesConfirmed', ['type'=>'checkbox', 'label' => 'Has this change been confirmed by the General Purposes Committee?', 'templates'=>$waf->template_wrappers('generalPurposesConfirmed', '', 'spaced') ]);
        echo $this->Form->control('divisionalBoardConfirmed', ['type'=>'checkbox', 'label' => 'Has this change been confirmed by the relevant Divisional Board?', 'templates'=>$waf->template_wrappers('generalPurposesConfirmed', '', 'spaced') ]);
      }
      echo $this->Form->input('changeDate', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Effective date of change (dd/mm/yyyy)']);
      echo $this->Form->control('approverName', ['label' => 'Approver Name']);
      echo $this->Form->control('approverJobTitle', ['label' => 'Approver Job Title']);
      echo $this->Form->control('approverEmail', ['label' => 'Approver Email Address']);
    ?>

    <p>Submitting this form will send an email of your request to the Organisation Structure administrator.</p>

    <?= $this->Form->button('Submit'); ?>
    <?= $waf->postButtonToReferer($this, 'Start Again') ?>
		<?=	$this->Form->end(); ?>

    <?php // echo '<textarea rows="50" style="line-height:1.2em;font-size:11px">' . print_r($pras->getHierarchyArray(),true) . '</textarea>' ?>

	</div>
</div>
