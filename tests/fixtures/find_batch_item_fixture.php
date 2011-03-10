<?php

class FindBatchItemFixture extends CakeTestFixture {

	var $name = 'FindBatchItem';

	var $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false),
	);

	var $records = array(
		array('title' => 'Find Batch Item 01'),
		array('title' => 'Find Batch Item 02'),
		array('title' => 'Find Batch Item 03'),
		array('title' => 'Find Batch Item 04'),
		array('title' => 'Find Batch Item 05'),
		array('title' => 'Find Batch Item 06'),
		array('title' => 'Find Batch Item 07'),
		array('title' => 'Find Batch Item 08'),
		array('title' => 'Find Batch Item 09'),
		array('title' => 'Find Batch Item 10'),
		array('title' => 'Find Batch Item 11'),
	);
}

?>