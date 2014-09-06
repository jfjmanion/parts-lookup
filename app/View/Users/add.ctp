<div class="users form">
<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php echo $this->Form->input('username', array('class' => 'form-control', 'div' => array('class' => "form-group ".($this->Form->isFieldError('username') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))));
        echo $this->Form->input('email', array('class' => 'form-control',  'div' => array('class' => "form-group ".($this->Form->isFieldError('email') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))));
        echo $this->Form->input('password', array('class' => 'form-control', 'div' => array('class' => "form-group ".($this->Form->isFieldError('password') ? 'has-error' : '')),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))));
        echo $this->Form->input('password_confirm', array('class' => 'form-control', 'label' => 'Confirm Password', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password','div' => array('class' => "form-group ".($this->Form->isFieldError('password_confirm') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))));
        echo $this->Form->input('role', array(
            'options' => array( 'admin' => 'Admin'),'class' => 'form-control', 'div' => array('class' => "form-group ".($this->Form->isFieldError('role') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))
        ));
         
        echo $this->Form->submit('Add User', array('class' => 'btn btn-primary',  'title' => 'Click here to add the user') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
