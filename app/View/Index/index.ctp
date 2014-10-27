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
		<?php echo $this->Session->flash(); ?>
		<select id='textInput' class='form-control input-lg' placeholder='Enter part number'>
			<?php
			foreach ($partIds as $partId) {
				$id = $partId['Part']['id'];
				echo "<option value='{$id}'>{$id}</option>";
			}
			?>
	  </select>
	</div>
</div>

<div id="tableContainer" class="row hidden">
    <div class="col-md-12">
        <h2>Results</h2>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Part Location</th>
                    <th>Notes</th>
                    <?php if($this->Session->check('Auth.User')){?>
                    <th>Actions</th>
                    <?php }?>
                </tr>
                <tr>
                    <td id="partNumber"></td>
                    <td id="partName"></td>
                    <td id="partLocation"></td>
                    <td id="partNotes"></td>
                    <?php if($this->Session->check('Auth.User')){?>
                    <td id="actions">
                    	<button type="button" class="btn btn-default btn-md" id="update">Edit <span class="glyphicon glyphicon-edit"></span></button>
                    	<button type="button" class="btn btn-default btn-md" id="delete">Delete <span class="glyphicon glyphicon-remove"></span></button>
                    </td>
                    <?php }?>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="noResults" class="row hidden">
<div class="col-md-12">
	<p class="bg-info"> No results for part number: <span id="partNumberResult"></span>.</p>
    </div>
</div>

<script>
	$('#textInput').selectize({
    	maxItems: 1,
	});

	$('#delete').click(function() {
		var result = window.confirm("Are you sure you want to delete part: " + $('#partNumber').html());
		if (result == false){
		  return false;
		}


		$.ajax({
				url: '<?php echo $this->webroot;?>parts/delete/',
				cache: false,
				type: 'POST',
				dataType: 'HTML',
				data: {'part_id' : "'" + $('#partNumber').html() + "'"},
				success: function (data) {
					$( "#textInput" ).trigger( "change" );
				}
			});

	});


	$('#textInput').on('change', function() {
		var $this = $(this);
   		var delay = 1; // 1 second delay after last input
    	clearTimeout($this.data('timer'));
    	$this.data('timer', setTimeout(function(){
        	$this.removeData('timer');

			$.ajax({
				url: '<?php echo $this->webroot;?>parts/fetch/' + $('#textInput').val(),
				cache: false,
				type: 'GET',
				dataType: 'JSON',
				success: function (data) {
					if (data.length > 0) {
						$('#tableContainer').removeClass('hidden');
						$('#noResults').addClass('hidden');
						$('#partNumber').html(data[0].Part.id);
						$('#partName').html(data[0].Part.PartName);
						$('#partNotes').html(data[0].Part.PartNotes);
						$('#partLocation').html('');
						var text = "<ul>";
						for (var x in data[0].Location) {
							text += "<li>" + data[0].Location[x].PartLocation + "</li>";
						}
						text += "</ul>";
						$('#partLocation').append(text);
					} else {
						$("#partNumberResult").html($('#textInput').val());
						$('#tableContainer').addClass('hidden');
						$('#noResults').removeClass('hidden');
					}
				}
			});
		}, delay));
	});

	$('#update').click(function(){
		window.location.replace('<?php echo $this->webroot;?>update/?part_id='+$('#partNumber').html());
	});
	</script>
