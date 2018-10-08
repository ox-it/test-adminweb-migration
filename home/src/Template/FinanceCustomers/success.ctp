<!-- File: src/Template/FinanceCustomers/success.ctp -->

<div class="row">

	<h3>
		Finance Customer Registration Form Success
	</h3>

  <?php
		// echo '<textarea rows="12" style="line-height: 1.1em;font-size:0.7em">' . print_r($customer, true) . '</textarea>';
	?>

	<div class="waf-include">

		<div class="noprint">
		<p>Thank you for your Customer Set-up request. This will be completed within
			 one working day.  If you would like to keep a copy of the information entered,
			 please print this page. If you would like to repeat this process for another
			 customer, please click the "Another Set-up" button below.  Otherwise, please
			 click "Start Again" to return to the empty Customer Set-up page.</p>

		<p>The following information has been recorded:</p>
		</div>

		<!-- This form covers the two submission buttons on this page -->
		<?= $this->Form->create($customer, [ 'type'=>'file', 'context'=>[ 'validator'=>'register' ], 'novalidate'=>true ]) ?>

    <h4>Your Details</h4>
    <?php
      // Save these to pass to start another submission
      echo $this->Form->control('forename', [ 'type'=>'hidden' ]);
		  echo $this->Form->control('surname', [ 'type'=>'hidden' ]);
		  echo $this->Form->control('phone', [ 'type'=>'hidden' ]);
		  echo $this->Form->control('email', [ 'type'=>'hidden' ]);
		  echo $this->Form->control('deptcode', [ 'type'=>'hidden' ]);
		  echo $this->Form->control('depttext', [ 'type'=>'hidden' ]);
		  echo $this->Form->control('another', [ 'type'=>'hidden', 'value'=>'another' ]);


		  echo $waf->postValueWithLabel($customer->surname, 'Surname');
		  echo $waf->postValueWithLabel($customer->forename, 'Forename');
		  echo $waf->postValueWithLabel($customer->phone, 'Telephone');
		  echo $waf->postValueWithLabel($customer->email, 'Email');
		  echo $waf->postValueWithLabel($customer->deptcode, 'Department', $departments);
		  echo $waf->postValueWithLabel($customer->depttext, 'Department');
    ?>

    <h4>Customer Details</h4>
    <?php
      echo $waf->postValueWithLabel((!empty($customer->custtitle)?$customer->custtitle.' ':'') . $customer->custname, 'Customer Name');
		  echo $waf->postValueWithLabel($customer->accounttype, 'Account Type', $customer->accounttypeOptions());
		  echo $waf->postValueWithLabel($customer->acountnum, 'Account Number');
		  echo $waf->postValueWithLabel($customer->custparent, 'Parent Company');
		  echo $waf->postValueWithLabel($customer->custURL, 'Company Website');
		  echo $waf->postValueWithLabel($customer->category, 'Category', $customer->categoryOptions());
		  echo $waf->postValueWithLabel($customer->custtype, 'Customer Type', $customer->custtypeOptions());
    ?>

    <h4>Conditions of Sale</h4>
    <?php
		  echo $waf->postValueWithLabel($customer->payterms, 'Payment Terms', $customer->paytermsOptions());
		  echo $waf->postValueWithLabel($customer->paytermsother, 'Payment Terms Details');
		  echo $waf->postValueWithLabel($customer->transaction, 'Value of transaction');
		  if (!empty($customer->POfile)) echo $waf->postValueWithLabel(' ', 'A PO document has been uploaded to accounts receivable.');
    ?>

    <h4>Billing Details</h4>
    <?php
		  echo $waf->postValueWithLabel($customer->billaddress1, 'Address');
		  echo $waf->postValueWithLabel($customer->billaddress2, ' ');
		  echo $waf->postValueWithLabel($customer->billaddress3, ' ');
		  echo $waf->postValueWithLabel($customer->billaddress4, ' ');
		  echo $waf->postValueWithLabel($customer->billtown, ' ');
		  echo $waf->postValueWithLabel($customer->billcounty, ' ');
		  echo $waf->postValueWithLabel($customer->billpostcode, ' ');
		  echo $waf->postValueWithLabel($customer->billdomcode, ' ', $countries);
		  echo $waf->postValueWithLabel($customer->billcontact, 'Contact');
		  echo $waf->postValueWithLabel($customer->billposition, 'Position');
		  echo $waf->postValueWithLabel($customer->billemail, 'Email');
		  echo $waf->postValueWithLabel($customer->billphone, 'Telephone');
		  echo $waf->postValueWithLabel($customer->billmobile, 'Mobile');
		  echo $waf->postValueWithLabel($customer->billfax, 'Fax');
    ?>

    <p>&nbsp;</p>
    <?php
		  echo $waf->postValueWithLabel($customer->invoiceemail, 'Email for invoices');
		  echo $waf->postValueWithLabel($customer->statementemail, 'Email for Statement');
		  if (!empty($customer->countrycode) || !empty($customer->custVAT)) echo $waf->postValueWithLabel($customer->countrycode . ' ' . $customer->custVAT, 'VAT Number');
    ?>

    <?php
      if (!empty($customer->billcopy) && $customer->billcopy=='N') {
        echo '<h4>Shipping Details</h4>' . "\n";
				echo $waf->postValueWithLabel($customer->shipaddress1, 'Address');
				echo $waf->postValueWithLabel($customer->shipaddress2, ' ');
				echo $waf->postValueWithLabel($customer->shipaddress3, ' ');
				echo $waf->postValueWithLabel($customer->shipaddress4, ' ');
				echo $waf->postValueWithLabel($customer->shiptown, ' ');
				echo $waf->postValueWithLabel($customer->shipcounty, ' ');
				echo $waf->postValueWithLabel($customer->shippostcode, ' ');
				echo $waf->postValueWithLabel($customer->shipdomcode, ' ', $countries);
				echo $waf->postValueWithLabel($customer->shipcontact, 'Contact');
				echo $waf->postValueWithLabel($customer->shipposition, 'Position');
				echo $waf->postValueWithLabel($customer->shipemail, 'Email');
				echo $waf->postValueWithLabel($customer->shipphone, 'Telephone');
				echo $waf->postValueWithLabel($customer->shipmobile, 'Mobile');
				echo $waf->postValueWithLabel($customer->shipfax, 'Fax');
		  } else {
        echo '<p>&nbsp;</p>' . "\n";
        echo $waf->postValueWithLabel(' ', 'The shipping address is the same as the billing address.');
		  }
    ?>

    <p>&nbsp;</p>
    <?php
		  echo $waf->postValueWithLabel($customer->additional, 'Additional Information');
    ?>

		<!-- Submit -->
		<?php
			echo $this->Form->button(__('Another Set-up'));
			echo $waf->postButtonToReferer($this, 'Start Again');
		?>

		<?php
			echo $this->Form->end();
		?>

	</div>
</div>