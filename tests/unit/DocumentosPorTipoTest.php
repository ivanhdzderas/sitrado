<?php

use App\Models\LoginModel;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class DocumentosPorTipoTest extends CIUnitTestCase
{
    public function testDocumentosPorTipoReturnsEmptyWhenNoIds(): void
    {
        $model = $this->getMockBuilder(LoginModel::class)
            ->onlyMethods(['carga_archivos2', 'lista_documentos'])
            ->disableOriginalConstructor()
            ->getMock();

        $model->expects($this->once())
            ->method('carga_archivos2')
            ->willReturn(false);

        $model->expects($this->never())
            ->method('lista_documentos');

        $this->assertSame([], $model->documentosPorTipo('POL'));
    }

    public function testDocumentosPorTipoAggregatesMatchingRows(): void
    {
        $idsResult = $this->createQueryResult([
            (object) ['id_documento' => 10],
            (object) ['id_documento' => 20],
        ]);

        $rowsA = $this->createQueryResult([
            (object) [
                'id'           => 10,
                'nombre'       => 'POL-A',
                'descarga'     => 'SI',
                'tipo'         => 'POL',
                'departamento' => 'Calidad',
            ],
        ]);

        $rowsB = $this->createQueryResult([]); // vacío

        $model = $this->getMockBuilder(LoginModel::class)
            ->onlyMethods(['carga_archivos2', 'lista_documentos'])
            ->disableOriginalConstructor()
            ->getMock();

        $model->method('carga_archivos2')->willReturn($idsResult);
        $model->method('lista_documentos')
            ->willReturnMap([
                [10, 'POL', $rowsA],
                [20, 'POL', false],
            ]);

        $lista = $model->documentosPorTipo('POL');

        $this->assertCount(1, $lista);
        $this->assertSame('POL-A', $lista[0]->nombre);
        $this->assertSame(10, $lista[0]->id);
    }

    /**
     * @param list<object> $rows
     */
    private function createQueryResult(array $rows): object
    {
        return new class ($rows) {
            /** @param list<object> $rows */
            public function __construct(private array $rows)
            {
            }

            /** @return list<object> */
            public function getResult(): array
            {
                return $this->rows;
            }
        };
    }
}
