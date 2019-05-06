<?php

namespace topshelfcraft\ranger;

use Craft;
use craft\helpers\UrlHelper;

class Palantir {

	const Orthanc = "https://ranger.topshelfcraft.com/w/";

	const Incarnation = "3.0.0";

	public static function see($endpoint = '', $info = null)
	{

		try
		{
			$source = UrlHelper::url();
		}
		catch(\Throwable $e)
		{
			$source = '()';
		}

		try
		{
			$url = static::Orthanc . $endpoint;
			Craft::$app->getApi()->request('GET', $url, [
				'headers' => [
					'X-Ranger-Source' => $source,
					'X-Ranger-SchemaVersion' => static::Incarnation,
				],
				'connect_timeout' => 1,
				'timeout' => 1.618,
				'body' => $info,
			]);
		}
		catch (\Throwable $e)
		{
		}

	}

}
