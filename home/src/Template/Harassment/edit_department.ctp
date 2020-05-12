<div class="row">
    <div class="waf-include">
        <h3>Harassment Admin Departments</h3>

        <?= $this->Form->create($edit_department) ?>
        <?= $this->Form->control('deptcode_original', [ 'type'=>'hidden', 'value'=>isset($department->deptcode)?$department->deptcode:'' ]) ?>
        <?= $this->Form->control('deptcode', [ 'type'=>'text', 'value'=>isset($department->deptcode)?$department->deptcode:'' ]) ?>
        <?= $this->Form->control('deptalpha', ['type'=>'text', 'label'=>'Name', 'default' => isset($department->deptalpha)?$department->deptalpha:'']); ?>

        <?php
            if(isset($department)) {
                echo $this->Form->button('Save', [ 'name'=>'action', 'value'=>'save_department' ]);
                echo $this->Form->button('Delete', [ 'name'=>'action', 'value'=>'delete_department' ]);
            }
            else {
                echo $this->Form->button('Add', [ 'name'=>'action', 'value'=>'save_department' ]);
            }
        ?>
        <?php echo $this->Form->end(); ?>

    </div>
</div>