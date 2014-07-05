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
class PartsController extends AppController {

public $components = array('RequestHandler');

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function fetch($id = '') {
		$parts = array();
		$parts = $this->Part->find('all', array('conditions' => array('Part.Id' => $id)));
		$parts = json_encode($parts);
		$this->set('parts', $parts);
	}
	
	public function add(){
		$id = $this->request->data['Part']['Id'];
		
		//Locations logic
		$emptyLocation = true;
		$locations = array();
		$unset = array();
		for ($i = 0; $i < count($this->request->data['Location']); $i++){
			$loc = trim($this->request->data['Location'][$i]['PartLocation']);
			if (trim($loc) !== ""){
				$emptyLocation = false;
				//make sure there are not two of the same locations. IF so unset one
				if (in_array($loc, $locations)){
					$unset[] = $i;
				}
				$locations[] = $loc;
			} else {
				$unset[] = $i;
			}
		}
		foreach ($unset as $index) {
			unset($this->request->data['Location'][$index]);//dont think this will work, probably need to make it a for array	
		}
		//var_dump($this->request->data);
		if (trim($id) === ""){
			$class = "bg-danger";
			$result = "You must insert an Id.";
		} else if ($emptyLocation){
			$class = "bg-danger";
			$result = "You must insert a location.";
		} else {
			$results = $this->Part->find('all', array('conditions' => array('Part.Id' => $id)));
			if (count($results) == 0 ){
				$this->Part->saveAll($this->request->data);
				$result = "Part {$id} has been added.";
				$class = "bg-success";
			} else {
				$this->set('parts', json_encode($this->request->data));
				$result = "Part {$id} already exists.";
				$class = "bg-danger";
			}
		}
		$this->set('result', $result);
		$this->set('class', $class);
	}
	
	public function update(){
		
	}
	
	public function delete(){
	}
}
