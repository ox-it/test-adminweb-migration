<!-- File: src/Template/Pras/amend.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>Change Organisational Structure</h3>

		<p>If you are experiencing difficulties accessing this form please email PRAS at <a href="mailto:orgstructure@admin.ox.ac.uk">orgstructure@admin.ox.ac.uk</a>.</p>

		<!-- Form -->
		<?php
			echo $this->Form->create($pras, [ 'novalidate' => true ]);
		?>

		<h4>Amend <?= $pras->entityNameOptions($data['entityType']) ?></h4>
		<?php
		  //echo $waf->postValueWithLabel($data['changeType'], 'Change Type', $pras->changeTypeOptions());
		  echo $this->Form->control('stage', ['type' => 'hidden', 'value' => 2 ]);
		  echo $this->Form->control('entity', ['type' => 'hidden', 'value' => $data['entity'] ]);
		  echo $this->Form->control('changeType', ['type' => 'hidden', 'value' => $data['changeType'] ]);

		  echo $waf->postValueWithLabel($data['entityType'], 'Entity Type', $pras->entityTypeOptions());
		  echo $this->Form->control('entityType', ['type' => 'hidden', 'value' => $data['entityType'] ]);

		  if (!empty($data['division'])) {
  		  echo $waf->postValueWithLabel($data['division'], 'Division', $pras->divisionsOptions());
  		  if (empty($data['unit'])) echo $waf->postValueWithLabel($data['division'], 'Code');
		  }
		  echo $this->Form->control('division', ['type' => 'hidden', 'value' => $data['division'] ]);

		  if (!empty($data['unit'])) {
  		  echo $waf->postValueWithLabel($data['unit'], 'Unit', $pras->unitsOptions());
  		  if (empty($data['subunit'])) echo $waf->postValueWithLabel($data['unit'], 'Short Name', $pras->shortUnitsOptions());
  		  if (empty($data['subunit'])) echo $waf->postValueWithLabel($data['unit'], 'Code');
		  }
		  echo $this->Form->control('unit', ['type' => 'hidden', 'value' => $data['unit'] ]);

		  if (!empty($data['subunit'])) {
  		  echo $waf->postValueWithLabel($data['subunit'], 'SubUnit', $pras->subUnitsOptions());
  		  if (empty($data['costcentre'])) echo $waf->postValueWithLabel($data['subunit'], 'Short Name', $pras->shortSubUnitsOptions());
  		  if (empty($data['costcentre'])) echo $waf->postValueWithLabel($data['subunit'], 'Code');
		  }
		  echo $this->Form->control('subunit', ['type' => 'hidden', 'value' => $data['subunit'] ]);

		  if (!empty($data['costcentre'])) {
  		  echo $waf->postValueWithLabel($data['costcentre'], 'Cost Centre', $pras->costCentresOptions());
  		  echo $waf->postValueWithLabel($data['costcentre'], 'Code');
  		  echo $waf->postValueWithLabel($pras->costCentresPercentageOptions($data['costcentre']) . ' %', 'Current Percentage Split');
		  }
		  echo $this->Form->control('costcentre', ['type' => 'hidden', 'value' => $data['costcentre'] ]);
    ?>

    <h4>Proposed Changes</h4>
    <?php
      if (empty($data['costcentre'])) {
        echo $this->Form->control('newFullName', ['type'=>'text', 'label' => 'Proposed New Full Name']);
        echo $this->Form->control('newShortName', ['type'=>'text', 'label' => 'Proposed New Short Name']);
        echo $this->Form->control('newCode', ['type'=>'text', 'label' => 'Proposed New Code (if known)']);
      } else {
  		  echo $this->Form->control('newCostCentre1', ['type' => 'select', 'options' => $pras->costCentresOptions(), 'empty' => '-- Please Select --', 'label' => 'Proposed New Cost Centre']);
        echo $this->Form->control('costCentreSplit1', ['type'=>'number', 'label' => 'Cost Centre % Split (0-100)']);
      }
    ?>

    <h4>Approval</h4>
    <?php
      if (empty($data['costcentre'])) {
        echo $this->Form->control('generalPurposesConfirmed', ['type'=>'checkbox', 'label' => 'Has this change been confirmed by the General Purposes Committee?', 'value'=>'Yes', 'hiddenField' => 'No', 'templates'=>$waf->template_wrappers('generalPurposesConfirmed', '', 'spaced') ]);
        echo $this->Form->control('divisionalBoardConfirmed', ['type'=>'checkbox', 'label' => 'Has this change been confirmed by the relevant Divisional Board?', 'value'=>'Yes', 'hiddenField' => 'No', 'templates'=>$waf->template_wrappers('generalPurposesConfirmed', '', 'spaced') ]);
      }
      echo $this->Form->control('changeDate', ['type' => 'text','div' => false, 'label' => false, 'wrapInput' => false, 'label' => 'Effective date of change (dd/mm/yyyy)']);
      echo $this->Form->control('approverName', ['label' => 'Approver Name']);
      echo $this->Form->control('approverJobTitle', ['label' => 'Approver Job Title']);
      echo $this->Form->control('approverEmail', ['label' => 'Approver Email Address']);
    ?>

    <p>Submitting this form will send an email of your request to the Organisation Structure administrator.</p>

    <?= $this->Form->button('Submit'); ?>
    <?= $waf->postButtonToReferer($this, 'Start Again') ?>
		<?=	$this->Form->end(); ?>

    <?php //echo '<textarea rows="50" style="line-height:1.2em;font-size:11px">' . print_r($pras->getHierarchyArray(),true) . '</textarea>' ?>

	</div>
</div>
