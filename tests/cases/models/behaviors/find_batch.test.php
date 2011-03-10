<?php 

require_once(dirname(__FILE__).DS.'..'.DS.'test_models.php');

class FindBatchTestCase extends CakeTestCase {
	
	var $fixtures = array(
		'plugin.find_batch.find_batch_item',
	);
	
	var $FindBatchItem = null;

	function startCase() {
		$this->FindBatchItem =& new FindBatchItem();
	}
	
	function testItemIsAsExpected() {
		$this->assertIsA($this->FindBatchItem,'FindBatchItem');
		$this->assertIsA($this->FindBatchItem->Behaviors->FindBatch, 'FindBatchBehavior');
		$this->assertTrue($this->FindBatchItem->Behaviors->attached('FindBatch'));
		$this->assertTrue($this->FindBatchItem->Behaviors->enabled('FindBatch'));
	}
	
	function testFindBatch() {
		$resultsBuffer = array();
		
		$test = $this;
		
		$this->FindBatchItem->findBatch(array(
			'limit' => 5,
			'order' => array('title'=>'asc')
		), function($results, $batchInfo) use (&$resultsBuffer, &$test) {
			$test->assertEqual($batchInfo['totalRecords'],11);
			$resultsBuffer[] = $results;
		});
		
		$this->assertEqual(Set::extract('/FindBatchItem/title',$resultsBuffer[0]), array(
			'Find Batch Item 01',
			'Find Batch Item 02',
			'Find Batch Item 03',
			'Find Batch Item 04',
			'Find Batch Item 05',
		));
		
		$this->assertEqual(Set::extract('/FindBatchItem/title',$resultsBuffer[1]), array(
			'Find Batch Item 06',
			'Find Batch Item 07',
			'Find Batch Item 08',
			'Find Batch Item 09',
			'Find Batch Item 10',
		));
		
		$this->assertEqual(Set::extract('/FindBatchItem/title',$resultsBuffer[2]), array(
			'Find Batch Item 11',
		));
		
	}
	
	function testFindBatchWithOldStyleCallback() {
		$resultsBuffer = array();

		$this->FindBatchItem->findBatch(array(
			'limit' => 5,
			'order' => array('title'=>'asc')
		), array($this,'_oldStyleCallback'));
		
		$this->assertEqual(Set::extract('/FindBatchItem/title',$this->resultsBuffer[0]), array(
			'Find Batch Item 01',
			'Find Batch Item 02',
			'Find Batch Item 03',
			'Find Batch Item 04',
			'Find Batch Item 05',
		));
		
		$this->assertEqual(Set::extract('/FindBatchItem/title',$this->resultsBuffer[1]), array(
			'Find Batch Item 06',
			'Find Batch Item 07',
			'Find Batch Item 08',
			'Find Batch Item 09',
			'Find Batch Item 10',
		));
		
		$this->assertEqual(Set::extract('/FindBatchItem/title',$this->resultsBuffer[2]), array(
			'Find Batch Item 11',
		));
		
	}
	
	var $resultsBuffer = array();
	function _oldStyleCallback($results, $batchInfo) {
		$this->assertEqual($batchInfo['totalRecords'],11);
		$this->resultsBuffer[] = $results;
	}

}
?>