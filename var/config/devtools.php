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

return new \Phalcon\Config([
    // 是否开启build模式
    'buildMode' => false,
    // 是否开始mysql严格模式
    'mysqlMode' => true,
    // 需构建的模块
    'devModules' => [
        'oauth',
        'user',
        'store',
        'goods',
        'pay',
        'order',
        'service',
        'message',
        'system',
        'log',
    ],
    'dbHost'    => '172.18.107.97',
    'dbUser'    => 'devmall',
    'dbPass'    => 'devmall',
    'dbPort'    => '3306',
    'dbCharset' => 'utf8',
    'dbPrefix'  => 'el_', //el_
    'oauthDb'   => [
        'host'     => '172.18.107.97',
        'dbname'   => 'el_oauth',
        'port'     => '3306',
        'username' => 'devmall',
        'password' => 'devmall',
        'charset'  => 'utf8',
    ],
    // 是否提前生成logic,预生成的logic为空类,如需interface内的代码生成到logic设置为false即可
    'beforeLogic' => false,
    // 注册命令到symfonyConsole
    'registerCommand' => [
        \Eelly\DevTools\Command\ReturnExplainCommand::class,
        \Eelly\DevTools\Command\ModuleAclCommand::class,
        \Eelly\DevTools\Command\CreatePhpunitCommand::class,
    ],
]);
