<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = "Manion's Parts Location Lookup";
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
	</title>
	<?php
		echo $this->Html->script('jquery');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('selectize.min');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('selectize.bootstrap3');
		echo $this->Html->css('style');
	?>


</head>
<body>
	<div class="container">
  	<div class="row">
      <div class="col-md-12">
				<h1><?php echo $cakeDescription; ?></h1>
			</div>
    </div>
    <div class="row">
      <div class="col-md-10">
				<?php echo $this->fetch('content'); ?>
    	</div>
  		<div class="col-md-2">
			<?php
			echo $this->Html->link( "Part Lookup",   array('controller' => '', 'action'=>'index') );
			echo "<br>";
              if($this->Session->check('Auth.User')){
                  echo $this->Html->link( "List Users",   array('controller' => 'users', 'action'=>'index') );
                  echo "<br>";
                  echo $this->Html->link( "Logout",   array('controller' => 'users', 'action'=>'logout') );
                  echo  "<br>";
                  echo $this->Html->link( "Add A New User",   array('controller' => 'users', 'action'=>'add') );
									 echo  "<br>";
									 echo $this->Html->link( "Add A New Part",   array('controller' => 'add', 'action'=>'index') );
									 echo  "<br>";
                  echo $this->Html->link( "Import from CSV",   array('controller' => 'import', 'action'=>'index') );
									echo  "<br>";
								 echo $this->Html->link( "Export to CSV",   array('controller' => 'export', 'action'=>'index') );
              } else if ($this->params['controller'] == 'users' && $this->params['action'] == 'login' ){
                  //do nothing
              } else {
                  echo $this->Html->link( "Login",   array('controller' => 'users', 'action'=>'login') );
                  echo "<br>";
              }
          ?>
  		</div>
		</div>
	</div>
</body>

</html>
