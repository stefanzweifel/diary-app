<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // Framework-supplied test case methods snipped for brevity
    // Use this version if you're on PHP 7
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {

            use Exception;

            public function __construct() {}

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e) {
                throw $e;
            }
        });
    }

}
