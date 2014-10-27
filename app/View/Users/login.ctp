<div class="users form">
<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Please Enter Your Username and Password'); ?></legend>
        <?php echo $this->Form->input('username', array('class' => "form-control", 'div' => array('class' => "form-group ".($this->Form->isFieldError('username') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))));
        echo $this->Form->input('password', array('class' => "form-control", 'div' => array('class' => "form-group ".($this->Form->isFieldError('password') ? 'has-error' : '') ),
			'error' => array('attributes' => array('wrap' => 'p', 'class' => 'help-block has-error'))));
  		echo $this->Form->submit('Login', array('class' => 'btn btn-primary',  'title' => 'Login') );
    ?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
