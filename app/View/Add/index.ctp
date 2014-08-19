<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */


?>


<div class="row">
<div class="col-md-12">
<form action="/" id="addForm">
    <?php echo $this->Form->input('Part.Id', array('id' => 'id', 'class' => 'form-control', 'label' =>'Part ID')); ?>
   	<?php echo $this->Form->input('Part.PartName', array('id' => 'PartName', 'class' => 'form-control')); ?>
    <div id="location0">
    <?php echo $this->Form->input('Location.0.PartLocation', array('div' => false, 'id' => 'PartLocation0', 'class' => 'form-control')); ?>
    <?php echo $this->Form->hidden('Location.0.Part_id', array('id' => 'LocationPartId0')); ?>
	</div>
    
    <button type="button" class="btn btn-info btn-sm" name="addLocation" id="addLocation"><span class="glyphicon glyphicon-plus"></span></button>
    <button type="button" class="btn btn-danger btn-sm hidden" name="removeLocation" id="removeLocation"><span class="glyphicon glyphicon-minus"></span></button>
    
    
    
	<?php echo $this->Form->input('Part.PartNotes', array('id' => 'PartNotes', 'class' => 'form-control')); ?>
 
    <?php echo $this->Form->end(array('label' => 'Add Part',
    'name' => 'Update',
    'class' => 'btn btn-primary',
	'id' => 'partAdd'
    )); ?>
</form>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div id="results">
</div>
</div>
</div>


<script>

//add more locations
var i = $('#location0').size() - 1;

	$('#removeLocation').click(function(){
		//if there are 2, then remove the button as it will be 1 afterwords
		if($("input[type=hidden]").size() == 2){
			$(this).addClass('hidden');	
		}
		$('#location' + i.toString()).remove();
		i--;	
	});

	$('#addLocation').click(function(){
		var v = i + 1;
		var labelValue = v + 1;
		var clone = $('#location' + i.toString()).clone();
		
		clone.attr('id', 'location' + v.toString());
		
		$('#location' + i.toString()).after(clone);
		clone.children('input').each(function() {
			$(this).attr('id', 'partLocation' + v.toString());	
		});
		
		clone.children('input[type=text]').attr('name', 'data[Location][' + v.toString() + '][PartLocation]');
		clone.children('input[type=text]').val('');
		clone.children('input[type=hidden]').attr('name', 'data[Location][' + v.toString() + '][Part_id]');
		clone.children('label').html($('#location0 label').html() + " " + labelValue.toString());
		clone.children('label').attr('for', 'partLocation' + v.toString());
		i++;
		$('#removeLocation').removeClass('hidden');
	});

//update the id on the hidden values when adding Id text
    $('#id').on('input', function() {
		$("input[type=hidden]").each(function() {
     		$(this).val($('#id').val())
		});
	});

	$('#partAdd').click(function() {
		$.ajax({
				url: '<?php echo $this->webroot;?>/parts/add/',
				cache: false,
				type: 'POST',
				dataType: 'HTML',
				data:jQuery('#addForm').serialize(),
				success: function (data) {
					$('#results').html(data);
				},
			});
		return false;
	});
	
	</script>
