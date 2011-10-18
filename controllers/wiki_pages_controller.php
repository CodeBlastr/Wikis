<?php
class WikiPagesController extends WikisAppController {

	var $name = 'WikiPages';

	function index() {
		$this->paginate = array(
			'contain' => array(
				'Wiki',
				'WikiContent',
			),
		);
		$this->set('wikiPages', $this->paginate());
	}
	

/**
 * Sets the variables for the view if the wiki page exists or redirects to edit if the page does not exist. 
 *
 * @param {id}		The id of the wiki page, if it doesn't exist we look for the "title" alias, and wiki id to exist.
 */
	function view($wiki = null, $alias = null) {
		# if wiki is numeric then just redirect to the right url
		$id = is_numeric($wiki) ? $wiki : null;
		if(!empty($id)) { $this->_viewWikiNumeric($id); }
				
		if (!empty($wiki) && !empty($alias) && $wikiPage = $this->_viewWikiPage($wiki, $alias)) {
			# check if page exists if it does show it
			$this->set(compact('wikiPage'));
		} else if (!empty($wiki) && $this->_viewWiki($wiki)) {
			# if alias is null you would just redirect the wiki start page 
		} else {
			# else add the wiki itself
			$this->Session->setFlash(__('Invalid Wiki', true));
			$this->redirect(array('action' => 'index'));
		}
	}
		
	
	function add($wiki = null, $alias = null) {
		if (!empty($this->request->data)) {
			if ($this->WikiPage->add($this->request->data)) {
				$this->Session->setFlash(__('Successful Save', true));
				$this->redirect(array('action' => 'view', $this->WikiPage->id));
			} else {
				$this->Session->setFlash(__('The Wiki Page could not be saved. Please, try again.', true));
			}
		}
		$this->_setFormData($wiki, $alias);
	}


	function edit($wiki = null, $alias = null) {
		if (!empty($this->request->data)) {
			if ($this->WikiPage->add($this->request->data)) {
				$this->Session->setFlash(__('Successful Save', true));
				$this->redirect(array('action' => 'view', $this->WikiPage->id));
			} else {
				$this->Session->setFlash(__('The Wiki Page could not be saved. Please, try again.', true));
			}
		}
		$this->_setFormData($wiki, $alias, false);		
	}


	function admin_index() {
		$this->paginate = array(
			'contain' => array(
				'Wiki',
				'WikiContent',
			),
		);
		$this->set('wikiPages', $this->paginate());
	}
	
	
	function admin_view($wiki = null, $alias = null) {
		# if wiki is numeric then just redirect to the right url
		$id = is_numeric($wiki) ? $wiki : null;
		if(!empty($id)) { $this->_viewWikiNumeric($id); }
				
		if (!empty($wiki) && !empty($alias) && $wikiPage = $this->_viewWikiPage($wiki, $alias)) {
			# check if page exists if it does show it
			$this->set(compact('wikiPage'));
		} else if (!empty($wiki) && $this->_viewWiki($wiki)) {
			# if alias is null you would just redirect the wiki start page 
		} else {
			# else add the wiki itself
			$this->Session->setFlash(__('Invalid Wiki', true));
			$this->redirect(array('action' => 'index'));
		}
	}
		
	
	function admin_add($wiki = null, $alias = null) {
		if (!empty($this->request->data)) {
			if ($this->WikiPage->add($this->request->data)) {
				$this->Session->setFlash(__('Successful Save', true));
				$this->redirect(array('action' => 'view', $this->WikiPage->id));
			} else {
				$this->Session->setFlash(__('The Wiki Page could not be saved. Please, try again.', true));
			}
		}
		$this->_setFormData($wiki, $alias);
	}

	

