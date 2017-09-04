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

namespace Example\Logic;

use Eelly\DTO\FastDFSDTO;
use Eelly\Mvc\LogicController;
use Eelly\SDK\Example\Exception\ExampleException;
use Eelly\SDK\Example\DTO\TimeDTO;
use Eelly\SDK\Example\Service\ParamsInterface;
use Phalcon\Validation;
use Psr\Http\Message\UploadedFileInterface;

/**
 * @author hehui<hehui@eelly.net>
 */
class ParamsLogic extends LogicController implements ParamsInterface
{
    /**
     * {@inheritdoc}
     */
    public function paramsType(int $a, float $b, string $c, array $d, UploadedFileInterface $e): bool
    {
        // TODO: Implement paramsType() method.
    }

    /**
     * {@inheritdoc}
     *
     * @Cache(lifetime=86400)
     */
    public function cacheTime(string $name): TimeDTO
    {
        return TimeDTO::hydractor([
            'name' => $name,
            'time' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @Async(route=abc)
     */
    public function asyncQueue()
    {
        $startTime = microtime(true);
        // test
        sleep(2);
        $endTime = microtime(true);

        return [
            $startTime,
            $endTime,
        ];
    }

    /**
     * {@inheritdoc}
     *
     */
    public function uploadFileToFastDFS(string $name, UploadedFileInterface $file): FastDFSDTO
    {
        // 文件上传到fastdfs
        $fastdfsFilePath = $this->fastdfs->writeUploadedFile($file);
        // 日志记录
        $this->logger->info('上传文件到fastdfs', [$fastdfsFilePath]);

        return FastDFSDTO::hydractor([
            'fastdfsFilePath' => $fastdfsFilePath,
        ]);
    }

    /**
     * 参数校验注解.
     *
     * @Validation(
     *
     *     @Date(0, {format : 'Y-m-d', message : 'Field :field is not a valid date'}),
     *
     *     @Between(1, {minimum: 0, maximum : 100, message : 'Field :field must be within the range of :min to :max'})
     * )
     *
     * @param string $date
     * @param int    $money
     */
    public function validationArguments(string $date, int $money): array
    {
        return [$date, $money];
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\SDK\Member\Service\ParamsInterface::paramArray()
     */
    public function paramArray(array $arr, array $framework): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\SDK\Member\Service\ParamsInterface::returnInt()
     */
    public function returnInt(): int
    {
        return 123;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\SDK\Member\Service\ParamsInterface::returnString()
     */
    public function returnString(): string
    {
        return 'hello eelly';
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\SDK\Member\Service\ParamsInterface::returnArray()
     */
    public function returnArray(): array
    {
        return [
            'key' => 'value',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\SDK\Member\Service\ParamsInterface::returnBool()
     */
    public function returnBool(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\SDK\Member\Service\ParamsInterface::returnfloat()
     */
    public function returnfloat(): float
    {
        return 1.000;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Eelly\SDK\Member\Service\ParamsInterface::returnNull()
     */
    public function returnNull(): void
    {
    }

    /**
     * @throws ExampleException
     *
     * @return bool
     */
    public function throwException(): bool
    {
        throw new ExampleException('逻辑异常');
        return true;
    }

    public function queuePublish()
    {
        $producer = $this->queueFactory->createProducer();
        $producer->setExchangeOptions(['name' => 'hello-exchange', 'type' => 'direct']);
        $messageBody = <<<EOT
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyza
EOT;
        $i = 1000;
        $startTime = microtime(true);
        while ($i--) {
            $producer->publish($messageBody);
        }

        return sprintf('publish messages used %s s.', microtime(true) - $startTime);
    }
}
