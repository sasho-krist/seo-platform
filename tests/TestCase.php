<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Преди bootstrap: SQLite :memory:, за да не се използва MySQL от .env (и да не се изтрива dev база).
     */
    public function createApplication(): Application
    {
        $this->enforceSqliteInMemory();

        return parent::createApplication();
    }

    private function enforceSqliteInMemory(): void
    {
        $pairs = [
            'DB_CONNECTION' => 'sqlite',
            'DB_DATABASE' => ':memory:',
            'DB_URL' => '',
            'DB_HOST' => '',
            'DB_PORT' => '',
            'DB_USERNAME' => '',
            'DB_PASSWORD' => '',
        ];

        foreach ($pairs as $key => $value) {
            putenv($key.'='.$value);
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}
