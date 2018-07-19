<?php
/**
 * Created by PhpStorm.
 * User: romariololz
 * Date: 19/07/18
 * Time: 21:39
 */

namespace App\Helper;


use Psr\Log\LoggerInterface;

Trait LoggerTrait
{
    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @required
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logInfo(string $message, array $context = [])
    {
        if ($this->logger)
        {
            $this->logger->info($message, $context);
        }
    }
}