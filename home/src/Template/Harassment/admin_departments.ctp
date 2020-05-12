<div class="row">
    <div class="waf-include">

        <?= $this->Form->create($admin) ?>
        <?php
            echo $this->Form->button(__('Users'), [ 'name'=>'action', 'value'=>'user_admin' ]);
            echo $this->Form->button('Departments', [ 'name'=>'action', 'value'=>'department_admin' ]);
            echo $this->Form->button(__('Download'), [ 'name'=>'action', 'value'=>'download_report' ]);
        ?>
        <?php echo $this->Form->end(); ?>

        <h3>Harassment Admin Users</h3>

        <table>
            <tbody>
                <tr><th>Name</th><th>Code</th><td><?php
                    echo $this->Form->create('department');
                    echo $this->Form->control('department_id', [ 'type'=>'hidden', 'value'=>$user->userID ]);
                    echo $this->Form->button('Add', [ 'name'=>'action', 'value'=>'add_department' ]);
                    echo $this->Form->end();
                ?></td></tr>
                <?php
                    foreach ($departments as $department) {
                        echo '<tr id="department'.$department['deptcode'].'">';
                        echo '<td>'.$department['deptalpha'].'</td>';
                        echo '<td>'.$department['deptcode'].'</td>';
                        echo '<td>';
                        echo $this->Form->create('department');
                        echo $this->Form->control('dept_code', [ 'type'=>'hidden', 'value'=>$department->deptcode ]);
                        echo $this->Form->button('Edit', [ 'name'=>'action', 'value'=>'edit_department' ]);
                        echo $this->Form->end();
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>