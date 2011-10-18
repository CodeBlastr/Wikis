<?php
class Wiki extends WikisAppModel {

	var $name = 'Wiki';
	var $validate = array(
		'wiki_page_id' => array('numeric')
	); 
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'WikiStartPage' => array(
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

	var $hasMany = array(
		'WikiPage' => array(
			'className' => 'Wikis.WikiPage',
			'foreignKey' => 'wiki_id',
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

	# to do, make this a setting because it is not dependent
	var $hasAndBelongsToMany = array(
		'Project' => array(
			'className' => 'Projects.Project',
			'joinTable' => 'projects_wikis',
			'foreignKey' => 'wiki_id',
			'associationForeignKey' => 'project_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	function add($data) {
		# create a new wiki
		if ($this->save($data)) {
			$wikiId = $this->id;
			$data['WikiPage']['wiki_id'] = $wikiId;
			# then save the page
			if ($this->WikiPage->add($data)) {
				$wikiPageId = $this->WikiPage->id;
				$data['Wiki']['id'] = $wikiId;
				$data['Wiki']['wiki_page_id'] = $wikiPageId;
				# then resave the wiki with the start page referred to
				if ($this->update($data)) {
					return true;
				} else {
					# roll back
					$this->WikiPage->delete($wikiPageId);
					$this->delete($wikiId);
					return false;
				}
			} else {
				$this->delete($wikiId);
				return false;
			}				
		} else {
			return false;
		}
	}
	
	
	function update($data) {
		if ($this->save($data)) {
			return true;
		} else {
			return false;
		}
	}

}
?>