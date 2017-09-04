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

return new Phalcon\Config([
    'amqp'         => require 'example/amqp.php',
    'annotations'  => require 'example/annotations.php',
    'cache'        => require 'example/cache.php',
    'fastdfs'      => require 'example/fastdfs.php',
    'mongodb'      => require 'example/mongodb.php',
    'mysql'        => require 'example/mysql.php',
    'oauth2Client' => require 'example/oauth2Client.php',
]);
