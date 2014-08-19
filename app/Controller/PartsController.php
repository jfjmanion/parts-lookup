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

public $uses = array('Part', 'Location');

private $class;

private $result;
//public $uses = array('Location, Part');
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function fetch($id = '') {
		$id = str_replace(" ", "", $id); //remove all spaces
		$id = ltrim($id, '0'); //remove leading zeros
		
		$parts = array();
		$parts = $this->Part->find('all', array('conditions' => array('Part.Id' => $id)));
		$parts = json_encode($parts);
	
		$this->set('parts', $parts);
	}
	
	public function add() {
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
		;
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
		$org_id = $this->request->data['Part']['hidden_id'];
		unset($this->request->data['Part']['hidden_id']);
		
		$this->Part->delete($org_id);	
		$this->Location->deleteAll(array('Location.Part_id' => $org_id), false);
		//var_dump($this->request->data);
	
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
		;
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
		$this->set('result',$result);
		$this->set('class',$class);

	}
	
	public function delete(){	
		$id = $this->request->data['part_id'];
		$id = trim($id, "'");
		$this->Part->delete($id);	
		$this->Location->deleteAll(array('Location.Part_id' => $id), false);
		
		$results = $this->Part->find('all', array('conditions' => array('Part.Id' => $id)));
		
		if (count($results) == 0 ){
			$result = "Part {$id} has been deleted";
			$class = "bg-success";
		} else {
			$this->set('parts', json_encode($this->request->data));
			$result = "Part {$id} could not be deleted";
			$class = "bg-danger";
		}
		
		$this->set('result', $result);
		$this->set('class', $class);
	}
	
	public function import(){
		
		//do more checking
		$fileName = $_FILES['data']['tmp_name']['part']['file'];
		if(isset($fileName)){
			
			$csv = array_map('str_getcsv', file($fileName));
			$partsAdded = array();
			$partsUpdated = array();
			foreach($csv as $part){
				$value = array();
				$id = $part[2];

				$this->Part->delete($id);	
				$this->Location->deleteAll(array('Location.Part_id' => $id), false);
				$value['Part']['Id'] = $id;
				$value['Part']['PartName'] = $part[0];	
				$value['Part']['PartNotes'] = $part[1];
				$value['Location'][0]['PartLocation'] = $part[3];	
				$value['Location'][0]['Part_id'] = $id;
				$this->Part->saveAll($value);
				$partsAdded[] = $id;
			}
		}
		
		$this->set('added', $partsAdded);
	}
	
	private function addUpdatePart($id = 0){
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
		;
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
	}
}
