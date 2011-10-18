<div class="wikiContents form">
<?php echo $this->Form->create('WikiPage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Edit Wiki Page');?></legend>
	<?php
		echo $this->Form->input('WikiPage.id'); 
		if (isset($this->request->params['named']['wiki'])) {
			echo $this->Form->input('WikiPage.wiki_id', array('type' => 'hidden', 'value' => $this->request->params['named']['wiki'])); 
		} else {
			echo $this->Form->input('WikiPage.wiki_id', array('type' => 'hidden'));
		}
		if (isset($this->request->data['WikiPage.title'])) {
			echo $this->Form->input('WikiPage.title');
		} else if (isset($this->params['pass'][0])) {
			echo $this->Form->input('WikiPage.title', array('value' => end($this->params['pass']))); 
		} else {
			echo $this->Form->input('WikiPage.title');			
		}
		
		echo $this->Form->input('thumbnail_url', array('type' => 'hidden'));	
		echo $this->Form->input('WikiPage.File/image', array('type' => 'file'));
		echo $this->Form->input('WikiContent.text', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
		echo $this->Form->input('WikiContent.comments');
		echo $this->Form->input('WikiContent.version', array('type' => 'hidden'));
		echo $this->Form->input('WikiCategory'/*, array('type' => 'select', 'multiple' => 'multiple')*/);
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>