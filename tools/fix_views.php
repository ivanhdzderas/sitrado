<?php
/**
 * Mass-fix CI3 views for CI4:
 * - $this->session->logged_in → session()->get('logged_in')
 * - base_url() already works
 */

$root = 'C:/Proyectos/doc/app/Views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
$fixed = 0;

foreach ($iterator as $file) {
    if (! $file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }
    $path = $file->getPathname();
    // Skip our new modern views? Fix all for consistency.
    $code = file_get_contents($path);
    $orig = $code;

    $code = preg_replace(
        "/\\\$this->session->logged_in\['([^']+)'\]/",
        "session()->get('logged_in')['$1']",
        $code
    );
    $code = preg_replace(
        '/\$this->session->logged_in\["([^"]+)"\]/',
        "session()->get('logged_in')[\"$1\"]",
        $code
    );
    $code = str_replace('$this->session->logged_in', "session()->get('logged_in')", $code);
    $code = str_replace('$this->session->userdata', "session()->get", $code);
    $code = preg_replace('/\$this->session->([^;\(\s]+)/', "session()->$1", $code);

    // site_url / base_url already helpers

    if ($code !== $orig) {
        file_put_contents($path, $code);
        $fixed++;
    }
}

echo "Fixed $fixed view files\n";
