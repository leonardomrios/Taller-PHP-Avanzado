<?php
return [
  'app_name' => $_ENV['APP_NAME'] ?? 'Demo Empresa & Ventas',
  'smtp' => [
    'dsn'  => $_ENV['MAILER_DSN'] ?? 'null://null',       // “null” descarta el envío si no hay DSN
    'from' => $_ENV['MAILER_FROM'] ?? 'Demo <no-reply@example.test>',
  ],
  'upload_dir' => $_ENV['UPLOAD_DIR'] ?? __DIR__ . '/../public/assets/uploads',
];
