<?php


namespace WP_Rocket\Engine\Optimization\RUCSS\Strategy\Factory;
use WP_Rocket\Engine\Optimization\RUCSS\Database\Queries\UsedCSS as UsedCSS_Query;

class StrategyFactory
{
	protected $api;

	protected $used_css_query;

	public function __construct($api, UsedCSS_Query $used_css_query)
	{
		$this->api = $api;
		$this->used_css_query       = $used_css_query;
	}

	public function manage($row_details): void
	{
		$job_details = $this->api->get_queue_job_status($row_details->job_id, $row_details->queue_name, $this->is_home($row_details->url));

		if (empty($job_details['contents'])) {
			// Job has been found but no results

			return;
		}

		switch ($job_details['code']) {
			case 408:
				// Reset retry process
				return;
		}

		return;
	}

	/**
	 * Check if current page is the home page.
	 *
	 * @param string $url Current page url.
	 *
	 * @return bool
	 */
	private function is_home( string $url ): bool {
		/**
		 * Filters the home url.
		 *
		 * @since 3.11.4
		 *
		 * @param string  $home_url home url.
		 * @param string  $url url of current page.
		 */
		$home_url = apply_filters( 'rocket_rucss_is_home_url', home_url(), $url );
		return untrailingslashit( $url ) === untrailingslashit( $home_url );
	}
}
