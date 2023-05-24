<?php

use Illuminate\Support\Str;

return [
  'default' => env('DB_CONNECTION', 'mysql'),

  'connections' => [

    'admin' => [
      'driver' => 'mysql',
      'url' => env('DATABASE_URL_ADMIN'),
      'host' => env('DB_HOST_ADMIN', '127.0.0.1'),
      'port' => env('DB_PORT_ADMIN', '3306'),
      'database' => env('DB_DATABASE_ADMIN', 'forge'),
      'username' => env('DB_USERNAME_ADMIN', 'forge'),
      'password' => env('DB_PASSWORD_ADMIN', ''),
      'unix_socket' => env('DB_SOCKET', ''),
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4_unicode_ci',
      'prefix' => '',
      'prefix_indexes' => true,
      'strict' => true,
      'engine' => null,
      'expire' => 3600,
      'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
      ]) : [],
    ],

    'os' => [
      'driver' => 'mysql',
      'url' => env('DATABASE_URL_OS'),
      'host' => env('DB_HOST_OS', '127.0.0.1'),
      'port' => env('DB_PORT_OS', '3306'),
      'database' => env('DB_DATABASE_OS', 'forge'),
      'username' => env('DB_USERNAME_OS', 'forge'),
      'password' => env('DB_PASSWORD_OS', ''),
      'unix_socket' => env('DB_SOCKET', ''),
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4_unicode_ci',
      'prefix' => '',
      'prefix_indexes' => true,
      'strict' => true,
      'engine' => null,
      'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
      ]) : [],
    ],

    'key' => [
      'driver' => 'pgsql',
      'url' => env('DATABASE_URL_KEY'),
      'host' => env('DB_HOST_KEY', '127.0.0.1'),
      'port' => env('DB_PORT_KEY', '5432'),
      'database' => env('DB_DATABASE_KEY', 'forge'),
      'username' => env('DB_USERNAME_KEY', 'forge'),
      'password' => env('DB_PASSWORD_KEY', ''),
      'charset' => 'utf8',
      'prefix' => '',
      'prefix_indexes' => true,
      'search_path' => 'public',
      'sslmode' => 'prefer',
    ],

    'sqlite' => [
      'driver' => 'sqlite',
      'url' => env('DATABASE_URL'),
      'database' => env('DB_DATABASE', database_path('database.sqlite')),
      'prefix' => '',
      'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
    ],

    'mysql' => [
      'driver' => 'mysql',
      'url' => env('DATABASE_URL'),
      'host' => env('DB_HOST', '127.0.0.1'),
      'port' => env('DB_PORT', '3306'),
      'database' => env('DB_DATABASE', 'forge'),
      'username' => env('DB_USERNAME', 'forge'),
      'password' => env('DB_PASSWORD', ''),
      'unix_socket' => env('DB_SOCKET', ''),
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4_unicode_ci',
      'prefix' => '',
      'prefix_indexes' => true,
      'strict' => true,
      'engine' => null,
      'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
      ]) : [],
    ],

    'pgsql' => [
      'driver' => 'pgsql',
      'url' => env('DATABASE_URL'),
      'host' => env('DB_HOST', '127.0.0.1'),
      'port' => env('DB_PORT', '5432'),
      'database' => env('DB_DATABASE', 'forge'),
      'username' => env('DB_USERNAME', 'forge'),
      'password' => env('DB_PASSWORD', ''),
      'charset' => 'utf8',
      'prefix' => '',
      'prefix_indexes' => true,
      'search_path' => 'public',
      'sslmode' => 'prefer',
    ],

    'sqlsrv' => [
      'driver' => 'sqlsrv',
      'url' => env('DATABASE_URL'),
      'host' => env('DB_HOST', 'localhost'),
      'port' => env('DB_PORT', '1433'),
      'database' => env('DB_DATABASE', 'forge'),
      'username' => env('DB_USERNAME', 'forge'),
      'password' => env('DB_PASSWORD', ''),
      'charset' => 'utf8',
      'prefix' => '',
      'prefix_indexes' => true,
    ],

  ],

  'migrations' => 'migrations',

  'redis' => [

    'client' => env('REDIS_CLIENT', 'phpredis'),

    'options' => [
      'cluster' => env('REDIS_CLUSTER', 'redis'),
      'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
    ],

    'default' => [
      'url' => env('REDIS_URL'),
      'host' => env('REDIS_HOST', '127.0.0.1'),
      'username' => env('REDIS_USERNAME'),
      'password' => env('REDIS_PASSWORD'),
      'port' => env('REDIS_PORT', '6379'),
      'database' => env('REDIS_DB', '0'),
    ],

    'cache' => [
      'url' => env('REDIS_URL'),
      'host' => env('REDIS_HOST', '127.0.0.1'),
      'username' => env('REDIS_USERNAME'),
      'password' => env('REDIS_PASSWORD'),
      'port' => env('REDIS_PORT', '6379'),
      'database' => env('REDIS_CACHE_DB', '1'),
    ],

  ],

];
