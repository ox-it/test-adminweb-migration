<!-- File: src/Template/AccessSearch/index.ctp -->


<div class="row">

	<?php //if (!empty($form->errors())) echo '<p>ERRORS</p><textarea rows="5" style="font-size:0.6em;line-height:1.1em">' . print_r($form->errors(), true) . '</textarea>'; ?>
	<?php //echo '<textarea rows="5" style="font-size:0.6em;line-height:1.1em">' . print_r($form, true) . '</textarea>'; ?>

	<h3>Access Search</h3>
	<p><strong>Search by building or department name</strong></p>

	<div class="waf-include">

		<!-- Form -->
		<?php
			echo $this->Form->create($form, [ 'action'=>false, 'novalidate' => true ]);
		?>

    <?= $this->Form->control('keywords', ['type'=>'text', 'label' => false]); ?>
		<?php foreach($form->searchOptions() as $key=>$label) { ?>
			<?= $this->Form->control($key, [ 'type'=>'checkbox', 'label'=>$label, 'value'=>'Y', 'hiddenField'=>'N' ] ); ?>
		<?php } ?>

    <p>&nbsp;</p>

    <div id="buttons">
      <?= $this->Form->button('Submit'); ?>
    </div>

		<?=	$this->Form->end(); ?>

	</div>
</div>
