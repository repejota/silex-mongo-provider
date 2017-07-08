<?php
namespace Silex\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use MongoDB\Client;

/**
 * Class MongoServiceProvider.
 *
 * @package Silex\Provider
 */
class MongoServiceProvider implements ServiceProviderInterface
{
    /**
     * Default options
     */
    const DEFAULT_OPTIONS = [
        'server' => 'mongodb://localhost:27017',
        'options' => [],
        'driverOptions' => [],
    ];

    /**
     * Register Mongo provider.
     *
     * @param Container $app Application dependency container.
     * @return void
     */
    public function register(Container $app)
    {
        $app['mongo'] = function ($app) {
            // default options
            $config = MongoServiceProvider::DEFAULT_OPTIONS;

            // process options
            if (!isset($app['mongo.config'])) {
                $app['mongo.config'] = [];
            }
            foreach ($config as $key => $value) {
                if (isset($app['mongo.config'][$key])) {
                    $config[$key] = $app['mongo.config'][$key];
                }
            }
            $app['mongo.config'] = $config;

            // create database connection
            $client = new Client(
                $app['mongo.config']['server'],
                $app['mongo.config']['options'],
                $app['mongo.config']['driverOptions']
            );
            return $client;
        };
    }
}
