<div class="action-user">
    <?php echo $html->link(__('Manage User', true), array('action'=>'index'), array('class'=>'user-link')); ?>
</div>

<div class="action-auth">
    <fieldset>
        <h2><?php __('View User');?></h2>
        <table class="input">
            <tr>
                <td id="title-info">Username</td>
                <td><?php echo $html->div('info', $this->data['User']['username']); ?></td>
            </tr>
            <tr>
                <td id="title-info">Name</td>
                <td><?php echo $html->div('info', $this->data['User']['realname']); ?></td>
            </tr>
            <tr>
                <td id="title-info">Email</td>
                <td><?php echo $html->div('info', $this->data['User']['email']); ?></td>
            </tr>
            <tr>
                <td id="title-info">Status</td>
                <td><?php echo $html->div('info', ($this->data['User']['active']==1)? 'Active' : 'Inactive' ); ?></td>
            </tr>
            <tr>
                <td id="title-info">Created</td>
                <td><?php echo $html->div('info', $time->format('d-m-Y H:i:s', $this->data['User']['created'])); ?></td>
            </tr>
            <tr>
                <td id="title-info">Modified</td>
                <td><?php echo $html->div('info', $time->format('d-m-Y H:i:s', $this->data['User']['modified'])); ?></td>
            </tr>
        </table>
    </fieldset>
</div>