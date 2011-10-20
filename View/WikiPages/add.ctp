<div class="wikiContents form">
<?php echo $this->Form->create('WikiPage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php echo __('Add Wiki Page');?></legend>
	<?php
		echo $this->Form->input('WikiPage.wiki_id', array('type' => 'hidden')); 
		echo $this->Form->input('WikiPage.wiki_start_page', array('label' => 'Wiki'));
		echo $this->Form->input('WikiPage.title');	
		echo  $this->element('add', array('plugin' => 'galleries'));
		echo  $this->element('choose', array('plugin' => 'categories'));
		echo $this->Form->input('WikiContent.text', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
		echo $this->Form->input('WikiContent.comments');
		echo $this->Form->input('WikiContent.version', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>