<div class="users form">
<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Edit User'); ?></legend>
        <?php 
        echo $this->Form->hidden('id', array('value' => $this->data['User']['id']));
        echo $this->Form->input('username', array( 'readonly' => 'readonly', 'label' => 'Username (Cannot be changed)', 'class' => 'form-control', 'div' => array('class' => "form-group")));
		
		echo $this->Form->input('email',
   	 	array(
			'label' => array('text' => 'Email', 'class' => 'strong'), 'placeholder' => "Your email", 'class' => 'form-control', 
			'div' => array('class' => "form-group ".($this->Form->isFieldError('email') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))
        ));
		
		echo $this->Form->input('password_update',
   	 		array('required' => 0, 'type'=>'password', 'maxLength' => 255,
			'label' => array('text' => 'New Password (Leave empty if you do not want to change)', 'class' => 'strong'), 'placeholder' => "New Password", 'class' => 'form-control', 
			'div' => array('class' => "form-group ".($this->Form->isFieldError('password_update') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))
        ));
		
		echo $this->Form->input('password_confirm_update',
   	 		array('required' => 0, 'type'=>'password', 'maxLength' => 255,
			'label' => array('text' => 'Confirm New Password', 'class' => 'strong'), 'placeholder' => "Confirm New Password", 'class' => 'form-control', 
			'div' => array('class' => "form-group ".($this->Form->isFieldError('password_confirm_update') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))
        ));
		
		echo $this->Form->input('role',
   	 		array( 'options' => array( 'admin' => 'Admin'),
			'label' => array('text' => 'Role', 'class' => 'strong'), 'class' => 'form-control', 
			'div' => array('class' => "form-group ".($this->Form->isFieldError('role') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))
        ));
		
        echo $this->Form->submit('Edit User', array('class' => 'btn btn-primary',  'title' => 'Click here to add the user') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
