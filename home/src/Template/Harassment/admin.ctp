<div class="row">
    <div class="waf-include">
        <h3>Harassment Admin</h3>
        <?= $this->Form->create($admin) ?>
        <?php
            echo $this->Form->button(__('Users'), [ 'name'=>'action', 'value'=>'user_admin' ]);
            echo $this->Form->button('Departments', [ 'name'=>'action', 'value'=>'department_admin' ]);
            echo $this->Form->button(__('Surveys'), [ 'name'=>'action', 'value'=>'download_report' ]);
        ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>