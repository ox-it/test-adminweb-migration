<?php
/**
 * Called from src/Controller/FinanceCustomersController.php
 * Receives $customer
 */
?>

<p><em>A request for a new customer account has been recieved from:</em></p>
<p>&nbsp;</p>


<h4>Your Details</h4>
<?php
	echo $waf->postValueWithLabel($customer->surname, 'Surname');
	echo $waf->postValueWithLabel($customer->forename, 'Forename');
	echo $waf->postValueWithLabel($customer->department, 'Department');
	echo $waf->postValueWithLabel($customer->email, 'Email');
	echo $waf->postValueWithLabel($customer->phone, 'Telephone');
	//echo $waf->postValueWithLabel($customer->depttext, 'Department');
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

<h4>Payment</h4>
<?php
	echo $waf->postValueWithLabel($customer->payterms, 'Payment Terms', $customer->paytermsOptions());
	echo $waf->postValueWithLabel($customer->paytermsother, 'Payment Terms Details');
	echo $waf->postValueWithLabel($customer->sendcon, 'Conditions of Sale to be sent by AR?', $customer->yesnoOptions());
	echo $waf->postValueWithLabel($customer->transaction, 'Value of Proposed Transaction(s)');
	echo empty($customer->POfile) ? 'No PO file uploaded' : 'A PO document has been uploaded';
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
	echo $waf->postValueWithLabel($customer->billcountry, ' ');
	echo $waf->postValueWithLabel($customer->billcontact, 'Contact');
	echo $waf->postValueWithLabel($customer->billposition, 'Position');
	echo $waf->postValueWithLabel($customer->billemail, 'Email');
	echo $waf->postValueWithLabel($customer->billphone, 'Telephone');
	echo $waf->postValueWithLabel($customer->billmobile, 'Mobile');
	echo $waf->postValueWithLabel($customer->billfax, 'Fax');
?>

<p>&nbsp;</p>
<?php
  if (!empty($customer->PDFinvoice) && $customer->PDFinvoice=='Y') {
	  echo $waf->postValueWithLabel($customer->invoiceemail, 'Email for PDF invoices');
  	echo $waf->postValueWithLabel($customer->statementemail, 'Email for PDF statements');
	} else {
	  echo $waf->postValueWithLabel('This Customer does not accept emailed PDF invoices', 'PDF Invoices');
	}

  if (!empty($customer->EUVAT) && $customer->EUVAT=='Y') {
    if (!empty($customer->countrycode) && !empty($customer->custVAT)) {
	    echo $waf->postValueWithLabel($customer->countrycode.' - '.$customer->custVAT, 'VAT Number');
	  } else {
  	  echo $waf->postValueWithLabel('No VAT Number', 'VAT Number');
	  }
	} else {
	  echo $waf->postValueWithLabel('WARNING - This Customer is NOT registered for VAT', 'VAT Number');
	}
?>

<h4>Shipping Details</h4>
<?php
	if (!empty($customer->billcopy) && $customer->billcopy=='Y') {
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
	  echo '<p>Same as billing details</p>' . "\n";
	}
?>

<p>&nbsp;</p>
<?php
	echo $waf->postValueWithLabel($customer->additional, 'Additional Information');
?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

