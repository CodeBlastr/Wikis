<?php
class WikisController extends WikisAppController {

	var $name = 'Wikis';

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

	function admin_index() {
		$this->Wiki->recursive = 0;
		$this->set('wikis', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Wiki.', true));
			$this->redirect(array('action'=>'index'));
		}
		$wiki = $this->Wiki->read(null, $id);
		$this->redirect(array('controller' => 'wiki_pages', 'action' => 'view', $wiki['Wiki']['wiki_page_id']));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Wiki', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Wiki->save($this->data)) {
				$this->Session->setFlash(__('The Wiki has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Wiki could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Wiki->read(null, $id);
		}
		$projects = $this->Wiki->Project->find('list');
		$wikiStartPages = $this->Wiki->WikiStartPage->find('list');
		$creators = $this->Wiki->Creator->find('list');
		$modifiers = $this->Wiki->Modifier->find('list');
		$this->set(compact('projects','wikiStartPages','creators','modifiers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Wiki', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Wiki->delete($id)) {
			$this->Session->setFlash(__('Wiki deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>