<!-- File: src/Template/Pras/amend.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>Change Organisational Structure</h3>

		<p>If you are experiencing difficulties accessing this form please email PRAS at <a href="mailto:orgstructure@admin.ox.ac.uk">orgstructure@admin.ox.ac.uk</a>.</p>

		<!-- Form -->
		<?php
			echo $this->Form->create($pras, [ 'novalidate' => true ]);
		?>

		<h4>Remove <?= $pras->entityNameOptions($data['entityType']) ?></h4>
		<?php
		  echo $this->Form->input('stage', ['type' => 'hidden', 'value' => 2 ]);
		  echo $this->Form->input('entity', ['type' => 'hidden', 'value' => $data['entity'] ]);
		  //echo $waf->postValueWithLabel($data['changeType'], 'Change Type', $pras->changeTypeOptions());
		  echo $this->Form->input('changeType', ['type' => 'hidden', 'value' => $data['changeType'] ]);

		  echo $waf->postValueWithLabel($data['entityType'], 'Entity Type', $pras->entityTypeOptions());
		  echo $this->Form->input('entityType', ['type' => 'hidden', 'value' => $data['entityType'] ]);

		  if (!empty($data['division'])) {
  		  echo $waf->postValueWithLabel($data['division'], 'Division', $pras->divisionsOptions());
  		  if (empty($data['unit'])) echo $waf->postValueWithLabel($data['division'], 'Code');
		  }
		  echo $this->Form->input('division', ['type' => 'hidden', 'value' => $data['division'] ]);

		  if (!empty($data['unit'])) {
  		  echo $waf->postValueWithLabel($data['unit'], 'Unit', $pras->unitsOptions());
  		  if (empty($data['subunit'])) echo $waf->postValueWithLabel($data['unit'], 'Short Name', $pras->shortUnitsOptions());
  		  if (empty($data['subunit'])) echo $waf->postValueWithLabel($data['unit'], 'Code');
		  }
		  echo $this->Form->input('unit', ['type' => 'hidden', 'value' => $data['unit'] ]);

		  if (!empty($data['subunit'])) {
  		  echo $waf->postValueWithLabel($data['subunit'], 'SubUnit', $pras->subUnitsOptions());
  		  if (empty($data['costcentre'])) echo $waf->postValueWithLabel($data['subunit'], 'Short Name', $pras->shortSubUnitsOptions());
  		  if (empty($data['costcentre'])) echo $waf->postValueWithLabel($data['subunit'], 'Code');
		  }
		  echo $this->Form->input('subunit', ['type' => 'hidden', 'value' => $data['subunit'] ]);

		  if (!empty($data['costcentre'])) {
  		  echo $waf->postValueWithLabel($data['costcentre'], 'Cost Centre', $pras->costCentresOptions());
  		  echo $waf->postValueWithLabel($data['costcentre'], 'Code');
  		  echo $waf->postValueWithLabel($pras->costCentresPercentageOptions($data['costcentre']) . ' %', 'Percentage Split');
		  }
		  echo $this->Form->input('costcentre', ['type' => 'hidden', 'value' => $data['costcentre'] ]);
    ?>

    <h4>Approval</h4>
    <?php
      if (empty($data['costcentre'])) {
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

    <?php //echo '<textarea rows="50" style="line-height:1.2em;font-size:11px">' . print_r($pras->getHierarchyArray(),true) . '</textarea>' ?>

	</div>
</div>
