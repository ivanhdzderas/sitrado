<?php
/**
 * Converts CI3 Login_model.php → CI4 App\Models\LoginModel.php
 */

$src = 'C:/Proyectos/code/application/models/Login_model.php';
$dst = 'C:/Proyectos/doc/app/Models/LoginModel.php';

$code = file_get_contents($src);

// Strip PHP open and class declaration
$code = preg_replace('/^<\?php\s*/', '', $code);
$code = preg_replace(
    '/class\s+Login_model\s+extends\s+CI_Model\s*\{/',
    <<<'HDR'
namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $DBGroup = 'default';

    /** @var \CodeIgniter\Database\BaseConnection */
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        date_default_timezone_set('America/Mexico_City');
    }

    protected function loggedIn(?string $key = null)
    {
        $data = session()->get('logged_in') ?? [];
        if ($key === null) {
            return $data;
        }
        return $data[$key] ?? null;
    }

HDR
    ,
    $code
);

// Session access: $this->session->logged_in['x'] → $this->loggedIn('x')
$code = preg_replace(
    "/\\\$this->session->logged_in\['([^']+)'\]/",
    "\$this->loggedIn('$1')",
    $code
);
$code = preg_replace(
    '/\$this->session->logged_in\["([^"]+)"\]/',
    "\$this->loggedIn(\"$1\")",
    $code
);
$code = str_replace('$this->session->logged_in', '$this->loggedIn()', $code);

// Query builder compatibility (mostly same in CI4)
// $this->db->select / from / where / get already work similarly on BaseConnection? 
// Actually in CI4, query builder is $this->db->table() based.
// Old style: $this->db->select(); $this->db->from(); $this->db->where(); $this->db->get();
// CI4 still supports some of this via $db->table but not exactly.
// Safer: leave $this->db->query() as-is (works), and fix the few query-builder login methods.

// Fix return false typos
$code = str_replace('return flase;', 'return false;', $code);

// Wrap
$out = "<?php\n\n" . $code;
file_put_contents($dst, $out);
echo "Wrote LoginModel (" . strlen($out) . " bytes)\n";
