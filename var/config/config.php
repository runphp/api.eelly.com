<?php

declare(strict_types=1);

/*
 * This file is part of eelly package.
 *
 * (c) eelly.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (isset($_SERVER['REQUEST_TIME_FLOAT'])) {
    $requestTime = $_SERVER['REQUEST_TIME_FLOAT'];
} elseif (isset($_SERVER['REQUEST_TIME'])) {
    $requestTime = $_SERVER['REQUEST_TIME'];
} else {
    $requestTime = microtime(true);
}

require 'vendor/autoload.php';
$di = PHP_SAPI == 'cli' ? new \Eelly\Di\ConsoleDi() : new \Eelly\Di\ServiceDi();
$di->setShared('config', function () use ($requestTime) {
    $dotenv = new \Dotenv\Dotenv(getcwd(), file_exists('.env') ? '.env' : '.env.example');
    $dotenv->load();
    $env = getenv('APPLICATION_ENV');
    // 需要加载的模块
    $moduleNameList = [
        'example',
    ];
    $modules = [];
    foreach ($moduleNameList as $value) {
        $modules[$value] = [
            'className' => ucfirst($value).'\\Module',
            'path'      => 'src/'.ucfirst($value).'/Module.php',
        ];
    }
    $config = new \Phalcon\Config([
        // 请求时间
        'requestTime' => $requestTime,
        // 系统环境(默认生产环境)
        'env'     => $env,
        'modules' => $modules,
        // 日志路径
        'logPath' => 'var/logs',
        // 默认时区
        'defaultTimezone' => 'Asia/Shanghai',
    ]);

    return $config;
});

if (class_exists('Eelly\DevTools\DevTools')) {
    isset($argv) && is_array($argv) && array_shift($argv) && $GLOBALS['argv'] = $argv;
    $config = $di->getConfig();
    $config->merge(require 'devtools.php');
    (new \Eelly\DevTools\DevTools($di))->run();
}

return $di;
