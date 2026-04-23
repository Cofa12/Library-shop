<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function migrationPaths(): array
    {
        return [
            database_path('migrations/mysql'),
            database_path('migrations/mongodb'),
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        if (collect(class_uses_recursive(static::class))->contains(\Illuminate\Foundation\Testing\DatabaseMigrations::class)) {
            foreach ($this->migrationPaths() as $path) {
                $this->artisan('migrate', [
                    '--path' => $path,
                    '--realpath' => true,
                ]);
            }
        }
    }
}
