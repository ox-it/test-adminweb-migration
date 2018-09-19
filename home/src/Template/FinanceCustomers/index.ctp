<!-- File: src/Template/FinanceCustomers/index.ctp -->

<?php
  $spacer = '<div class="spacer">&nbsp;</div>';
  $categoryOptions = [ 'O'=>'Organization', 'P'=>'Person' ];
  $accounttypeOptions = [ 'N'=>'New Account', 'A'=>'Additional Site', 'E'=>'Amendment to Existing Site' ];
  $custtypeOptions = [ 'U'=>'UK Commercial', 'F'=>'Foreign Commercial', 'E'=>'Employee', 'S'=>'Student' ];
  $paytermsOptions = [ 'I'=>'Immediate', 'D'=>'30 Days', 'O'=>'Other' ];
  $yesnoOptions = [ 'Y'=>'Yes', 'N'=>'No' ];

  function template_wrappers($field, $notes='', $classes=[]) {
    return [
			'inputContainer'=>'<div id="'.$field.'_wrapper" class="input {{type}}{{required}} '.implode(' ',$classes).'">{{content}}'.$notes.'</div>',
			'inputContainerError'=>'<div id="'.$field.'_wrapper" class="input {{type}}{{required}} '.implode(' ',$classes).' error">{{content}}{{error}}'.$notes.'</div>'
    ];
  }
