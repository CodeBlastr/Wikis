<?php
class WikiContent extends WikisAppModel {

	var $name = 'WikiContent';
	var $validate = array(
		'wiki_page_id' => array('numeric')
	); 
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'WikiPage' => array(
			'className' => 'Wikis.WikiPage',
			'foreignKey' => 'wiki_page_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function add($data) {
		# look up to see if the content already exists
		$wikiContent = $this->find('first', array(
			'conditions' => array(
				'WikiContent.wiki_page_id' => $data['WikiContent']['wiki_page_id'],
				),
			));
		if (!empty($wikiContent)) {
			$data['WikiContent']['id'] = $wikiContent['WikiContent']['id'];
			$data['WikiContent']['version'] = $wikiContent['WikiContent']['version'];
		}
		# update the version number if it is set already
		$data['WikiContent']['version'] = !empty($data['WikiContent']['version']) ? $data['WikiContent']['version'] + 1 : 1;
		
		if ($this->save($data)) {
			$wikiContentId = $this->id;
			# save the version so that we have a record of the changes
			$this->WikiContentVersion = ClassRegistry::init('WikiContentVersion');
			$data['WikiContentVersion'] = $data['WikiContent'];
			unset($data['WikiContentVersion']['id']);
			if ($this->WikiContentVersion->save($data)) {
				return true;
			} else {
				#roll back
				$this->delete($wikiContentId);
				return false;
			}
		} else {
			return false;
		}
	}
}
?>