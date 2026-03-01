<?php

$exts = ['openssl', 'curl', 'zip', 'pdo_sqlite', 'sqlite3', 'mbstring', 'fileinfo'];
foreach ($exts as $ext) {
    echo $ext . '=' . (extension_loaded($ext) ? '1' : '0') . PHP_EOL;
}
