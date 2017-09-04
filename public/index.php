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

chdir(dirname(__DIR__));

(new class(require 'var/config/config.php') {
    public function __construct(\Phalcon\DiInterface $di)
    {
        $di->getShared(\Eelly\Application\ServiceApplication::class)->run();
    }
});
