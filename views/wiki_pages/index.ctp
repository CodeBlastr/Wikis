<div class="wikis index">
<h2><?php echo __('Wiki Pages');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('Wiki.id');?></th>
	<th><?php echo $this->Paginator->sort('WikiPage.id');?></th>
	<th><?php echo $this->Paginator->sort('WikiPage.title');?></th>
	<th><?php echo $this->Paginator->sort('WikiContent.text');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($wikiPages as $wikiPage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
    	<td>
        	<?php echo $wikiPage['Wiki']['id']; ?>
        </td>
    	<td>
        	<?php echo $wikiPage['WikiPage']['id']; ?>
        </td>
		<td>
			<?php echo $this->Html->link(str_replace('_', ' ', $wikiPage['WikiPage']['title']), array('controller' => 'wiki_pages', 'action' => 'view', 'wiki_id' => $wikiPage['Wiki']['id'], $wikiPage['WikiPage']['title'])); ?>
		</td>
    	<td>
        	<?php echo $text->truncate(strip_tags($wikiPage['WikiContent']['text']), 30, array('ending' => '...', 'exact' => false, 'htmll' => true)); ?>
        </td>
		<td class="actions">
			<?php echo $this->Html->link(__('Add Page', true), array('controller' => 'wiki_pages', 'action' => 'edit', 'wiki_id' => $wikiPage['Wiki']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $wikiPage['WikiPage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $wikiPage['WikiPage']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->element('paging'); ?>


<?php 
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Wikis',
		'items' => array(
			$this->Html->link(__('Add Wiki', true), array('controller' => 'wiki_pages', 'action' => 'edit', 'admin' => 1))),
		),
	)));
?>