<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AAC_Teaching_Hours_Tag extends \Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'aac_teaching_hours';
	}

	public function get_title() {
		return 'ساعات آموزش سایت';
	}

	public function get_group() {
		return 'site';
	}

	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	protected function register_controls() {
		
	}

	public function render() {
		global $wpdb;
	
		$total_seconds = 0;
	
		$results = $wpdb->get_results("
			SELECT pm.meta_value
			FROM {$wpdb->prefix}posts p
			JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
			WHERE p.post_type = 'lesson'
			  AND p.post_status = 'publish'
			  AND pm.meta_key = '_video'
		");
	
		foreach ( $results as $row ) {
			$data = @unserialize( $row->meta_value );
			if ( $data && isset( $data['runtime'] ) ) {
				$hours   = isset( $data['runtime']['hours'] )   ? intval( $data['runtime']['hours'] )   : 0;
				$minutes = isset( $data['runtime']['minutes'] ) ? intval( $data['runtime']['minutes'] ) : 0;
				$seconds = isset( $data['runtime']['seconds'] ) ? intval( $data['runtime']['seconds'] ) : 0;
	
				$total_seconds += ($hours * 3600) + ($minutes * 60) + $seconds;
			}
		}
	
		$total_hours = $total_seconds / 3600;
	
	
		$rounded_hours = ceil($total_hours);
	
		
		echo $rounded_hours;
	}
	
	
}




