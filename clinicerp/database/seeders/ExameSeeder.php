<?php
namespace Database\Seeders;
use App\Models\Exame;
use Illuminate\Database\Seeder;
class ExameSeeder extends Seeder {
  public function run(): void {
    $items = [
      ['RXTORAX','Raio-X de Tórax','CR'],['RXCOLUNA','Raio-X de Coluna','CR'],['RXJOELHO','Raio-X de Joelho','CR'],['RXMAO','Raio-X de Mão','CR'],['RXPE','Raio-X de Pé','CR'],
      ['USABD','Ultrassom Abdome Total','US'],['USPELV','Ultrassom Pélvico','US'],['USTIREO','Ultrassom Tireoide','US'],['USMAMAS','Ultrassom Mamas','US'],['USECO','Ecocardiograma','US'],
      ['TC_CRANIO','Tomografia de Crânio','CT'],['TC_TORAX','Tomografia de Tórax','CT'],['TC_ABD','Tomografia de Abdome','CT'],['TC_SEIOS','Tomografia Seios da Face','CT'],['TC_COLUNA','Tomografia de Coluna','CT'],
      ['RM_CRANIO','Ressonância de Crânio','MR'],['RM_JOELHO','Ressonância de Joelho','MR'],['RM_COLUNA','Ressonância de Coluna','MR'],['MAMOGRAFIA','Mamografia Bilateral','MG'],['DENSITOM','Densitometria Óssea','DX']
    ];
    foreach($items as [$codigo,$descricao,$modalidade]) Exame::updateOrCreate(['codigo'=>$codigo],compact('codigo','descricao','modalidade'));
  }
}
