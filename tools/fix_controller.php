<?php
/**
 * Fix Login controller conversion issues.
 */

$path = 'C:/Proyectos/doc/app/Controllers/Login.php';
$code = file_get_contents($path);

// Fix mangled redirects
$code = str_replace('return return redirect()->to()->to(', 'return redirect()->to(', $code);
$code = str_replace('return return redirect()->to(', 'return redirect()->to(', $code);
$code = str_replace('redirect()->to()->to(', 'redirect()->to(', $code);

// Fix session()->remove with 2 args (CI3 unset_userdata had 2 args wrongly)
$code = preg_replace(
    "/session\(\)->remove\(\s*'logged_in'\s*,\s*\\\$sess_array\s*\)/",
    "session()->remove('logged_in')",
    $code
);

// Replace user_login_process to use modern auth path compatible with plaintext+hash
// We'll leave original logic but fix validation and session set

// Fix index to return view
$code = preg_replace(
    '/public function index\(\)\s*\{\s*\/\/ helper loaded via BaseController\s*echo view\(\'login_view\'\);\s*\}/s',
    "public function index()\n    {\n        return view('login_view');\n    }",
    $code
);

// Ensure echo view methods flush properly - wrap critical auth methods
// Fix logout
$code = preg_replace(
    '/public function logout\(\)\s*\{.*?echo view\(\'login_view\',\s*\$data\);\s*\}/s',
    <<<'PHP'
public function logout()
    {
        $logged = session()->get('logged_in');
        if (! empty($logged['iduser'])) {
            $this->loginModel->salir($logged['iduser']);
        }
        session()->remove('logged_in');
        session()->remove('grade');
        return redirect()->to(site_url('login'))->with('success', 'La sesión finalizó correctamente.');
    }
PHP
    ,
    $code,
    1
);

file_put_contents($path, $code);

// Count remaining issues
$issues = [];
if (str_contains($code, 'return return')) $issues[] = 'double return';
if (str_contains($code, 'redirect()->to()->to')) $issues[] = 'double to';
if (preg_match('/\$this->load->/', $code)) $issues[] = 'load leftover';
if (preg_match('/\$this->input->/', $code)) $issues[] = 'input leftover';
if (preg_match('/\$this->login_model/', $code)) $issues[] = 'login_model leftover';

echo "Login controller patched\n";
echo "Issues: " . (empty($issues) ? 'none' : implode(', ', $issues)) . "\n";

// Lint
passthru('php -l ' . escapeshellarg($path));
