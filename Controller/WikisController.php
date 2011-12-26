<?php
class WikisController extends WikisAppController {

	public $name = 'Wikis';
	public $uses = 'Wikis.Wiki';

	function index() {
		$this->Wiki->recursive = 0;
		$this->set('wikis', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Wiki.', true));
			$this->redirect(array('action'=>'index'));
		}
		$wiki = $this->Wiki->read(null, $id);
		$this->redirect(array('controller' => 'wiki_pages', 'action' => 'view', $wiki['Wiki']['wiki_page_id']));
	}

}
?>