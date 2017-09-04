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

namespace Example;

use Eelly\Events\Listener\AclListener;
use Eelly\Events\Listener\ApiLoggerListener;
use Eelly\Events\Listener\AsyncAnnotationListener;
use Eelly\Events\Listener\CacheAnnotationListener;
use Eelly\Events\Listener\ValidationAnnotationListener;
use Eelly\FastDFS\Client as FastDFSClient;
use Eelly\Mvc\AbstractModule;
use Example\Command\TestCommand;
use Phalcon\DiInterface as Di;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;

/**
 * 示例模块
 *
 * 示例代码或测试代码
 *
 * @author hehui<hehui@eelly.net>
 */
class Module extends AbstractModule
{
    public const NAMESPACE = __NAMESPACE__;

    public const NAMESPACE_DIR = __DIR__;

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\Mvc\AbstractModule::registerUserAutoloaders()
     */
    public function registerUserAutoloaders(Di $di): void
    {
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\Mvc\AbstractModule::registerUserServices()
     */
    public function registerUserServices(Di $di): void
    {
        // fastdfs service
        $di->setShared('fastdfs', function () {
            $config = $this->getModuleConfig()->fastdfs;

            return new FastDFSClient($config->toArray());
        });

        $this->registerDbService();
        $this->registerQueueService();
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\Mvc\AbstractModule::attachUserEvents()
     */
    public function attachUserEvents(Di $di): void
    {
        $eventsManager = $this->eventsManager;
        // 日志监听
        $eventsManager->attach('application', $di->get(ApiLoggerListener::class));
        $eventsManager->enablePriorities(true);
        // acl监听
        $eventsManager->attach('dispatch', $di->get(AclListener::class), 200);
        // 异步处理监听器
        $eventsManager->attach('dispatch', $di->get(AsyncAnnotationListener::class), 150);
        // 缓存监听
        $eventsManager->attach('dispatch', $di->get(CacheAnnotationListener::class), 100);
        // 参数校验
        $eventsManager->attach('dispatch', $di->get(ValidationAnnotationListener::class), 50);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\Mvc\AbstractModule::registerCommands()
     */
    public function registerCommands(\Eelly\Console\Application $app): void
    {
        parent::registerCommands($app);
        $this->eventDispatcher->addListener(ConsoleEvents::COMMAND, function (ConsoleCommandEvent $event) {
            // ...
        });
        $this->eventDispatcher->addListener(ConsoleEvents::TERMINATE, function (ConsoleTerminateEvent $event) {
            // ...
        });
        $this->eventDispatcher->addListener(ConsoleEvents::ERROR, function (ConsoleErrorEvent $event) {
            // ...
        });
        $app->add($this->getDI()->getShared(TestCommand::class));
    }
}
