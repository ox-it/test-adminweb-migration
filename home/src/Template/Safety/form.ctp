<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'WAF: Web-Application Framework';
?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
			<?= $cakeDescription ?>
	</title>

	<?= $this->Html->meta('icon') ?>
	<?= $this->Html->css('base.css') ?>
	<?= $this->Html->css('style.css') ?>
</head>
<body class="home">

<header class="row">
	<div class="header-image"><?= $this->Html->image('university.logo.svg') ?></div>
	<div class="header-title">
		<h1><?= $cakeDescription ?></h1>
	</div>
</header>

<div class="row">
  <div class="description">
    &gt; SafetyCourses &gt; form
  </div>
</div>

<div class="row">
	<div class="waf-include">

				 <!-- Course title -->
				 <br><h1></h1><br>




				 <!-- Description of the course and its benefits -->
				 <br><h3>Course Details</h3>

				 <p></p>

				 <hr size="1">


				 <!-- Dates and Booking section -->
				 <br><br /><h3>Dates</h3>There are currently no scheduled dates for this course.<br class="short_space"><p></p><br class="short_space">

				 <!-- Course contact details -->
				 <p>For further information contact <a href="mailto:"></a>.</p><br>


	</div>
</div>

</body>
</html>
