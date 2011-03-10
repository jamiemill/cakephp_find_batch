<?php

class FindBatchBehavior extends ModelBehavior {
	
	var $_defaults = array();

	function setup(&$model, $config = array()) {
		$this->settings[$model->name] = am ($this->_defaults,$config);
	}

	function findBatch(&$model, $settings, $callback) {
		$settings = am(array(
			'limit'=>100
		), $settings);

		$nextOffset = 0;
		$totalRecords = $model->find('count', $settings);

		while($records = $model->find('all', am($settings, array(
			'offset'=>$nextOffset
		)))) {
			$batchInfo = array(
				'totalRecords'=>$totalRecords,
				'offset'=>$nextOffset,
				'start'=>$nextOffset+1,
				'end'=>$nextOffset+count($records)
			);
			
			if(is_callable($callback)) {
				if(is_array($callback)) {
					call_user_func($callback, $records, $batchInfo);
				} else {
					$callback($records, $batchInfo);
				}
			} else {
				throw new Exception('Second argument is not callable.');
			}
			$nextOffset += $settings['limit'];
		}
	}

	
}
	
	
?>