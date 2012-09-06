<?php

namespace Rizeway\JobBundle\JobHandler;

use Rizeway\JobBundle\Logger\LoggerInterface;

interface JobHandlerInterface
{
    public function setOptions(array $options);
    public function setLogger(LoggerInterface $logger);
    public function run();
}