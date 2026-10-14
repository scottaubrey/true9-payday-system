<?php

declare(strict_types=1);

namespace Scottaubrey\True9PaydaySystem\Tests;

use PHPUnit\Framework\TestCase;

abstract class ApiTestCase extends TestCase
{
    /**
     * @return null|array<string, string>
     */
    protected function makePayDayRequestAndDecode(string $_year, string $_month): ?array
    {
        return null;
    }
}
