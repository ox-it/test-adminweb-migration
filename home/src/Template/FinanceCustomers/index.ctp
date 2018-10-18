<!-- File: src/Template/FinanceCustomers/index.ctp -->

<div class="row">

	<h3>
		Customer Set-up Form
	</h3>

	<div class="waf-include">

    <!-- Information -->
    <p>
      Welcome to the Accounts Receivable (AR) Customer Set-up form. We will endeavour to
      complete the set up within two working days. If, however, the set up is urgent
      please contact the AR Team on 01865 (6)16003, or email
      <a href="mailto:ar.cust.setup@admin.ox.ac.uk" class="email">ar.cust.setup@admin.ox.ac.uk</a>,
      and we will do our best to meet your requirements.
    </p>
    <p>
      Please fill in the following details, using normal upper and lower case letters where appropriate.
    </p>


    <!-- Form -->
		<?= $this->Form->create($customer, [ 'type'=>'file', 'context'=>[ 'validator'=>'register' ], 'novalidate'=>true ]) ?>

			<h4>
				Your Details
			</h4>
			<?= $this->Form->control('forename', [ 'label'=>'First name' ]) ?>
			<?= $this->Form->control('surname', [ 'label'=>'Surname' ]) ?>
			<?= $this->Form->control('phone', [ 'label'=>'Telephone' ]) ?>
			<?= $this->Form->control('email', [ 'label'=>'Email' ]) ?>
			<?= $this->Form->control('deptcode', [ 'type'=>'select', 'options'=>$departments, 'empty'=>'-- Please select if appropriate --', 'label'=>'Department/Faculty' ] ) ?>
			<?= $this->Form->control('depttext', [ 'label'=>'Department/Faculty Details (please specify)', 'templates'=>$waf->template_wrappers('depttext') ]) ?>

			<hr class="line">

			<!-- Customer Details -->
			<h4>
				Customer Details
			</h4>
			<?= $this->Form->control('category', [ 'type'=>'radio', 'options'=>$customer->categoryOptions(), 'label'=>'Customer Category', 'templates'=>$waf->template_wrappers('category', $customer->spacer(), 'spaced','radios') ] ) ?>
			<?php	$custname_notes = '<div class="notes">(Full trading name and legal status for Organisation responsible for payment, e.g. A Customer PLC. If an Individual, please provide their full name)</div>'; ?>
			<?= $this->Form->control('custname', [ 'label'=>'Name', 'default'=>$customer->custname, 'templates'=>$waf->template_wrappers('custname',$custname_notes) ]) ?>
			<?= $this->Form->control('custtitle', [ 'label'=>'Title', 'default'=>$customer->title, 'templates'=>$waf->template_wrappers('custtitle') ]) ?>
			<?= $this->Form->control('accounttype', [ 'type'=>'select', 'options'=>$customer->accounttypeOptions(), 'label'=>'Account Type' ] ) ?>
			<?php $accountnum_notes = '<div class="notes">(Additional or Existing sites)</div>'; ?>
			<?= $this->Form->control('accountnum', [ 'label'=>'Customer Account No.', 'templates' => $waf->template_wrappers('accountnum',$accountnum_notes) ]) ?>
			<?= $this->Form->control('custURL', [ 'label'=>'Company Website'] ) ?>
			<?= $this->Form->control('custparent', [ 'label'=>'Parent Company (if applicable)' ]) ?>
			<?= $this->Form->control('custtype', [ 'type'=>'select', 'options'=>$customer->custtypeOptions(), 'empty'=>'-- Please select --', 'label'=>'Customer Type' ] ) ?>

			<!-- Conditions of Sale and Credit Review -->
			<h4>
				Conditions of Sale and Credit Review
			</h4>
      <?= $this->Form->control('payterms', [ 'type'=>'select', 'options'=>$customer->paytermsOptions(), 'empty'=>'-- Please select --', 'label'=>'Payment Terms' ] ) ?>
			<?= $this->Form->control('paytermsother', [ 'label'=>'Please specify custom payment terms', 'default'=>$customer->paytermsother, 'templates'=>$waf->template_wrappers('paytermsother') ]) ?>
			<?php $sendcon_notes = '<div class="notes">(Departments are responsible for ensuring customers receive a copy of the University\'s Standard Conditions of Sale and Supply)</div>'; ?>
      <?=  $this->Form->control('sendcon', [ 'type'=>'radio', 'options'=>$customer->yesnoOptions(), 'label'=>'Have Conditions of Sale and Supply been provided to your Customer?', 'templates'=>$waf->template_wrappers('sendcon',$sendcon_notes, 'spaced','radios') ] ) ?>
			<?php	$transaction_notes = '<div class="notes">(Approximate value of 6 week\'s supply. Required for Credit Checking where appropriate.)</div>'; ?>
			<?= $this->Form->control('transaction', [ 'type'=>'number', 'label'=>'Value of proposed Transaction(s) in Pounds Sterling (£)', 'templates'=>$waf->template_wrappers('transaction',$transaction_notes) ]) ?>
      <?= $this->Form->control('POupload', [ 'type'=>'radio', 'options'=>$customer->yesnoOptions(), 'label'=>'Copy of Customer PO sent to AR?', 'templates'=>$waf->template_wrappers('POupload','','spaced','radios') ] ) ?>
			<?php
			  $POfileLabel = 'If "Yes", please upload: the PO here';
			  if (!empty($customer->POfiles)) {
			    $files = (is_array($customer->POfiles)) ? $customer->POfiles : unserialize($customer->POfiles);
  			  echo $this->Form->control('POfiles', [ 'type'=>'hidden', 'value'=>serialize($files) ]);
			    //echo '<ul><li class="upload">' . implode('</li class="upload"><li>', $files ) . '</li></ul>';
			    $POfileLabel = 'Uploaded: <em>' . implode(', ', $files) . '</em><br>&hellip; or upload a different file';
			  }
			  if (!empty($customer->POfile)) echo $this->Form->control('POfile', [ 'type'=>'hidden', 'value'=>$customer->POfile ]);
      ?>
			<?= $this->Form->control('POtemp', [ 'type'=>'file', 'accept'=>'application/msword,application/pdf,text/rtf,text/txt', 'label'=>['text' => $POfileLabel, 'escape' => false], 'templates'=>$waf->template_wrappers('POtemp') ]) ?>

			<!-- Billing (Invoice) Address  -->
			<h4>
				Billing (Invoice) Address
			</h4>
      <?= $this->Form->control('billaddress1',	[ 'label'=>'Line 1' ]) ?>
			<?= $this->Form->control('billaddress2',	[ 'label'=>'Line 2' ]) ?>
			<?= $this->Form->control('billaddress3',	[ 'label'=>'Line 3' ]) ?>
			<?= $this->Form->control('billaddress4',	[ 'label'=>'Line 4' ]) ?>
			<?= $this->Form->control('billtown',			[ 'label'=>'Town/City' ]) ?>
			<?= $this->Form->control('billcounty',		[ 'label'=>'County/State' ]) ?>
			<?= $this->Form->control('billpostcode',	[ 'label'=>'Post/Zip Code' ]) ?>
      <?= $this->Form->control('billdomcode',		[ 'type'=>'select', 'options'=>$countries, 'label'=>'Country', 'default'=>'GB' ] ) ?>
      <?php $VATflag_notes = '<div class="notes">(If "Yes", please enter the number in the box below. If "No", this form may be returned for verification before being actioned.)</div>'; ?>
      <?= $this->Form->control('VATflag', [ 'type'=>'radio', 'options'=>$customer->yesnoOptions(), 'label'=>'Does the customer have an EU VAT registration number?', 'templates'=>$waf->template_wrappers('VATflag',$VATflag_notes,'spaced','radios') ] ) ?>
      <div id="vatcode_wrapper" class="inline_wrapper">
				<p>VAT Number</p>
				<?= $this->Form->control('countrycode', [ 'label'=>false, 'size'=>'2', 'maxlength'=>'2' ]) ?>
				<div>-</div>
				<?= $this->Form->control('custVAT', 		[ 'label'=>false, 'size'=>'13', 'maxlength'=>'13' ]) ?>
				<div class="notes">(e.g. FR - AB123456789 for a French company)</div>
      </div>

      <?= $this->Form->input('PDFinvoice', [ 'type'=>'radio', 'options'=>$customer->yesnoOptions(), 'label'=>'Does the organisation accept emailed pdf invoices?', 'templates'=>$waf->template_wrappers('PDFinvoice',$customer->spacer(),'spaced','radios') ] ) ?>
      <div id="pdfinvoice_wrapper">
        <?php $invoiceemail_notes = '<div class="notes">(NB: Normally a generic email address.)</div>'; ?>
				<?= $this->Form->control('invoiceemail', [ 'label'=>'Email for Invoices', 'default'=>$customer->invoiceemail, 'templates'=>$waf->template_wrappers('invoiceemail',$invoiceemail_notes) ]) ?>
				<?= $this->Form->control('statementemail', [ 'label'=>'Email for Statements', 'default'=>$customer->statementemail]) ?>
      </div>

      <?= $this->Form->control('billcontact', [ 'label'=>'Contact Name' ]) ?>
      <?= $this->Form->control('billposition', [ 'label'=>'Position' ]) ?>
      <?= $this->Form->control('billemail', [ 'label'=>'Email' ]) ?>
      <?= $this->Form->control('billphone', [ 'label'=>'Telephone' ]) ?>
      <?= $this->Form->control('billmobile', [ 'label'=>'Mobile' ]) ?>
      <?= $this->Form->control('billfax', [ 'label'=>'Fax' ]) ?>

      <?= $this->Form->control('billcopy', [ 'type'=>'radio', 'options'=>$customer->yesnoOptions(), 'value'=>$customer->billcopy, 'label'=>'Is the shipping address (for deliveries) the same as the billing address', 'templates'=>$waf->template_wrappers('billcopy',$customer->spacer(),'spaced','radios') ] ) ?>
      <div id="shipping_wrapper">
        <h4>Shipping (Delivery) Address</h4>
				<?= $this->Form->control('shipaddress1', [ 'label'=>'Line 1' ]) ?>
				<?= $this->Form->control('shipaddress2', [ 'label'=>'Line 2' ]) ?>
				<?= $this->Form->control('shipaddress3', [ 'label'=>'Line 3' ]) ?>
				<?= $this->Form->control('shipaddress4', [ 'label'=>'Line 4' ]) ?>
				<?= $this->Form->control('shiptown', [ 'label'=>'Town/City' ]) ?>
				<?= $this->Form->control('shipcounty', [ 'label'=>'County/State' ]) ?>
				<?= $this->Form->control('shippostcode', [ 'label'=>'Post/Zip Code' ]) ?>
				<?= $this->Form->control('shipdomcode', [ 'type'=>'select', 'options'=>$countries, 'label'=>'Country', 'default'=>'GB' ] ) ?>
      </div>
      <?= $this->Form->control('additional', [ 'type'=>'textarea', 'label'=>'Additional Details', 'rows'=>'5' ]); ?>

      <p>
        Please be advised that Credit Control do not currently have the facility to carry
        out credit checks on individuals, on this basis please confirm that you are happy
        to proceed with the application and that the necessary measures have been taken
        to reduce the University's risk exposure in this instance.
      </p>
      <?= $this->Form->control('creditcheck', [ 'type'=>'checkbox', 'label'=>'I agree' ] ); ?>
      <p>&nbsp;</p>

			<!-- Submit -->
			<?php
					echo $this->Form->button(__('Confirm'));
					echo $this->Form->button('Clear', [ 'type'=>'reset' ]);
			?>

		<?php
				echo $this->Form->end();
		?>

	</div>
</div>