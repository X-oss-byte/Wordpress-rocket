<?php
namespace WP_Rocket\Engine\Plugin;

use WP_Rocket\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Service provider for the WP Rocket updates.
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * The provided array is a way to let the container
	 * know that a service is provided by this service
	 * provider. Every service that is registered via
	 * this service provider must have an alias added
	 * to this array or it will be ignored.
	 *
	 * @var array
	 */
	protected $provides = [
		'plugin_updater_common_subscriber',
		'plugin_information_subscriber',
		'plugin_updater_subscriber',
	];

	/**
	 * Registers items with the container
	 *
	 * @return void
	 */
	public function register() {
		$api_url = wp_parse_url( WP_ROCKET_WEB_INFO );

		$this->getContainer()->share( 'plugin_updater_common_subscriber', 'WP_Rocket\Engine\Plugin\UpdaterApiCommonSubscriber' )
			->addArgument(
				[
					'api_host'           => $api_url['host'],
					'site_url'           => home_url(),
					'plugin_version'     => WP_ROCKET_VERSION,
					'settings_slug'      => WP_ROCKET_SLUG,
					'settings_nonce_key' => WP_ROCKET_PLUGIN_SLUG,
					'plugin_options'     => $this->getContainer()->get( 'options' ),
				]
			)
			->addTag( 'common_subscriber' );
		$this->getContainer()->share( 'plugin_information_subscriber', 'WP_Rocket\Engine\Plugin\InformationSubscriber' )
			->addArgument(
				[
					'plugin_file' => WP_ROCKET_FILE,
					'api_url'     => WP_ROCKET_WEB_INFO,
				]
			)
			->addTag( 'common_subscriber' );
		$this->getContainer()->share( 'plugin_updater_subscriber', 'WP_Rocket\Engine\Plugin\UpdaterSubscriber' )
			->addArgument(
				[
					'plugin_file'    => WP_ROCKET_FILE,
					'plugin_version' => WP_ROCKET_VERSION,
					'vendor_url'     => WP_ROCKET_WEB_MAIN,
					'api_url'        => WP_ROCKET_WEB_CHECK,
					'icons'          => [
						'2x' => WP_ROCKET_ASSETS_IMG_URL . 'icon-256x256.png',
						'1x' => WP_ROCKET_ASSETS_IMG_URL . 'icon-128x128.png',
					],
				]
			)
			->addTag( 'common_subscriber' );
	}
}