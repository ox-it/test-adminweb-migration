<?php
/**
 * Called from src/Controller/PrasController.php
 * Receives $data, $waf, $css
 */
?>

<p>&nbsp;</p>
<p>A new submission has been received from the PRAS Organisational Structure Change Form</p>
<p>&nbsp;</p>

<?php
	foreach ($data as $k => $v) {
		if (empty($v)) continue;
		if (in_array($k, ['stage','entity','info','safeType'])) continue;
		echo '<p>' . $k . ': <strong>' . $v . '</strong></p>' . "\n";
	}
?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

