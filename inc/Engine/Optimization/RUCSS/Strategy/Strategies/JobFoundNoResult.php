<?php

namespace WP_Rocket\Engine\Optimization\RUCSS\Strategy\Strategies;


use WP_Rocket\Engine\Optimization\RUCSS\Database\Queries\UsedCSS as UsedCSS_Query;

/**
 * Class managing the retry process of RUCSS whenever a Job is found without any results yet.
 */
class JobFoundNoResult implements StrategyInterface {
	/**
	 * UsedCss Query instance.
	 *
	 * @var UsedCSS_Query
	 */
	protected $used_css_query;

	public function __construct(UsedCSS_Query $used_css_query) {
		$this->used_css_query       = $used_css_query;

	}

	public function do_retry(object $row_details, array $job_details) {
		// In case the job has been found but with no results, the plugin must retry for longer than 3 minutes after the
		// job has been sent. This timing must be filterable, but a good target would be up to 30 minutes.

		// Exponential increase of time to retry

		/**
		 * Filter used css retry duration
		 *
		 * @param int $duration Duration between each retry in seconds
		 */
		$rucss_retry_duration = apply_filters('rocket_rucss_retry_duration', 60); // rocket_rucss_retry_duration hasn't been created

		// update the `not_proceed_before` column
		$not_proceed_before = current_time('timestamp') + $rucss_retry_duration;

		$this->used_css_query->update_not_processed_before($row_details->job_id, $not_proceed_before);

	}

}
