<div class="wikiContents form">
<?php echo $form->create('WikiPage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Edit Wiki Page');?></legend>
	<?php
		echo $form->input('WikiPage.id'); 
		if (isset($this->params['named']['wiki'])) {
			echo $form->input('WikiPage.wiki_id', array('type' => 'hidden', 'value' => $this->params['named']['wiki'])); 
		} else {
			echo $form->input('WikiPage.wiki_id', array('type' => 'hidden'));
		}
		if (isset($this->data['WikiPage.title'])) {
			echo $form->input('WikiPage.title');
		} else if (isset($this->params['pass'][0])) {
			echo $form->input('WikiPage.title', array('value' => end($this->params['pass']))); 
		} else {
			echo $form->input('WikiPage.title');			
		}
		
		echo $form->input('thumbnail_url', array('type' => 'hidden'));	
		echo $form->input('WikiPage.File/image', array('type' => 'file'));
		echo $form->input('WikiContent.text', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
		echo $form->input('WikiContent.comments');
		echo $form->input('WikiContent.version', array('type' => 'hidden'));
		echo $form->input('WikiCategory'/*, array('type' => 'select', 'multiple' => 'multiple')*/);
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>