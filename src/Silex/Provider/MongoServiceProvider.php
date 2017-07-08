<?php
namespace Silex\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use MongoDB\Client;

/**
 * Class MongoDBServiceProvider.
 *
 * @package Silex\Provider
 */
class MongoDBServiceProvider implements ServiceProviderInterface
{
    /**
     * Register Mongo provider.
     *
     * @param Container $app Application dependency container.
     * @return mixed
     */
    public function register(Container $app)
    {
        $app['mongo'] = function ($app) {
            $config = [
                'server' => 'mongodb://localhost:27017',
                'options' => [],
                'driverOptions' => [],
            ];
            if (!isset($app['mongo.config'])) {
                $app['mongo.config'] = [];
            }
            foreach ($config as $key => $value) {
                if (isset($app['mongo.config'][$key])) {
                    $config[$key] = $app['mongo.config'][$key];
                }
            }
            $app['mongo.config'] = $config;
            $client = new Client(
                $app['mongo.config']['server'],
                $app['mongo.config']['options'],
                $app['mongo.config']['driverOptions']
            );
            return $client;
        };
    }
}
