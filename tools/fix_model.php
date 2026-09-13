<?php
/**
 * Post-process converted LoginModel for CI4 DB API.
 */

$path = 'C:/Proyectos/doc/app/Models/LoginModel.php';
$code = file_get_contents($path);

// result APIs
$replacements = [
    '->result_array()' => '->getResultArray()',
    '->result()'       => '->getResult()',
    '->num_rows()'     => '->getNumRows()',
    '->row_array()'    => '->getRowArray()',
    '->row()'          => '->getRow()',
];

foreach ($replacements as $from => $to) {
    $code = str_replace($from, $to, $code);
}

// Fix login() method to use CI4 query builder
$loginNew = <<<'PHP'
    public function login($username, $password)
    {
        $query = $this->db->table('usuario')
            ->select('id, nombre, tipo, juntas')
            ->where('usuario', $username)
            ->where('pass', $password)
            ->get()
            ->getResultArray();

        return ! empty($query) ? $query : false;
    }
PHP;

$code = preg_replace(
    '/public function login\(\$username, \$password\)\s*\{.*?\n    \}/s',
    $loginNew,
    $code,
    1
);

// Fix read_user_information
$readNew = <<<'PHP'
    public function read_user_information($username)
    {
        $query = $this->db->table('usuario')
            ->where('usuario', $username)
            ->limit(1)
            ->get();

        if ($query->getNumRows() === 1) {
            return $query->getResult();
        }

        return false;
    }
PHP;

$code = preg_replace(
    '/public function read_user_information\(\$username\)\s*\{.*?\n    \}/s',
    $readNew,
    $code,
    1
);

file_put_contents($path, $code);
echo "LoginModel patched\n";

// Also fix remaining CI3 builder chains that use select/from/where/get without table()
// These are rare - grep later.
