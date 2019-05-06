<?php

namespace topshelfcraft\ranger;

use Craft;
use craft\base\Plugin as CraftPlugin;
use craft\events\PluginEvent;
use craft\services\Plugins;
use yii\base\Event;

class Plugin {

	public static function watch(CraftPlugin $plugin)
	{

		try {

			Event::on(
				Plugins::class,
				Plugins::EVENT_AFTER_INSTALL_PLUGIN,
				function (PluginEvent $event) use ($plugin) {
					if ($event->plugin === $plugin) {
						Palantir::see(($plugin->getHandle() . '/install'));
					}
				}
			);

			Event::on(
				Plugins::class,
				Plugins::EVENT_AFTER_UNINSTALL_PLUGIN,
				function (PluginEvent $event) use ($plugin) {
					if ($event->plugin === $plugin) {
						Palantir::see(($plugin->getHandle() . '/uninstall'));
					}
				}
			);

			if ($updated = Craft::$app->getCache()->get($plugin->getHandle() . '.updated')) {
				Craft::$app->getCache()->delete($plugin->getHandle() . '.updated');
				Palantir::see(($plugin->getHandle() . '/update'));
			}

		}
		catch (\Throwable $e)
		{
		}

	}

}
