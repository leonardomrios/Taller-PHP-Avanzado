<?php
$root = dirname(__DIR__); // raíz del proyecto (un nivel arriba de /config)

function resolve_path_from_root(string $path, string $root): string {
    // ¿es absoluta? (Windows o Unix)
    $isAbsolute = preg_match('/^(?:[A-Za-z]:[\/\\\\]|\/)/', $path) === 1;
    if ($isAbsolute) {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }
    // relativa → resolver respecto a la raíz del proyecto
    $rel = ltrim($path, "/\\");
    return $root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rel);
}

$envUpload = $_ENV['UPLOAD_DIR'] ?? '';
$defaultUploadDir = $root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
$uploadDir = $envUpload ? resolve_path_from_root($envUpload, $root) : $defaultUploadDir;

return [
  'app_name' => $_ENV['APP_NAME'] ?? 'Demo Empresa & Ventas',
  'smtp' => [
    'dsn'  => $_ENV['MAILER_DSN'] ?? 'null://null',
    'from' => $_ENV['MAILER_FROM'] ?? 'Demo <no-reply@example.test>',
  ],
  'upload_dir' => $uploadDir,
];
