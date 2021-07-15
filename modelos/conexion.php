<?php
class Conexion
{
  static public function conectar()
  {
    try {
      $link = new PDO(
        "mysql:host=localhost;dbname=pos_venta",
        "root",
        "");
      $link->exec("set names utf8");
      return $link;
    } catch (PDOException $e) {
      echo '<br>
				<div class="alert alert-danger">Error en Conexion a Base de Datos. Consultar con el Admin del Sistema</div>';
      die();
    }
  }
}