	function admin_edit($wiki = null, $alias = null) {
		if (!empty($this->request->data)) {
			if ($this->WikiPage->add($this->request->data)) {
				$this->Session->setFlash(__('Successful Save', true));
				$this->redirect(array('action' => 'view', $this->WikiPage->id));
			} else {
				$this->Session->setFlash(__('The Wiki Page could not be saved. Please, try again.', true));
			}
		}
		$this->_setFormData($wiki, $alias, false);		
	}


	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for WikiPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WikiPage->delete($id)) {
			$this->Session->setFlash(__('WikiPage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	/**
	 * if wiki id is blank look up all pages 
	 * if there are multiple pages redirect to index() limited by ids
	 * if there is just one then redirect to that page alias
	 * 
	 * @todo		Finish off the redirect to index, and the index function so that it supports limits by ids
	 */
	function _viewWiki($wiki) {
		$wikiStartPage = $this->WikiPage->Wiki->WikiStartPage->find('first', array(
			'conditions' => array(
				'WikiStartPage.title' => $wiki,
				),
			));
		if (!empty($wikiStartPage)) {
			$this->redirect(array('action' => 'view', $wiki, $wikiStartPage['WikiStartPage']['title']));
		} else {
			$this->Session->setFlash(__('Wiki does not exist. Would you like to create the first page?', true));
			$this->redirect(array('action' => 'add', $wiki, $wiki));
		}			
	}
	
	/**
	 * if the alias is string and exists show the page 
	 * else redirect to add() preserving the wiki id if it is there
	 */
	function _viewWikiPage($wiki, $alias) {
		$alias = str_replace(' ', '_', $alias);
		$wiki = $this->WikiPage->Wiki->WikiStartPage->find('first', array(
			'conditions' => array(
				'WikiStartPage.title' => $wiki,
				),
			));
		if (!empty($wiki)) {
			$this->settings['conditions'] = array('WikiPage.title' => $alias);
			$wikiPage = $this->WikiPage->find('first', $this->settings);
			if (!empty($wikiPage)) {
				$wikiPage['WikiPage']['title'] = str_replace('_', ' ', $wikiPage['WikiPage']['title']);
				return $wikiPage;
			} else {
				$this->Session->setFlash(__('Wiki Page does not exist. Would you like to create it?', true));
				$this->redirect(array('action' => 'add', $wiki['WikiStartPage']['title'], $alias));
			}			
		} else {
			$this->Session->setFlash(__('Wiki does not exist. Would you like to create it?', true));
			$this->redirect(array('action' => 'add', $wiki, $alias));
		}
	}
	
	/**
	 * if the alias is numeric then redirect to the alias version of this page
	 */
	function _viewWikiNumeric($id) {
		$wikiPage = $this->WikiPage->find('first', array(
			'conditions' => array(
				'WikiPage.id' => $id,
				),
			'contain' => array(
				'Wiki' => array(
					'WikiStartPage',
					),
				),
			));
		if (!empty($wikiPage)) {
			# redirect to the right url
			$this->redirect(array('action' => 'view', str_replace(' ', '_', $wikiPage['Wiki']['WikiStartPage']['title']), str_replace(' ', '_', $wikiPage['WikiPage']['title'])));
		} else {
			$this->Session->setFlash(__('Invalid Wiki Page', true));
			$this->redirect(array('action' => 'index'));
		}			
	}
	
	
	/**
	 * Checks to see if the wiki or alias exist and confirms the data in various cases.
	 */
	function _setFormData($wiki = null, $alias = null, $redirect = true) {
		if (!empty($alias)) {
			# make sure that the page doesn't already exist
			$wikiStart = $this->WikiPage->find('first', array(
				'conditions' => array(
					'WikiPage.title' => $wiki,
					),
				));
			$aliasPage = $this->WikiPage->find('first', array(
				'conditions' => array(
					'WikiPage.title' => $alias,
					),
				'contain' => array(
					'WikiContent',
					),
				));
			
			$wikiId = !empty($wikiStart) ? $wikiStart['WikiPage']['wiki_id'] : null;
			$wiki = !empty($wikiStart) ? $wikiStart['WikiPage']['title'] : $wiki;
			$alias = !empty($aliasPage) ? $aliasPage['WikiPage']['title'] : str_replace(' ', '_', $alias);
			if (!empty($aliasPage) && !empty($redirect)) {
				# both the wiki and the page exist, redirect to edit
				$this->Session->setFlash(__('This page already exists', true));
				$this->redirect(array('action' => 'edit', $wiki, $alias));
			} else {
				$this->request->data = $aliasPage;
			}
		} else if (!empty($wiki)) {
			# make sure that the page doesn't already exist
			$wikiStart = $this->WikiPage->find('first', array(
				'conditions' => array(
					'WikiPage.title' => $wiki,
					),
				));
			$wikiId = !empty($wikiStart) ? $wikiStart['WikiPage']['wiki_id'] : null;
			$wiki = !empty($wikiStart) ? $wikiStart['WikiPage']['title'] : $wiki;
		} else {
			# vars already set, don't need to do anything
		}
		$this->request->data['WikiPage']['wiki_id'] = $wikiId;
		$this->request->data['WikiPage']['wiki_start_page'] = $wiki;
		$this->request->data['WikiPage']['title'] = $alias;
	}

}
?>