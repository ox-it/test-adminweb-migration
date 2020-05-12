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
                <tr><th>Name</th><th>SSO</th><th>last login</th><th>Dept</th><td><?php
                    echo $this->Form->create('user');
                    echo $this->Form->control('user_id', [ 'type'=>'hidden', 'value'=>$user->userID ]);
                    echo $this->Form->button('Add', [ 'name'=>'action', 'value'=>'add_user' ]);
                    echo $this->Form->end();
                ?></td></tr>
                <?php
                    foreach ($users as $user) {
                        echo '<tr id="user'.$user['userID'].'">';
                        echo '<td>'.$user['name'].'</td>';
                        echo '<td>'.$user['oxfordID'].'</td>';
                        echo '<td>'.$user['lastlogin'].'</td>';
                        echo '<td>'.$user['harassment_departments'][0]->deptalpha.'</td>';
                        //echo '<td>'. $this->Form->postLink('Edit', [],['confirm' => 'Are you sure?', 'value' => 'sam']).'</td>';
                        //echo '<td>' . $this->Form->button('Delete', [ 'name'=>'action', 'value'=>'delete_user'.$user['userID'] ]); . '</td>';

                        echo '<td>';
                        echo $this->Form->create('user');
                        echo $this->Form->control('user_id', [ 'type'=>'hidden', 'value'=>$user->userID ]);
                        echo $this->Form->button('Edit', [ 'name'=>'action', 'value'=>'edit_user' ]);
                        echo $this->Form->end();
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>