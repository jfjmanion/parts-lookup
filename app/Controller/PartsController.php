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
		$id = $this->stripExtraChars($id);
		$parts = $this->findPart($id);
		$parts = json_encode($parts);
		$this->set('parts', $parts);
	}

	public function add() {
		$id = $this->stripExtraChars($this->request->data['Part']['Id']);
		$this->addPart($id);
	}

	public function update(){
		//get the original Id
		$org_id = $this->stripExtraChars($this->request->data['Part']['hidden_id']);
		unset($this->request->data['Part']['hidden_id']);

		$id = $this->stripExtraChars($this->request->data['Part']['Id']);
		$this->updatePart($id, $org_id);
	}


	//not complete
	public function delete(){
		$id = $this->stripExtraChars($this->request->data['part_id']);
		$this->deletePart($id);
		$results = $this->findPart($id);

		if (count($results) == 0 ){
			$result = "Part {$id} has been deleted";
			$class = "bg-success";
		} else {
			$result = "Part {$id} could not be deleted";
			$class = "bg-danger";
		}

		$this->set('result', $result);
		$this->set('class', $class);
	}

	//not complete
	public function import(){
		//do more checking
		$fileName = $_FILES['data']['tmp_name']['part']['file'];
		if(isset($fileName)){

			$csv = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', file_get_contents($fileName)));
			$partsAdded = array();
			$partsUpdated = array();

			foreach($csv as $part){
				$value = array();
				$id = $this->stripExtraChars($part[2]);

				$existingParts = $this->findPart($id);

				//if the part already exists, don't add it
				if (is_array($existingParts) && !empty($existingParts)) {
					$partsUpdated[] = $id;
				} else if ($id != ""){
					$this->deletePart($id);
					$value['Part']['Id'] = $id;
					$value['Part']['PartName'] = $part[0];
					$value['Part']['PartNotes'] = $part[1];
					$value['Location'][0]['PartLocation'] = $part[3];
					$value['Location'][0]['Part_id'] = $id;
					$this->Part->saveAll($value);
					$partsAdded[] = $id;
				}
			}
		}

		$this->set('added', $partsAdded);
		$this->set('notUpdated', $partsUpdated);
	}

private function updatePartRequest(){
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
			unset($this->request->data['Location'][$index]);
		}
		return $emptyLocation;
	}

	private function deletePart($id){
		$this->Part->delete($id);
		$this->Location->deleteAll(array('Location.Part_id' => $id), false);
	}

	private function stripExtraChars($id){
		$id = str_replace("'", "", $id); //remove all apostrophies
		$id = str_replace(" ", "", $id); //remove all spaces
		$id = ltrim($id, '0'); //remove leading zeros
		return $id;
	}

	private function findPart($id){
		return $this->Part->find('all', array('conditions' => array('Part.Id' => $id)));
	}

	private function updatePart($id, $orig){
		$this->addUpdatePart($id, 'updated', $orig);
	}

	private function addPart($id){
		$this->addUpdatePart($id, 'added');
	}

	private function addUpdatePart($id, $type, $org_id = ''){
		if ($id === ""){
			$this->set('result',"You must have an Id.");
			$this->set('class',"bg-danger");
			return;
		}

		$emptyLocation = $this->updatePartRequest();

		if ($emptyLocation){
			$this->set('result',"You must have a location.");
			$this->set('class',"bg-danger");
			return;
		}

		$results = $this->findPart($id);
		if (count($results) == 0  || ($org_id == $id)){
			if ($org_id !== '') {
				$this->deletePart($org_id); //delete the original data
			}
			$this->Part->saveAll($this->request->data);
			$result = "Part {$id} has been ".$type.".";
			$class = "bg-success";
		} else {
			$result = "Part {$id} already exists.";
			$class = "bg-danger";
		}

		$this->set('result',$result);
		$this->set('class',$class);
	}


	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('fetch');
    }
}
