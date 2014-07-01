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
    <form role="form">
   		<input type="text" class="form-control input-lg" id="textInput" placeholder="Enter part number" name="textInput"/>
    </form>
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
