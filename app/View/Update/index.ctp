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
    <form action="/" id="updateForm">
        <?php echo $this->Form->hidden('Part.hidden_id', array('id' => 'hidden_id', 'value' => $id)); ?>
        <?php echo $this->Form->input('Part.Id', array('id' => 'id', 'class' => 'form-control', 'label' =>'Part ID', 'value' => $id)); ?>
        <?php echo $this->Form->input('Part.PartName', array('id' => 'PartName', 'class' => 'form-control', 'value' => $partName)); ?>
        <?php $count = 0;
        foreach ($locations as $location) {
            echo '<div id="location'.$count.'">';
            echo $this->Form->input('Location.'.$count.'.PartLocation', array('div' => false, 'id' => 'PartLocation'.$count, 'class' => 'form-control', 'value' =>$location['PartLocation']));
            echo $this->Form->hidden('Location.'.$count.'.Part_id', array('id' => 'LocationPartId'.$count, 'value' => $id));
            echo "</div>";
            $count++;
        }
        ?>
        
        <button type="button" class="btn btn-info btn-sm" name="addLocation" id="addLocation"><span class="glyphicon glyphicon-plus"></span></button>
        <button type="button" class="btn btn-danger btn-sm <?php echo ($count > 1) ? '' : 'hidden';?>" name="removeLocation" id="removeLocation"><span class="glyphicon glyphicon-minus"></span></button>
        
        
        
        <?php echo $this->Form->input('Part.PartNotes', array('id' => 'PartNotes', 'class' => 'form-control', 'value' => $partNotes )); ?>
     
        <?php echo $this->Form->end(array('label' => 'Update Part',
        'name' => 'Update',
        'class' => 'btn btn-primary',
        'id' => 'partUpdate'
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
var i = <?php echo $count; ?>-1;

	$('#removeLocation').click(function(){
		if(i == 1){
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
			if ($("#hidden_id")[0] !== ($(this)[0])){
				$(this).val($('#id').val());
			}
		});
	});

	$('#partUpdate').click(function() {
		$.ajax({
				url: '<?php echo $this->webroot;?>parts/update/',
				cache: false,
				type: 'POST',
				dataType: 'HTML',
				data:jQuery('#updateForm').serialize(),
				success: function (data) {
					$('#results').html(data);
				},
			});
		return false;
	});
	
	</script>
