<?php
header('Content-Type: application/json');
$envPath = __DIR__ . '/../.env';
$info = [
    'cwd' => getcwd(),
    'public_dir' => __DIR__,
    'env_exists' => file_exists($envPath),
    'env_path' => $envPath,
    'php_version' => phpversion(),
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? null,
    'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
];

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

// Resolve config after bootstrap
$config = $app->make('config');
$defaultConnection = $config->get('database.default');
$info['config_app_key'] = $config->get('app.key');
$info['config_app_debug'] = $config->get('app.debug');
$info['config_db_connection'] = $config->get('database.default');
$info['config_db_host'] = $config->get("database.connections.$defaultConnection.host");
$info['config_db_port'] = $config->get("database.connections.$defaultConnection.port");
$info['config_db_database'] = $config->get("database.connections.$defaultConnection.database");
$info['config_env_path'] = $app->environmentPath();
$info['config_env_file'] = $app->environmentFile();

echo json_encode($info);
