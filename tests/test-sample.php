<?php
/**
 * Class SampleTest
 *
 * @package Ssc_Members
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_sample() {

		wp_set_current_user( 1,'admin');

		// Replace this with some actual testing code.
		$this->assertTrue( is_user_logged_in() );
	}



}
