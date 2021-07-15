<?php
error_reporting(0);

if(isset($_GET["fechaInicial"])){

  $fechaInicial = $_GET["fechaInicial"];
  $fechaFinal = $_GET["fechaFinal"];

}else{

  $fechaInicial = null;
  $fechaFinal = null;

}

$respuesta = ControladorCompras::ctrRangoFechasCompras($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayVentas = array();
$sumaPagosMes = array();

foreach ($respuesta as $key => $value) {
  #Capturamos  el Año y el mes (7) dia(10) hora(15)
  $fecha = substr($value["fecha"],0,10);
  #Introducir las fechas en arrayFechas
  array_push($arrayFechas, $fecha);
  #Capturamos las ventas
  $arrayVentas = array($fecha => $value["total"]);
  #Sumamos los pagos que ocurrieron el mismo mes
  foreach ($arrayVentas as $key => $value) {
    $sumaPagosMes[$key] += $value;
  }
}

$noRepetirFechas = array_unique($arrayFechas);
?> 
<!--=====================================
GRAFICO DE COMPRAS
======================================-->
<div class="box box-solid bg-teal-gradient">  
  <div class="box-header">    
    <i class="fa fa-usd"></i>
    <h3 class="box-title"><strong>Gráfico de Compras</strong></h3>
            <div class="box-tools pull-right">
            <button type="button" class="btn bg-teal btn-sm" data-widget="collapse">
               <i class="fa fa-minus"></i>
             </button>
        </div>
  </div>
  <div class="box-body border-radius-none nuevoGraficoCompras">
    <div class="chart" id="line-chart-compras" style="height: 250px;"></div>
  </div>
</div>

<script>
 var line = new Morris.Line({
    element          : 'line-chart-compras',
    resize           : true,
    data             : [

                          <?php
                            if($noRepetirFechas != null){
                              foreach($noRepetirFechas as $key){
                                echo "{ y: '".$key."', compras: ".$sumaPagosMes[$key]." },";
                              }
                              echo "{y: '".$key."', compras: ".$sumaPagosMes[$key]." }";
                            }else{
                                echo "{ y: '0', compras: '0' }";
                            }
                          ?>
                        ],

    xkey             : 'y',
    ykeys            : ['compras'],
    labels           : ['compras'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : 'S/',
    gridTextSize     : 10
  });

</script>