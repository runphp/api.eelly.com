<?php
/*
 * This file is part of eelly package.
 *
 * (c) eelly.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Command;

use Eelly\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author hehui<hehui@eelly.net>
 */
class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('example:test')
            ->setDescription('这是一个测试命令')
            ->setHelp('这是帮助信息');

        $this->addArgument('name', InputArgument::REQUIRED, '你的名字');

        $this->addOption('age', null, InputOption::VALUE_REQUIRED, '你的年龄');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $age = $input->getOption('age');
        $output->writeln([
            '<info>==========================</>',
            "<info>Hello $name, you are $age years old!</>",
            '<info>==========================</>',
        ]);

        $io = new SymfonyStyle($input, $output);
        $io->progressStart(100);
        $i = 100;
        while ($i--) {
            usleep(100000);
            $io->progressAdvance(1);
        }

        $io->progressFinish();
    }
}
