<?php

namespace Database\Seeders;

use App\Models\Exame;
use Illuminate\Database\Seeder;

class ExameSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['CRTORAX01', 'Raio-X de Tórax', 'CR'],
            ['CRCOLUNA01', 'Raio-X de Coluna', 'CR'],

            ['CTCRANIO01', 'Tomografia de Crânio', 'CT'],
            ['CTABDOME01', 'Tomografia de Abdome', 'CT'],

            ['MRCRANIO01', 'Ressonância de Crânio', 'MR'],
            ['MRCOLUNA01', 'Ressonância de Coluna Lombar', 'MR'],

            ['USABDOME01', 'Ultrassom de Abdome Total', 'US'],
            ['USPELVICO01', 'Ultrassom Pélvico', 'US'],

            ['MGMAMAS01', 'Mamografia Bilateral', 'MG'],
            ['MGMAMAS02', 'Mamografia Digital', 'MG'],
        ];

        foreach ($items as [$codigo, $descricao, $modalidade]) {
            Exame::updateOrCreate(['codigo' => $codigo], compact('codigo', 'descricao', 'modalidade'));
        }
    }
}
