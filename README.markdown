What is it?
==========

It's a plugin behavior that provides a way of finding all records in batches rather than all at once, so that you can loop through huge lists of records without running out of memory.

Rather than returning any results, it calls a callback function you provide and passes the current bacth of results to it, along with a $batchInfo array containing the current range and total record count.

It accepts the same array of options as a normal `find('all')` does. The `limit` option is used to set the batch size.

Setup
=====

Add this to your model, or your AppModel, or even bind at runtime:

	class MyModel extends AppModel {
		var $actsAs = array('FindBatch.FindBatch');
	}

Usage
=====

PHP 5.3+ style with an anonymous function as a callback
-------------------------------------------------------
	
	$MyModel->findBatch(array(
		'limit' => 5,
		'order' => array('title'=>'asc')
	), function($results, $batchInfo) {
		...
	});
	
Old-skool with an array-style callback
--------------------------------------
	
	$MyModel->findBatch(array(
		'limit' => 5,
		'order' => array('title'=>'asc')
	), array($this,'callbackMethodName'));
	
	function callBackMethodName($results, $batchInfo) {
		...
	}

Suggested callback
------------------

For anonymous functions, pass in external variables by reference with a use() clause in the function header if necessary.
	
	$self = $this;
	
	function ($results, $batchInfo) use(&$self, &$someVariable) {
		// Batch info is available like so:
		echo "These are records {$batchInfo['start']} to {$batchInfo['end']} of {$batchInfo['totalRecords']} ... \n";
		foreach($results as $result) {
			// do your processing here
		}
	}