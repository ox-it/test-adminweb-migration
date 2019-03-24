<!-- File: src/Template/StaffSearch/index.ctp -->

<?= $this->Html->css($this->name . '/style.css') ?>

<div class="row">

  <?php $uid = rand(1111111,9999999); ?>

	<h2><?= $form->searchHeaderText() ?></h2>
	<div class="waf-include">
	  <div id="<?= 'cs'.$uid ?>" class="contact-search-container">

			<?= $this->Html->script($this->name . '/jsonly.js') ?>

			<!-- Form -->
			<form id="<?= 'csf'.$uid ?>" class="staff_search_jsonly_contact_form" method="get">
				<div class="form-item name-details">
					<?= $this->Form->control('lastname', ['type'=>'text', 'label' => $form->lastnameLabel($small), 'placeholder' => $form->lastnamePlaceholder($small)]); ?>
					<?= $this->Form->control('initial', ['type'=>'text', 'label' => $form->initialLabel($small), 'placeholder' => $form->initialPlaceholder($small)]); ?>
				</div>
				<div class="form-item search-specifics">
					<?= $this->Form->control('exact', [ 'type'=>'radio', 'label'=>false, 'options'=>$form->matchOptions(), 'default' => 'e', 'templates'=>$waf->template_wrappers('exact',$form->spacer()) ]) ?>
				</div>
				<div class="form-actions">
					<?= $this->Form->button($form->emailButtonText($small), [ 'type'=>'submit', 'name'=>'find_email', 'alt'=>'Find email address', 'data-medium'=>'email' ]); ?>
					<?= $this->Form->button($form->phoneButtonText($small), [ 'type'=>'submit', 'name'=>'find_phone', 'alt'=>'Find telephone numbers', 'data-medium'=>'phone' ]); ?>
					<?= $form->emergencyContactHTML($small, $this); ?>
				</div>
			</form>

			<div class='contact-results'></div>

			<div class="emergency-nums">
				<p><?= $form->emergencyContactHTML($small) ?></p>
			</div>

			<script >
			<!--//--><![CDATA[// ><!--
					(function($) {
							$(document).ready(function() { contact_search.create_form({'el':"#<?= 'cs'.$uid ?>"}); });
					}(jQuery));
			//--><!]]>
			</script>


		</div>
  </div>
</div>
