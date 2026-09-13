<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class AppHelperTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        helper('app');
    }

    public function testLoginModelHelperExists(): void
    {
        $this->assertTrue(function_exists('login_model'));
    }

    public function testLoginModelHelperReturnsLoginModel(): void
    {
        $model = login_model();
        $this->assertInstanceOf(\App\Models\LoginModel::class, $model);
    }

    public function testLoggedInHelperReturnsNullKeyWithoutSession(): void
    {
        session()->remove('logged_in');
        $this->assertNull(logged_in('iduser'));
        $this->assertSame([], logged_in());
    }

    public function testLoggedInHelperReadsSession(): void
    {
        session()->set('logged_in', [
            'iduser' => 42,
            'tipo'   => 'admin',
            'nombre' => 'Tester',
        ]);

        $this->assertSame(42, logged_in('iduser'));
        $this->assertSame('admin', logged_in('tipo'));
        $this->assertSame('Tester', logged_in()['nombre']);
    }
}
