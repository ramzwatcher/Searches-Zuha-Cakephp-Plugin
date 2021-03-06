<h2>Advance Search results</h2>
<?php 
echo $this->Form->create('SearchIndex', array(
  'url' => array(
    'plugin' => 'searchable',
    'controller' => 'search_indexes',
    'action' => 'advance',
	'model' => isset($this->request->params['named']['model']) ? $this->request->params['named']['model'] : ''  
  )
));

$range = array('>' => '>', '<' => '<', '>=' => '>=',
					 '<=' => '<=', '=' => '=');
$set_model = false;
foreach($xmlInput as $model => $xml) {
	if(isset($this->request->params['named']['model']) && $this->request->params['named']['model'] != $model) {
		continue;	
	} 
	
	echo"<h2>{$model}</h2>";
	foreach($xml['fields'] as $key => $field) {
		echo $this->Form->hidden("SearchIndex.{$model}.fields.{$key}.name", array('value' => "{$model}.{$field['name']}"));
		echo $this->Form->input("SearchIndex.{$model}.fields.{$key}.value", array('label' => $field['name'], 
							/*'type' => $field['fieldtype'],*/ 'empty' => true));
		echo $this->Form->hidden("SearchIndex.{$model}.fields.{$key}.type", array('value' => $field['type']));
	}
	echo $this->Form->hidden("SearchIndex.{$model}.SearchType", array('value' => 'AND'));
}		
 
echo "<br/>";
echo $this->Form->end('View Advanced Search Results');

?>
<?php if (!empty($results)): ?>
	  <ul>
	    <?php foreach ($results as $model => $data) : ?>
	    <?php if (count($data)) {?>
	    <li><h2><?php echo $model;?></h2></li>
	    <?php foreach ($data as $result) {?>
	    <li>
	    <?php
	     	if ($xmlInput[$model]['result']) {
				$url = array('plugin' => $xmlInput[$model]['result']['plugin'],
					'controller' => $xmlInput[$model]['result']['controller'],
					'action' => $xmlInput[$model]['result']['action'],
					$result[$model][$xmlInput[$model]['result']['id']]
			);
			$title = $result[$model][$xmlInput[$model]['result']['title']];
			$description = substr(strip_tags($result[$model][$xmlInput[$model]['result']['description']]), 0, 50);
		} else {
			$url = '#';
			$title = $result[$model]['name'];
			$description = $result[$model]['description'];
	    }?>
	    
	      <h3><?php echo $this->Html->link ( $title
	    			,$url      
	    			,true); ?></h3>
	    			<p><?php echo $description;?></p>
	    </li>
	    <?php } ?>
	    <li>	    <br></br>
	    <?php }?></li>
	    <?php endforeach; ?>
	  </ul>
	  
	  <?php if (isset($paginator)) {?>
	  <div class="paging">
		    <?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
		   | 	<?php echo $this->Paginator->numbers();?>
		    <?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
		  </div>
	  <?php }?>

<?php endif; ?>