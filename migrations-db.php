<?php

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

return [
  'host' => getenv('DATABASE_HOST'),
  'user' => getenv('DATABASE_USER'),
  'dbname' => getenv('DATABASE_NAME'),
  'password' => getenv('DATABASE_PASSWORD'),
  'driver' => getenv('DATABASE_DRIVER'),
];