<div class="row">
    <div class="waf-include">
        <h3>Harassment Admin Users</h3>
        <?php $deptcode = $user['harassment_departments'][0]['deptcode']; ?>
        <?= $this->Form->create($edit_user) ?>
        <?= $this->Form->control('user_id', [ 'type'=>'hidden', 'value'=>isset($user->userID)?$user->userID:'' ]) ?>
        <?= $this->Form->control('name', ['type'=>'text', 'label'=>'Name', 'default' => isset($user->name)?$user->name:'']); ?>
        <?= $this->Form->control('SSO', ['type'=>'text', 'label'=>'SSO', 'default' => isset($user->oxfordID)?$user->oxfordID:'']); ?>
        <?= $this->Form->control('department', ['type'=>'select', 'options'=>$departments, 'empty'=>'-- Please Select --', 'label'=>'Department', 'default'=> isset($deptcode)?$deptcode:'']); ?>

        <?php
            if(isset($user)) {
                echo $this->Form->button('Save', [ 'name'=>'action', 'value'=>'save_user' ]);
                echo $this->Form->button('Delete', [ 'name'=>'action', 'value'=>'delete_user' ]);
            }
            else {
                echo $this->Form->button('Add', [ 'name'=>'action', 'value'=>'save_user' ]);
            }
        ?>
        <?php echo $this->Form->end(); ?>

    </div>
</div>