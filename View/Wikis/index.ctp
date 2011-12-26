<div class="wikis index">
<h2><?php echo __('Wikis');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('WikiStartPage.title');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($wikis as $wiki):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link(str_replace('_', ' ', $wiki['WikiStartPage']['title']), array('controller' => 'wikis', 'action' => 'view', $wiki['Wiki']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Add Page', true), array('controller' => 'wiki_pages', 'action' => 'edit', 'wiki_id' => $wiki['Wiki']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $wiki['Wiki']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $wiki['Wiki']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->Element('paging'); ?>


<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Wikis',
		'items' => array(
			$this->Html->link(__('Add Wiki', true), array('controller' => 'wiki_pages', 'action' => 'edit', 'admin' => 1))),
		),
	)));
?>