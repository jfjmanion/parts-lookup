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
    <?php echo $this->Form->input('', array('id' => 'textInput', 'class' => 'form-control input-lg', 'placeholder' => 'Enter part number')); ?>
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
                </tr>
                <tr>
                    <td id="partNumber"></td>
                    <td id="partName"></td>
                    <td id="partLocation"></td>
                    <td id="partNotes"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="noResults" class="row hidden">
<div class="col-md-12">
	<p class="bg-info"> No results for that part number.</p>
    </div>
</div>

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
						$('#partNotes').html(data[0].Part.PartNotes);
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
