<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class NewPartController extends AppController {

//public $components = array('RequestHandler');

public $uses = array('Part');

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function insert() {
		//$id = '', $partName = '', $partLocation = '', $notes = ''
		
		// check to make sure the part doesnt already exist
		/*$parts = $this->Part->find('all', array('conditions' => array('Part.id' => $id)));
		if (count($parts) === 0){
			$response = "Part {$id} already exists.";
		} else {
			$partLocation = explode('&&', $partLocation);
			$data = array('id' => $id, 'partName' => $partName, 'PartLocation'=> $partLocation,'Notes' => $notes);
			$this->Part->save($data);
			$response = "Part {$this->Part->id} has been added";
		}*/
	
			// requires ID and location. No part name or note required
	
			$id = '19';
			$partName = 'special part';
			$partLocation = "'; delee";
			$notes = 'This is a note';
			$data = array(
			'Part' => 
				array('PartId' => $id, 'PartName' => $partName, 'PartNotes' => $notes), 
			'Location' => array( 
				array('PartLocation'=> "location 1"),
				array('PartLocation'=> "location 2")
				)
			);
			
			
			$this->Part->saveAssociated($data);
			$response = "Part {$this->Part->Id} has been added";
			
		$this->set('response', $response);
	}
}
