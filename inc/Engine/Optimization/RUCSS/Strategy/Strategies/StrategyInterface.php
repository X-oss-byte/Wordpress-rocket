<?php

namespace WP_Rocket\Engine\Optimization\RUCSS\Strategy\Strategies;

interface StrategyInterface {
	/**
	 * Execute the retry process of a RUCSS job.
	 *
	 * @param object $row_details
	 * @param array $job_details
	 *
	 * @return mixed
	 */
	public function do_retry(object $row_details, array $job_details);
}
