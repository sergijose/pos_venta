<?php

$item = null;
$valor = null;
$orden = "compras";

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

$colores = array("#f56954","#00a65a","#f39c12","lightSkyBlue","steelBlue","lightSteelBlue","cadetBlue","mediumPurple","orangeRed","pink");

$totalCompras = ControladorProductos::ctrMostrarSumaCompras();
// var_dump($productos);


?>

<!--=====================================
PRODUCTOS MÁS VENDIDOS
======================================-->

<div class="box box-primary">

  <div class="box-header with-border">
    <h2 class="box-title">Productos más comprados</h2>
  </div>


  <div class="box-body">

    <div class="row">

      <div class="col-md-8">

        <div class="chart-responsive">
          <canvas id="pieChart" height="300"></canvas>
        </div>

      </div>


      <div class="col-md-4">

        <ul class="chart-legend clearfix">
        <br>
        <br>
        <?php

        for($i = 0; $i < 10; $i++){

        echo '<li style="font-size:16px"><i class="fa fa-circle-o" style="color:'.$colores[$i].'; font-size:18px"></i>  '.$productos[$i]["descripcion"].'</li>';

        }


        ?>

        </ul>

      </div>

    </div>

  </div>


  <div class="box-footer no-padding">
    <ul class="nav nav-pills nav-stacked">


    <?php

        for($i = 0; $i <10; $i++){
  
        echo '<li>
        
        <a>

        <img src="'.$productos[$i]["imagen"].'" class="img-thumbnail" width="60px" style="margin-right:10px"> 
        '.$productos[$i]["descripcion"].'

        <span class="pull-right " style="color:'.$colores[$i].'">   
        '.ceil($productos[$i]["compras"]*100/$totalCompras["total"]).'%
        </span>
        
        </a>

        </li>';

			}

    ?>
      
    </ul>
  </div>


</div>

<script>
  // -------------
  // - PIE CHART -
  // -------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [


    <?php

      for($i = 0; $i < 5; $i++){

        echo "{
          value    : ".$productos[$i]["compras"].",
          color    : '".$colores[$i]."',
          highlight: '".$colores[$i]."',
          label    : '".$productos[$i]["descripcion"]."'
        },";

      }
    
  ?>
    // color    : '#f56954', coral
    // color    : '#00a65a',limeGreen / mediumSeaGreen
    // color    : '#f39c12', gold
    // color    : '#00c0ef', lightSkyBlue
    // color    : '#3c8dbc', steelBlue
    // color    : '#d2d6de', whiteSmoke
      
  ];
  var pieOptions     = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    // String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth   : 1,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps       : 100,
    // String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : false,
    // String - A legend template
    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate      : '<%=value %> <%=label%>'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  // -----------------
  // - END PIE CHART -
  // -----------------
</script>