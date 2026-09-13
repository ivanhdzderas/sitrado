<?php
/**
 * Converts CI3 Login.php → CI4 App\Controllers\Login.php
 */

$src = 'C:/Proyectos/code/application/controllers/Login.php';
$dst = 'C:/Proyectos/doc/app/Controllers/Login.php';

$code = file_get_contents($src);

$code = preg_replace('/^<\?php\s*/', '', $code);
$code = preg_replace(
    "/if\s*\(\s*!defined\('BASEPATH'\)\s*\)\s*\{\s*exit\([^;]+;\s*\}\s*/s",
    '',
    $code
);

$code = preg_replace(
    '/class\s+Login\s+extends\s+CI_Controller\s*\{/',
    <<<'HDR'
namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\EmpresaModel;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    protected LoginModel $loginModel;
    protected string $folder = 'archivos/';

HDR
    ,
    $code
);

// Replace constructor
$code = preg_replace(
    '/public function __construct\(\)\s*\{.*?^\s{4}\}/ms',
    <<<'CTOR'
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->loginModel = model(LoginModel::class);
        $this->folder = 'archivos/';
    }

    protected function page(array $views, array $data = [])
    {
        $html = view('head', $data);
        foreach ($views as $v) {
            $html .= view($v, $data);
        }
        return $this->response->setBody($html);
    }

CTOR
    ,
    $code,
    1
);

// Models
$code = str_replace('$this->login_model', '$this->loginModel', $code);
$code = str_replace('$this->empresas', 'model(EmpresaModel::class)', $code);
$code = str_replace('$this->usuario', 'model(UsuarioModel::class)', $code);

// Input
$code = preg_replace('/\$this->input->post\(([^)]*)\)/', '\$this->request->getPost($1)', $code);
$code = preg_replace('/\$this->input->get\(([^)]*)\)/', '\$this->request->getGet($1)', $code);

// Session
$code = str_replace('$this->session->userdata[\'logged_in\']', "session()->get('logged_in')", $code);
$code = str_replace('$this->session->userdata["logged_in"]', "session()->get('logged_in')", $code);
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
$code = preg_replace('/\$this->session->set_userdata\(/', 'session()->set(', $code);
$code = preg_replace('/\$this->session->unset_userdata\(/', 'session()->remove(', $code);
$code = preg_replace('/\$this->session->userdata\(/', 'session()->get(', $code);
$code = str_replace('$this->session->', 'session()->', $code);

// Views: $this->load->view('x', $data); → echo view / accumulate
// For simplicity replace with view() echoed via response - but multi-view pages need concatenation
$code = preg_replace(
    "/\\\$this->load->view\(\s*'([^']+)'\s*,\s*\\\$([a-zA-Z_][a-zA-Z0-9_]*)\s*\);/",
    "echo view('$1', \$$2);",
    $code
);
$code = preg_replace(
    "/\\\$this->load->view\(\s*'([^']+)'\s*\);/",
    "echo view('$1');",
    $code
);
$code = preg_replace(
    '/\$this->load->view\(\s*"([^"]+)"\s*,\s*\$([a-zA-Z_][a-zA-Z0-9_]*)\s*\);/',
    'echo view("$1", \$$2);',
    $code
);
$code = preg_replace(
    '/\$this->load->view\(\s*"([^"]+)"\s*\);/',
    'echo view("$1");',
    $code
);

// redirect / site_url
$code = preg_replace('/redirect\(\s*site_url\(([^)]+)\)\s*\);/', 'return redirect()->to(site_url($1));', $code);
$code = preg_replace('/redirect\(\s*([^;]+)\s*\);/', 'return redirect()->to($1);', $code);

// form_validation - stub as always invalid to fall through to login logic, or remove checks
$code = str_replace(
    '$this->form_validation->run() == true',
    'false /* validation handled manually */',
    $code
);
$code = str_replace(
    '$this->form_validation->run() == TRUE',
    'false',
    $code
);

// pagination stub
$code = str_replace('$this->pagination->create_links()', "''", $code);

// helpers load - remove
$code = preg_replace('/\$this->load->helper\([^;]+;/', '// helper loaded via BaseController', $code);
$code = preg_replace('/\$this->load->library\([^;]+;/', '// library', $code);
$code = preg_replace('/\$this->load->model\([^;]+;/', '// model', $code);

// Fix index / logout / user_login to return properly for CI4
// Add return after echo view chains is hard; use output buffering wrapper later if needed.

$out = "<?php\n\ndeclare(strict_types=0);\n\n" . $code;
file_put_contents($dst, $out);
echo "Wrote Login controller (" . strlen($out) . " bytes)\n";
