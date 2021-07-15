<div id="back"></div>

<div class="login-box">
<!-- INICIO DE SISTEMA DE LOGIN -->
  <!--  <div class="login-logo">
    <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive" style="padding:30px 100px 0px 100px">
  </div>   -->
 <!-- FIN DE SISTEMA DE LOGIN -->
  
  <div class="login-box-body">
    <!-- TITULO DEL SISTEMAN DE SISTEMA DE LOGIN -->
     <tr align="center">
        <center><td class="container"><b>SISTEMA DE GESTION COMERCIAL</b></td></center>
      </tr>
  <!-- FIN DE TITULO DEL SISTEMA -->
    <div class="login-logo">
      <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive" style="padding:30px 100px 0px 100px">
    </div> 
    <p class="login-box-msg"><b>Ingresar al Sistema</b></p>
    <form method="post">

      <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" autocomplete="off" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>

      </div>

      <div class="form-group has-feedback">

        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" autocomplete="off" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      
      </div>

      <div class="row">
       
        <div align="center">
          <button type="submit"  class="btn btn-primary ">Ingresar</button>
        </div>

      </div>

      <?php

        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();
        
      ?>
     <tr align="center"></br>
        <center><td class="container"><b>&copy; 2021 - 2026 PiuraSoft Solutions-Soluciones Tecnologicas y Servicios Generales EIRL</b></a></td></center>
      </tr>
    </form>

  </div>

</div>
