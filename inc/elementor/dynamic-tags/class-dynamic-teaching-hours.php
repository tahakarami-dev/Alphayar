<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

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
			SELECT vm.meta_value
			FROM {$wpdb->prefix}posts lesson
			INNER JOIN {$wpdb->prefix}postmeta vm 
				ON lesson.ID = vm.post_id AND vm.meta_key = '_video'
			INNER JOIN {$wpdb->prefix}postmeta cm 
				ON lesson.ID = cm.post_id AND cm.meta_key = 'course_id'
			INNER JOIN {$wpdb->prefix}posts course 
				ON course.ID = cm.meta_value
			WHERE lesson.post_type = 'lesson'
			  AND lesson.post_status = 'publish'
			  AND course.post_status = 'publish'
		");

		foreach ($results as $row) {
			$data = maybe_unserialize($row->meta_value);

			if (!is_array($data) || empty($data['runtime']) || !is_array($data['runtime'])) {
				continue;
			}

			$hours   = intval($data['runtime']['hours'] ?? 0);
			$minutes = intval($data['runtime']['minutes'] ?? 0);
			$seconds = intval($data['runtime']['seconds'] ?? 0);

			if ($hours === 0 && $minutes === 0 && $seconds === 0) {
				continue;
			}

			$total_seconds += ($hours * 3600) + ($minutes * 60) + $seconds;
		}

		if ($total_seconds === 0) {
			echo 0;
			return;
		}

		$total_hours = ceil($total_seconds / 3600);
		echo $total_hours;
	}
}
