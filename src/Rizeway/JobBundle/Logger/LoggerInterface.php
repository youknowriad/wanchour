<?php

namespace Rizeway\JobBundle\Logger;

interface LoggerInterface
{
    const PRIORITY_INFO = 1;
    const PRIORITY_WARNING = 2;
    const PRIORITY_ERROR = 3;

    public function log($message, $priority = self::PRIORITY_INFO);
}