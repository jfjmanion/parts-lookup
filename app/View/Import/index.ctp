<?php 
echo $this->Form->create('part', array('type' => 'file', 'url'=>'/parts/import'));
echo $this->Form->input('file', array('label'=>"Import CSV", "type"=>"file"));
echo $this->Form->button('Submit', array('id'=>'submit'));
echo $this->Form->end(); 
echo "<span id='jason'></span>"; ?>
<script>

	$('#submit').click(function() {
		
		var form = $('form');		
		fileData = new FormData(form[0]);	
	
			$.ajax({
				url: form.attr('action'),
				type: 'POST',
				cache: false,
				processData: false,
     		    contentType: false,
				data: fileData,
				success: function (data) {
					$('#jason').html('<pre>' + data);
				}
			});
		return false;
	});
	
	</script>