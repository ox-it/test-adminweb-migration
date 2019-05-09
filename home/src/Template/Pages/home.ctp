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
    <div class="column" align="center">
        <h4>HELP!</h4>
        <p>It looks like the <em><?= $_SERVER['SERVER_NAME']; ?></em> WAF is set up wrong. Contact <a href="waf@it.ox.ac.uk">waf@it.ox.ac.uk</a> for more help.</p>
    </div>
    <hr />
</div>

<div class="row">
    <div class="column" align="center">
        <h4>Apps</h4>
        <p>
          <?= $this->Html->link('Pras', ['controller' => 'Pras']) ?><br>
          <?= $this->Html->link('Graduate Accommodation', ['controller' => 'GraduateAccommodation']) ?><br>
          <?= $this->Html->link('Systems Availability', ['controller' => 'SystemsAvailability']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'SystemsAvailability', 'action' => 'css']) ?>
            : <?= $this->Html->link('STYLE', ['controller' => 'SystemsAvailability', 'action' => 'style']) ?> }<br>
          <?= $this->Html->link('Job Vacancies', ['controller' => 'Jobs']) ?><br>
          <?= $this->Html->link('AAD Conference', ['controller' => 'AADConference']) ?> (Incomplete)<br>
          <?= $this->Html->link('AAD Events', ['controller' => 'AADEvents']) ?><br>
          <?= $this->Html->link('Finance Customers', ['controller' => 'FinanceCustomers']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'FinanceCustomers', 'action' => 'css']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'FinanceCustomers', 'action' => 'script']) ?> }<br>
          <?= $this->Html->link('Finance Travel', ['controller' => 'FinanceTravel']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'FinanceTravel', 'action' => 'css']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'FinanceTravel', 'action' => 'script']) ?> }<br>
          <?= $this->Html->link('Harassment', ['controller' => 'Harassment']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'Harassment', 'action' => 'css']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'Harassment', 'action' => 'script']) ?> }<br>
          <?= $this->Html->link('Orientation', ['controller' => 'Orientation']) ?><br>
          <?= $this->Html->link('GCP Online', ['controller' => 'Gcp']) ?><br>
          <?= $this->Html->link('Safety', ['controller' => 'Safety']) ?><br>
          <?= $this->Html->link('TRAC', ['controller' => 'Trac']) ?><br>
          <?= $this->Html->link('UAS Events', ['controller' => 'UASEvents']) ?><br>
          <?= $this->Html->link('Access Search', ['controller' => 'AccessSearch']) ?><br>
          <?= $this->Html->link('Staff Search', ['controller' => 'StaffSearch']) ?>
            | <?= $this->Html->link('Small Version', ['controller' => 'StaffSearch', 'action' => 'small']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'StaffSearch', 'action' => 'css']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'StaffSearch', 'action' => 'script']) ?> } &nbsp; &nbsp;
           <?= $this->Html->link('JS Only Version', ['controller' => 'StaffSearch', 'action' => 'jsonly']) ?>
            { <?= $this->Html->link('CSS', ['controller' => 'StaffSearch', 'action' => 'css']) ?>
            : <?= $this->Html->link('STYLE', ['controller' => 'StaffSearch', 'action' => 'style']) ?>
            : <?= $this->Html->link('JS', ['controller' => 'StaffSearch', 'action' => 'jsonlyscript']) ?> }<br>
        </p>
    </div>
    <hr />
</div>

</body>
</html>
