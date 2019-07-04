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
    <?= $this->Html->css('home.css') ?>
</head>
<body class="home">

<header class="row">
    <div class="header-image"><?= $this->Html->image('university.logo.svg') ?></div>
    <div class="header-title">
        <h1>Welcome to the WAF: Web-Application Framework</h1>
    </div>
</header>

<div class="row">
  <div class="waf-include">
    <div class="column" align="center">
        <h4>NOTICE!</h4>
        <p>The <em><?= $_SERVER['SERVER_NAME']; ?></em> WAF may be set up wrong. Contact <a href="ssm-wet-team@maillist.ox.ac.uk ">sm-wet-team@maillist.ox.ac.uk </a> for more help.</p>
    </div>
  </div>
  <hr />
</div>

<div class="row">
    <div class="column" align="center">
        <h4>Apps</h4>
        <p>

          <?= $this->Html->link('PRAS', ['controller' => 'Pras']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'Pras', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JQUERY-MENU', ['controller' => 'Pras', 'action' => 'jquerymenu'], ['title' => 'JavaScript']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'Pras', 'action' => 'script'], ['title' => 'JavaScript']) ?> }<br>

          <?= $this->Html->link('Graduate Accommodation', ['controller' => 'GraduateAccommodation']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'GraduateAccommodation', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'GraduateAccommodation', 'action' => 'script'], ['title' => 'JavaScript']) ?> }<br>

          <?= $this->Html->link('Systems Availability', ['controller' => 'SystemsAvailability']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'SystemsAvailability', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('STYLE', ['controller' => 'SystemsAvailability', 'action' => 'style'], ['title' => 'CSS']) ?> }<br>

          <?= $this->Html->link('Job Vacancies', ['controller' => 'Jobs']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'Jobs', 'action' => 'css'], ['title' => 'CSS']) ?> }<br>

          <?= $this->Html->link('Finance Customers', ['controller' => 'FinanceCustomers']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'FinanceCustomers', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'FinanceCustomers', 'action' => 'script'], ['title' => 'JavaScript']) ?> }<br>

          <?= $this->Html->link('Finance Travel', ['controller' => 'FinanceTravel']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'FinanceTravel', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'FinanceTravel', 'action' => 'script'], ['title' => 'JavaScript']) ?> }<br>

          <?= $this->Html->link('Harassment', ['controller' => 'Harassment']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'Harassment', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'Harassment', 'action' => 'script'], ['title' => 'JavaScript']) ?> }<br>

          <?= $this->Html->link('GCP Online', ['controller' => 'Gcp']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'Gcp', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'Gcp', 'action' => 'script'], ['title' => 'JavaScript']) ?> }<br>

          <?= $this->Html->link('Safety', ['controller' => 'Safety']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'Safety', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'Safety', 'action' => 'script'], ['title' => 'JavaScript']) ?> }<br>

          <?= $this->Html->link('TRAC', ['controller' => 'Trac']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'Trac', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'Trac', 'action' => 'script'], ['title' => 'JavaScript']) ?> }<br>

          <?= $this->Html->link('Staff Search', ['controller' => 'StaffSearch']) ?>
            | <?= $this->Html->link('Small Version', ['controller' => 'StaffSearch', 'action' => 'small']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'StaffSearch', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('FA', '//use.fontawesome.com/releases/v5.8.2/css/all.css', ['title' => 'Add to CSS if not already on page', 'target' => '_blank']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'StaffSearch', 'action' => 'script'], ['title' => 'JavaScript']) ?> } &nbsp; &nbsp;
           <?= $this->Html->link('JS Only Version', ['controller' => 'StaffSearch', 'action' => 'jsonly']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'StaffSearch', 'action' => 'css'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('FA', '//use.fontawesome.com/releases/v5.8.2/css/all.css', ['title' => 'Add to CSS if not already on page', 'target' => '_blank']) ?>
            : <?= $this->Html->link('STYLE', ['controller' => 'StaffSearch', 'action' => 'style'], ['title' => 'CSS']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'StaffSearch', 'action' => 'jsonlyscript'], ['title' => 'JavaScript']) ?> }<br>

        </p>

    <hr />

        <p>

          <span class="not-in-use"><?= $this->Html->link('AAD Conference', ['controller' => 'AADConference']) ?> (Incomplete)</span><br>
          <span class="not-in-use"><?= $this->Html->link('Orientation', ['controller' => 'Orientation']) ?></span><br>
          <span class="not-in-use"><?= $this->Html->link('AAD Events', ['controller' => 'AADEvents']) ?></span><br>
          <span class="not-in-use"><?= $this->Html->link('UAS Events', ['controller' => 'UASEvents']) ?><span><br>
          <span class="not-in-use"><?= $this->Html->link('Access Search', ['controller' => 'AccessSearch']) ?></span><br>

        </p>
    </div>
    <hr />
</div>

</body>
</html>
