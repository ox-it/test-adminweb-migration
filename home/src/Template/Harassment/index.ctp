<!-- File: src/Template/FinanceTravel/index.ctp -->

<?php
  $lastyear = date('Y') - 1;
  $years = range(2007,$lastyear);
  $yearOptions = [];
  foreach ($years as $year) $yearOptions[$year] = $year.'/'.substr($year+1,-2,2);

  function template_wrappers($field, $notes='', $classes=[]) {
    return [
			'inputContainer'=>'<div id="'.$field.'_wrapper" class="input {{type}}{{required}} '.implode(' ',$classes).'">{{content}}'.$notes.'</div>',
			'inputContainerError'=>'<div id="'.$field.'_wrapper" class="input {{type}}{{required}} '.implode(' ',$classes).' error">{{content}}{{error}}'.$notes.'</div>'
    ];
  }
?>

<div class="row">

	<h3>
		Harassment Survey
	</h3>

	<?= $this->Html->script($this->name . '/script.js') ?>

	<div class="waf-include">

    <!-- Information -->
    <p>Welcome to the Harrasment Survey reporting form.</p>
    <?php if (count($userdepts)>1) : ?>
      <p>
        Please select the department, faculty or college you are reporting for and then press
        the appropriate button to indicate whether you have a report to enter or whether
        there are no incidents to report for the last year.
      </p>
    <?php else : ?>
      <p>
        Please press the appropriate button to indicate whether you have a report to
        enter or whether there are no incidents to report for the last year.
      </p>
    <?php endif; ?>

    <?php //echo '<textarea rows="10" style="line-height:1.1em">' . print_r($userdepts, true) . '</textarea>'; ?>

    <!-- Form -->
		<?= $this->Form->create($user) ?>

			<?php if (count($userdepts)>1) : ?>
				<h4><?= $user->name ?></h4>
			  <?php
			    $departmentsOptions = [];
			    foreach($userdepts as $d) $departmentsOptions[$d->deptcode] = $d->deptalpha;
			  ?>
			  <?= $this->Form->input('deptcode', [ 'type'=>'select', 'options'=>$departmentsOptions, 'label'=>'Please select the appropriate department, faculty or college' ], [ 'val'=>$user->deptcode ]) ?>
			<?php
			  else :
			  if (count($userdepts)==1) {
			    $department = $userdepts->first();
			    $display = '<strong><em>'.$department->deptalpha.'</em></strong>';
			    $deptcode = $department->deptcode;
			  } else {
			    $display = '<em>No related departments found</em>';
			    $deptcode = '';
			  }
			?>
				<h4>
				  <strong><?= $user->name ?></strong>
				  -
					<?= $display ?>
				</h4>
  			<?= $this->Form->control('deptcode', [ 'type'=>'hidden', 'default'=>$deptcode ]) ?>
			<?php endif; ?>

			<?= $this->Form->input('acyear', [ 'type'=>'select', 'options'=>$yearOptions, 'label'=>'Please select the appropriate academic year', 'default'=>$lastyear ], [ 'val'=>$user->acyear ]) ?>

			<!-- Submit -->
			<?php
					echo $this->Form->button(__('Submit Report'), [ 'name'=>'action', 'value'=>'report' ]);
					echo $this->Form->button('No Reports', [ 'name'=>'action', 'value'=>'noreport' ]);
			?>

		<?php
				echo $this->Form->end();
		?>

	</div>
</div>