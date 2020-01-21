<!-- File: srv/Template/Gcp/index.ctp -->

<div class="row">

    <h3>
        GCP Online Application Admin
    </h3>
    <div class="waf-include">
        <ul>
        <?php foreach ($files as $i=>$file) { ?>
            <li><?= $file ?></li>
        <?php } ?>
        </ul>
    </div>
</div>
