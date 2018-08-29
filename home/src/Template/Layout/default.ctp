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
	<?= $this->Html->css('waf.css') ?>
	<?= $this->Html->css('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css') ?>

	<?= $this->Html->script('http://code.jquery.com/jquery-latest.min.js') ?>
	<?= $this->Html->script('http://code.jquery.com/ui/1.12.1/jquery-ui.js') ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>

</head>
<body class="home">

	<header class="row">
		<div class="header-image"><?= $this->Html->image('university.logo.svg') ?></div>
		<div class="header-title">
			<h1><?= $cakeDescription ?></h1>
		</div>
	</header>

	<div class="row" id="waf-infobar">
		<div class="description">
			&gt; <?= $this->name ?> &gt; <?= $this->template ?>
		</div>
	</div>

	<div class="row" id="waf-message">
	  <?= $this->Flash->render() ?>
	</div>

	<div class="container clearfix">
	  <div class="web-app-wrapper"><?php // This is used to mimic the wrapper class in Mosaic ?>
			<?= $this->fetch('content') ?>
		</div>
	</div>

	<footer>
	</footer>

</body>
</html>
