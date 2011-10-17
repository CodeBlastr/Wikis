<div class="wikiContents form">
<?php echo $form->create('WikiPage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Add Wiki Page');?></legend>
	<?php
		echo $form->input('WikiPage.wiki_id', array('type' => 'hidden')); 
		echo $form->input('WikiPage.wiki_start_page', array('label' => 'Wiki'));
		echo $form->input('WikiPage.title');	
		echo  $this->element('add', array('plugin' => 'galleries'));
		echo  $this->element('choose', array('plugin' => 'categories'));
		echo $form->input('WikiContent.text', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
		echo $form->input('WikiContent.comments');
		echo $form->input('WikiContent.version', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>