?>

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
			<?= $this->Form->control('forename', [ 'label'=>'First name', 'default'=>$customer->forename]) ?>
			<?= $this->Form->control('surname', [ 'label'=>'Surname', 'default'=>$customer->surname]) ?>
			<?= $this->Form->control('phone', [ 'label'=>'Telephone', 'default'=>$customer->phone]) ?>
			<?= $this->Form->control('email', [ 'label'=>'Email', 'default'=>$customer->email]) ?>
			<?= $this->Form->input('deptcode', [ 'type'=>'select', 'options'=>$departments, 'empty'=>'-- Please select if appropriate --', 'label'=>'Department/Faculty' ], [ 'val'=>$customer->deptcode]) ?>
			<?= $this->Form->control('depttext', [ 'label'=>'Department/Faculty Details (please specify)', 'templates'=>template_wrappers('depttext') ]) ?>

			<hr class="line">

			<!-- Customer Details -->
			<h4>
				Customer Details
			</h4>
			<?= $this->Form->input('category', [ 'type'=>'radio', 'class'=>'with-notes', 'options'=>$categoryOptions, 'label'=>'Customer Category', 'templates'=>template_wrappers('category', $spacer) ], [ 'val'=>$customer->category ]) ?>
			<?php	$custname_notes = '<div class="notes">(Full trading name and legal status for Organisation responsible for payment, e.g. A Customer PLC. If an Individual, please provide their full name)</div>'; ?>
			<?= $this->Form->control('custname', [ 'label'=>'Name', 'class'=>'with-notes', 'default'=>$customer->custname, 'templates'=>template_wrappers('custname',$custname_notes) ]) ?>
			<?= $this->Form->control('custtitle', [ 'label'=>'Title', 'default'=>$customer->title, 'templates'=>template_wrappers('custtitle') ]) ?>
			<?= $this->Form->input('accounttype', [ 'type'=>'select', 'options'=>$accounttypeOptions, 'label'=>'Account Type' ], [ 'val'=>$customer->accounttype]) ?>
			<?php $accountnum_notes = '<div class="notes">(Additional or Existing sites)</div>'; ?>
			<?= $this->Form->control('accountnum', [ 'label'=>'Customer Account No.', 'class'=>'with-notes', 'default'=>$customer->accountnum, 'templates'=>template_wrappers('accountnum',$accountnum_notes) ]) ?>
			<?= $this->Form->control('custURL', [ 'label'=>'Company Website', 'default'=>$customer->phone]) ?>
			<?php	$custparent_notes = '<div class="notes">(if applicable)</div>'; ?>
			<?= $this->Form->control('custparent', [ 'label'=>'Parent Company', 'class'=>'with-notes', 'default'=>$customer->phone, 'templates'=>template_wrappers('accountnum',$custparent_notes) ]) ?>
			<?= $this->Form->input('custtype', [ 'type'=>'select', 'options'=>$custtypeOptions, 'empty'=>'-- Please select --', 'label'=>'Customer Type' ], [ 'val'=>$customer->custtype]) ?>

			<!-- Conditions of Sale and Credit Review -->
			<h4>
				Conditions of Sale and Credit Review
			</h4>
      <?= $this->Form->input('payterms', [ 'type'=>'select', 'options'=>$paytermsOptions, 'empty'=>'-- Please select --', 'label'=>'Payment Terms' ], [ 'val'=>$customer->payterms]) ?>
			<?= $this->Form->control('paytermsother', [ 'label'=>'Please specify custom payment terms', 'default'=>$customer->paytermsother, 'templates'=>template_wrappers('paytermsother') ]) ?>
			<?php $sendcon_notes = '<div class="notes">(Departments are responsible for ensuring customers receive a copy of the University\'s Standard Conditions of Sale and Supply)</div>'; ?>
      <?=  $this->Form->input('sendcon', [ 'type'=>'radio', 'class'=>'with-notes', 'options'=>$yesnoOptions, 'label'=>'Have Conditions of Sale and Supply been provided to your Customer?', 'templates'=>template_wrappers('sendcon',$sendcon_notes) ], [ 'val'=>$customer->sendcon]) ?>
			<?php	$transaction_notes = '<div class="notes">(Approximate value of 6 week\'s supply. Required for Credit Checking where appropriate.)</div>'; ?>
			<?= $this->Form->control('transaction', [ 'type'=>'number', 'label'=>'Value of proposed Transaction(s) in Pounds Sterling (£)', 'class'=>'with-notes', 'default'=>$customer->transaction, 'templates'=>template_wrappers('transaction',$transaction_notes) ]) ?>
      <?= $this->Form->input('POupload', [ 'type'=>'radio', 'class'=>'with-notes', 'options'=>$yesnoOptions, 'label'=>'Copy of Customer PO sent to AR?' ], [ 'val'=>$customer->POupload]) ?>
			<?= $this->Form->control('POfile', [ 'type'=>'file', 'label'=>'If "Yes", please upload: the PO here', 'templates'=>template_wrappers('POfile') ]) ?>

			<!-- Billing (Invoice) Address  -->
			<h4>
				Billing (Invoice) Address
			</h4>
      <?= $this->Form->control('billaddress1', [ 'label'=>'Line 1', 'default'=>$customer->billaddress1]) ?>
			<?= $this->Form->control('billaddress2', [ 'label'=>'Line 2', 'default'=>$customer->billaddress2]) ?>
			<?= $this->Form->control('billaddress3', [ 'label'=>'Line 3', 'default'=>$customer->billaddress3]) ?>
			<?= $this->Form->control('billaddress4', [ 'label'=>'Line 4', 'default'=>$customer->billaddress4]) ?>
			<?= $this->Form->control('billtown', [ 'label'=>'Town/City', 'default'=>$customer->billtown]) ?>
			<?= $this->Form->control('billcounty', [ 'label'=>'County/State', 'default'=>$customer->billcounty]) ?>
			<?= $this->Form->control('billpostcode', [ 'label'=>'Post/Zip Code', 'default'=>$customer->billpostcode]) ?>
      <?= $this->Form->input('billdomcode', [ 'type'=>'select', 'options'=>$countries, 'label'=>'Country', 'default'=>'GB' ], [ 'val'=>$customer->billdomcode]) ?>
      <?php $VATflag_notes = '<div class="notes">(If "Yes", please enter the number in the box below. If "No", this form may be returned for verification before being actioned.)</div>'; ?>
      <?= $this->Form->input('VATflag', [ 'type'=>'radio', 'class'=>'with-notes', 'options'=>$yesnoOptions, 'label'=>'Does the customer have an EU VAT registration number?', 'templates'=>template_wrappers('VATflag',$VATflag_notes) ], [ 'val'=>$customer->VATflag]) ?>
      <div id="vatcode_wrapper" class="inline_wrapper">
				<p>VAT Number</p>
				<?= $this->Form->control('countrycode', [ 'label'=>false, 'class'=>'inline', 'size'=>'2', 'maxlength'=>'2', 'default'=>$customer->transaction]) ?>
				<div>-</div>
				<?= $this->Form->control('custVAT', [ 'label'=>false, 'class'=>'inline', 'size'=>'13', 'maxlength'=>'13', 'default'=>$customer->custVAT]) ?>
				<div class="notes">(e.g. FR - AB123456789 for a French company)</div>
      </div>

      <?= $this->Form->input('PDFinvoice', [ 'type'=>'radio', 'class'=>'with-notes', 'options'=>$yesnoOptions, 'label'=>'Does the organisation accept emailed pdf invoices?', 'templates'=>template_wrappers('PDFinvoice',$spacer) ], [ 'val'=>$customer->PDFinvoice]) ?>
      <div id="pdfinvoice_wrapper">
        <?php $invoiceemail_notes = '<div class="notes">(NB: Normally a generic email address.)</div>'; ?>
				<?= $this->Form->control('invoiceemail', [ 'label'=>'Email for Invoices', 'class'=>'with-notes', 'default'=>$customer->invoiceemail, 'templates'=>template_wrappers('invoiceemail',$invoiceemail_notes) ]) ?>
				<?= $this->Form->control('statementemail', [ 'label'=>'Email for Statements', 'default'=>$customer->statementemail]) ?>
      </div>

      <?= $this->Form->control('billcontact', [ 'label'=>'Contact Name', 'default'=>$customer->billcontact]) ?>
      <?= $this->Form->control('billposition', [ 'label'=>'Position', 'default'=>$customer->billposition]) ?>
      <?= $this->Form->control('billemail', [ 'label'=>'Email', 'default'=>$customer->billemail]) ?>
      <?= $this->Form->control('billphone', [ 'label'=>'Telephone', 'default'=>$customer->billphone]) ?>
      <?= $this->Form->control('billmobile', [ 'label'=>'Mobile', 'default'=>$customer->billmobile]) ?>
      <?= $this->Form->control('billfax', [ 'label'=>'Fax', 'default'=>$customer->billfax]) ?>

      <?= $this->Form->input('billcopy', [ 'type'=>'radio', 'class'=>'with-notes', 'options'=>$yesnoOptions, 'label'=>'Is the shipping address (for deliveries) the same as the billing address', 'templates'=>template_wrappers('billcopy',$spacer) ], [ 'val'=>$customer->billcopy]) ?>
      <div id="shipping_wrapper">
        <h4>Shipping (Delivery) Address</h4>
				<?= $this->Form->control('shipaddress1', [ 'label'=>'Line 1', 'default'=>$customer->shipaddress1]) ?>
				<?= $this->Form->control('shipaddress2', [ 'label'=>'Line 2', 'default'=>$customer->shipaddress2]) ?>
				<?= $this->Form->control('shipaddress3', [ 'label'=>'Line 3', 'default'=>$customer->shipaddress3]) ?>
				<?= $this->Form->control('shipaddress4', [ 'label'=>'Line 4', 'default'=>$customer->shipaddress4]) ?>
				<?= $this->Form->control('shiptown', [ 'label'=>'Town/City', 'default'=>$customer->shiptown]) ?>
				<?= $this->Form->control('shipcounty', [ 'label'=>'County/State', 'default'=>$customer->shipcounty]) ?>
				<?= $this->Form->control('shippostcode', [ 'label'=>'Post/Zip Code', 'default'=>$customer->shippostcode]) ?>
				<?= $this->Form->input('shipdomcode', [ 'type'=>'select', 'options'=>$countries, 'label'=>'Country', 'default'=>'GB' ], [ 'val'=>$customer->shipdomcode]) ?>
      </div>
      <?= $this->Form->control('additional', [ 'type'=>'textarea', 'label'=>'Additional Details', 'rows'=>'5' ]); ?>

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