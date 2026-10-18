<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

function fails(callable $closure): Closure
{
    return function () use ($closure) {
        $args = func_get_args();

        try {
            $closure(...$args);
        } catch (Throwable $e) {
            expect(true)->toBeTrue();
            return;
        }

        Assert::fail('Expected an exception or failure, but none was thrown.');
    };
}
