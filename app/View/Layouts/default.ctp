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
		echo $this->Html->css('bootstrap.min');
	?>
    
    
</head>
<body>
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
				<h1><?php echo $cakeDescription; ?></h1>
			</div>
        </div>
		<?php echo $this->fetch('content'); ?>    
	</div>	
</body>



<script>

	$('#textInput').on('input', function() {
		var $this = $(this);
   		var delay = 1000; // 1 second delay after last input

    	clearTimeout($this.data('timer'));
    	$this.data('timer', setTimeout(function(){
        	$this.removeData('timer');

			$.ajax({
				url: '/parts/parts/fetch/' + $('#textInput').val(),
				cache: false,
				type: 'GET',
				dataType: 'JSON',
				success: function (data) {
					if (data.length > 0) {
						$('#tableContainer').removeClass('hidden');
						$('#noResults').addClass('hidden');
						$('#partNumber').html(data[0].Part.id);
						$('#partName').html(data[0].Part.PartName);
						$('#partNotes').html(data[0].Part.Notes);
						$('#partLocation').html('');
						var text = "<ul>";
						for (var x in data[0].Location) {
							text += "<li>" + data[0].Location[x].PartLocation + "</li>";
						}
						text += "</ul>";
						$('#partLocation').append(text);
					} else {
						$('#tableContainer').addClass('hidden');
						$('#noResults').removeClass('hidden');
					}
				}
			});
		}, delay));
		
		
		
	
	});
	
	</script>
</html>
