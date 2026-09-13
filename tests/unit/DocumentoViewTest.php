<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class DocumentoViewTest extends CIUnitTestCase
{
    public function testDocumentoViewRendersEmptyState(): void
    {
        $html = view('archivos/documento', [
            'documentos' => [],
            'tipo'       => 'POL',
        ]);

        $this->assertStringContainsString('Políticas', $html);
        $this->assertStringContainsString('No hay documentos disponibles', $html);
        $this->assertStringNotContainsString('login_model', $html);
    }

    public function testDocumentoViewRendersRowsWithoutCallingModel(): void
    {
        $doc = (object) [
            'id'            => 7,
            'nombre'        => 'POL-001 Política de calidad',
            'descarga'      => 'SI',
            'tipo'          => 'POL',
            'departamento'  => 'Calidad',
        ];

        $html = view('archivos/documento', [
            'documentos' => [$doc],
            'tipo'       => 'POL',
        ]);

        $this->assertStringContainsString('POL-001 Política de calidad', $html);
        $this->assertStringContainsString('Calidad', $html);
        $this->assertStringContainsString('leer/7', $html);
        $this->assertStringContainsString('descargar/7', $html);
        $this->assertStringNotContainsString('No hay documentos disponibles', $html);
    }

    public function testDocumentoViewHidesDownloadWhenNotAllowed(): void
    {
        $doc = (object) [
            'id'           => 3,
            'nombre'       => 'POL-002',
            'descarga'     => 'NO',
            'tipo'         => 'POL',
            'departamento' => 'RH',
        ];

        $html = view('archivos/documento', [
            'documentos' => [$doc],
            'tipo'       => 'POL',
        ]);

        $this->assertStringContainsString('leer/3', $html);
        $this->assertStringNotContainsString('descargar/3', $html);
    }

    /**
     * @dataProvider tipoTituloProvider
     */
    public function testDocumentoViewShowsTipoTitle(string $tipo, string $expected): void
    {
        $html = view('archivos/documento', [
            'documentos' => [],
            'tipo'       => $tipo,
        ]);

        $this->assertStringContainsString($expected, $html);
    }

    public static function tipoTituloProvider(): array
    {
        return [
            ['POL', 'Políticas'],
            ['D', 'Directrices'],
            ['P', 'Procedimientos'],
            ['I', 'Instructivos'],
            ['F', 'Formatos'],
        ];
    }
}
