<!-- File: src/Template/StaffSearch/index.ctp -->

<?= $this->Html->css($this->name . '/style.css') ?>
<?= $this->Html->css('//use.fontawesome.com/releases/v5.8.2/css/all.css') ?>

<div class="row">

  <?php $uid = rand(1111111,9999999); ?>
	<?php //if (!empty($form->errors())) echo '<p>ERRORS</p><textarea rows="5" style="font-size:0.6em;line-height:1.1em">' . print_r($form->errors(), true) . '</textarea>'; ?>
	<?php //echo '<textarea rows="5" style="font-size:0.6em;line-height:1.1em">' . print_r($form, true) . '</textarea>'; ?>
	<?php //if (!empty($result)) echo '<textarea rows="5" style="font-size:0.6em;line-height:1.1em">' . print_r($result, true) . '</textarea>'; ?>

	<h2><?= $form->searchHeaderText() ?></h2>
	<div class="waf-include">
	  <div id="<?= 'cs'.$uid ?>" class="contact-search-container">

		<!-- Form -->
		<?php
			echo $this->Form->create($form, [ 'action'=>false, 'novalidate' => true ]);
		?>

    <div class="form-item name-details">
      <?= $this->Form->control('lastname', ['type'=>'text', 'aria-labelledby' => 'surname', 'label' => $form->lastnameLabel($small), 'placeholder' => $form->lastnamePlaceholder($small)]); ?>
      <?= $this->Form->control('initial', ['type'=>'text', 'aria-labelledby' => 'initial', 'label' => $form->initialLabel($small), 'placeholder' => $form->initialPlaceholder($small)]); ?>
    </div>

    <div class="form-item search-specifics">
		  <?= $this->Form->control('exact', [ 'type'=>'radio', 'label'=>false, 'options'=>$form->matchOptions(), 'default' => 'e', 'templates'=>$waf->template_wrappers('exact',$form->spacer()) ]) ?>
    </div>

    <div id="buttons">
      <?= $this->Form->button($form->emailButtonText($small), [ 'type'=>'submit', 'name'=>'email' ]); ?>
      <?= $this->Form->button($form->phoneButtonText($small), [ 'type'=>'submit', 'name'=>'phone' ]); ?>
      <?= $form->emergencyContactHTML($small, $this); ?>
    </div>

		<?=	$this->Form->end(); ?>


		<?php if (isset($result['result'])) : ?>
			<?php if (!empty($result['result'])) : ?>
				<div class="contact-results">
					<div class="results-header">
						<h2>Results</h2>
						<?php if (!empty($result['data']['pager_size'])) echo '<div class="results-pages"> Page <span class="currentPage">1</span> of '.$result['data']['pager_size'].'</div>'; ?>
					</div>

					<ul class="contact-results-list">
						<?php foreach ($result['result'] as $person) : $display = $person['page']==1 ? 'list-item' : 'none'; ?>
							<li id="person_<?= $person['index'] ?>" class="person_entry person-page-<?= $person['page'] ?>" style="display:<?= $display ?>;">
								<div id="name-<?= $person['index'] ?>" class="person_name">
									<h3><?= $person['name'] ?></h3>
								</div>
								<div class="details">
									<div id="unit-<?= $person['index'] ?>" class="person_unit"><?= $person['unit'] ?></div>
									<?php if (!empty($person['email'])) : ?>
  									<div id="email-<?= $person['index'] ?>" class="person_email"><a href="mailto:<?= $person['email'] ?>"><?= $person['email'] ?></a></div>
									<?php endif; ?>
									<?php if (!empty($person['external_tel']) || !empty($person['internal_tel'])) : ?>
									  <div id="phone-<?= $person['index'] ?>" class="person_phone">
									    <dl>
									      <?php if (!empty($person['internal_tel'])) : ?><dt>Internal</dt><dd>73983</dd><?php endif; ?>
									      <?php if (!empty($person['external_tel'])) : ?><dt>External</dt><dd>01865 273983</dd><?php endif; ?>
									    </dl>
									  </div>
									<?php endif; ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>

					<?php if (!empty($result['data']['pager_size'])) : ?>
  					<ul class="pagination page-links">
  					  <li class="prev"><span>Prev</span></li>
  					  <li class="link page-1 active"><span>1</span></li>
  					  <?php for ($i=1; $i<$result['data']['pager_size']; $i++) : ?>
    					  <li class="link page-<?= $i+1 ?>"><span><?= $i+1 ?></span></li>
  					  <?php endfor; ?>
  					  <li class="next" href="#"><span>Next</span></li>
  					</ul>
					<?php endif; ?>

					<div class="details-incorrect">
						<p><?= $form->incorrectDetailsHTML($small) ?><p>
					</div>

				</div>
			<?php else : ?>
				<div class="contact-results">
					<div class="results-header">
						<h2>Results</h2>
					</div>

					<div class="contact-results-none">
						<p>No results found</p>
					</div>

					<div class="details-incorrect">
						<p><?= $form->incorrectDetailsHTML($small) ?><p>
					</div>

				</div>
			<?php endif; ?>
		<?php endif; ?>

		<div class="emergency-nums">
			<p><?= $form->emergencyContactHTML($small) ?></p>
		</div>

	</div>
  </div>
</div>
