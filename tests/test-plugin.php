<?php

class TestReadme extends WP_UnitTestCase {
	private $readme_data;

	public function testStableTagMatchesVersion() {
		if ( ! $readme_data = $this->get_readme() ) {
			$this->fail( 'There is no readme file' );
		}
		$plugin_data = get_plugin_data( dirname( dirname( __FILE__ ) ) . '/user-switching.php' );

		self::assertEquals( $readme_data['stable_tag'], $plugin_data['Version'] );
	}

	private function get_readme() {
		if( ! isset( $this->readme_data ) ) {
			$file = dirname( dirname( __FILE__ ) ) . '/readme.md';

			if ( ! is_file( $file ) ) {
				return false;
			}

			$file_contents = implode( '', file( $file ) );

			preg_match( '|Tested up to:(.*)|i', $file_contents, $_tested_up_to );
			preg_match( '|Stable tag:(.*)|i', $file_contents, $_stable_tag );

			$this->readme_data = array(
				'tested_up_to' => trim( trim( $_tested_up_to[1], '*' ) ),
				'stable_tag'   => trim( trim( $_stable_tag[1], '*' ) )
			);
		}

		return $this->readme_data;
	}

}
