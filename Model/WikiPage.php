<?php
class WikiPage extends WikisAppModel {

	var $name = 'WikiPage';
	var $validate = array(
		'title' => array('notempty'),
		'wiki_id' => array('numeric')
	); 
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Wiki' => array(
			'className' => 'Wikis.Wiki',
			'foreignKey' => 'wiki_id',
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

	var $hasOne = array(
		'WikiContent' => array(
			'className' => 'Wikis.WikiContent',
			'foreignKey' => 'wiki_page_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Gallery' => array(
			'className' => 'Galleries.Gallery',
			'foreignKey' => 'foreign_key',
			'dependent' => false,
			'conditions' => array('Gallery.model' => 'WikiPage'),
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'WikiContentVersion' => array(
			'className' => 'Wikis.WikiContentVersion',
			'foreignKey' => 'wiki_page_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	function add($data) {
		$data['WikiPage']['title'] = str_replace(' ', '_', $data['WikiPage']['title']);
		# save the new page
		if (!empty($data['WikiPage']['wiki_id']) && $this->save($data)) {
			# save the page content
			$wikiPageId = $this->id;
			$data['WikiContent']['wiki_page_id'] = $wikiPageId;
			if ($this->WikiContent->add($data)) {
				# if the gallery data exists save it
				if (!empty($data['GalleryImage'])) {
					$data['Gallery']['model'] = 'WikiPage';
					$data['Gallery']['foreign_key'] = $wikiPageId;
					if ($data['GalleryImage']['filename']['error'] == 0 && $this->Gallery->GalleryImage->add($data, 'filename')) {
						# for now don't do anything, because we'd like to save the page data with or without the gallery
					}
				}
				return true;
			} else {
				#roll back because there was a problem
				$this->delete($wikiPageId);
				return false;
			}
		} else if ($this->Wiki->add($data)) {
			return true;
		} else {
			return false;
		}
	}
	
}
?>