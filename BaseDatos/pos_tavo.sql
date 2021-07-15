-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-07-2021 a las 18:33:37
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pos_tavo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `id_accion` int(11) NOT NULL,
  `nombre_accion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Listado de acciones para luego hacer un historial';

--
-- Volcado de datos para la tabla `acciones`
--

INSERT INTO `acciones` (`id_accion`, `nombre_accion`) VALUES
(1, 'Acceso al Sistema'),
(2, 'Salir del Sistema'),
(3, 'Registro de Venta'),
(4, 'Anulación de Venta'),
(5, 'Registro de Compras'),
(6, 'Edición de Compra en el Sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_usuario`
--

CREATE TABLE `acciones_usuario` (
  `id` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL COMMENT 'Se registra el usuario que realiza la accion',
  `id_accion` int(11) NOT NULL COMMENT 'La accion que realiza el usuario, ejemplo: Grabar Venta',
  `fecha_accion` date NOT NULL COMMENT 'Guardamos la fecha en la que se realizo dicha accion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Aqui se guardan todas las acciones realizadas por el usuario del sistema';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Asignamos un Nombre a la Caja',
  `id_sucursal` int(11) DEFAULT NULL COMMENT 'A que sucursal pertenece la Caja',
  `id_cajero` int(11) DEFAULT NULL COMMENT 'Aqui nombre del Usuario que paertura caja',
  `fecha_apertura` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de Apertura de la Caja',
  `monto_apertura` text COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Con cuanto inicia la Caja para Vender',
  `estado_caja` enum('cerrado','abierto') COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Abierto o Cerrado',
  `fecha_cierre` date DEFAULT NULL COMMENT 'Fecha de Cierre de Caja',
  `monto_cierre` text COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Esto se ingresa manualmente, deberia ser automatico',
  `totalvendido_dia` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Arqueo de Caja [Con cuanto empieza y con cuanto termina]';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Categoría del Producto';

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
(1, 'Producto', '2021-05-28 02:26:04'),
(2, 'Comida', '2021-05-28 02:26:10'),
(3, 'Bebidas', '2021-05-28 02:26:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `documento` char(14) COLLATE utf8_spanish_ci NOT NULL,
  `ruc` char(11) COLLATE utf8_spanish_ci NOT NULL,
  `razon_social` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruc2` char(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `compras` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Clientes del Negocio';

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `documento`, `ruc`, `razon_social`, `direccion`, `ruc2`, `telefono`, `correo`, `compras`, `fecha`) VALUES
(11, 'DNI', '46705057', 'JUAN MANUEL PATIÑO FERIA', 'PIURA', '10467050571', '968119674', 'piurasofteirl@gmail.com', 0, '2021-07-15 16:32:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Aquí se registran las compras';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE `concepto` (
  `id` int(11) NOT NULL,
  `concepto` char(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`id`, `concepto`) VALUES
(1, 'Consumo Interno'),
(2, 'Gastos Representacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL COMMENT 'Para saber a que comopra pertenece los productos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Aqui se guarda el detallado de todas las compras efectuadas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL COMMENT 'LLave primaria',
  `id_venta` int(11) NOT NULL COMMENT 'A que venta pertenece ese detalle'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='En esta tabla se graba el detalle de todas las ventas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emisor`
--

CREATE TABLE `emisor` (
  `id` int(11) NOT NULL,
  `id_tipodocumento` int(11) NOT NULL COMMENT 'Por Defecto RUC',
  `ruc` char(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de RUC',
  `razon_social` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón Social ',
  `nombre_comercial` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre Comercial',
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Dirección del Negocio',
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Teléfono del Negocio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Datos del que emite el comprobante';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `id_moneda` int(11) NOT NULL,
  `pais` varchar(50) NOT NULL COMMENT 'Nombre del Pais',
  `simbolo` text NOT NULL COMMENT 'Símbolo de la Moneda',
  `nombreMoneda` varchar(50) NOT NULL COMMENT 'Nombre de la Moneda'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Aqui se grabaran los numeros de serie y correlativo por Sucursal, y la moneda';

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`id_moneda`, `pais`, `simbolo`, `nombreMoneda`) VALUES
(1, 'Peru', 'S/', 'Sol');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_anulacion`
--

CREATE TABLE `motivo_anulacion` (
  `id` int(11) NOT NULL COMMENT 'Llave principal',
  `motivo_anulacion` text NOT NULL COMMENT 'Motivo de anulacion de la venta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Motivo por el cual se anula la venta[Nota de Crédito]';

--
-- Volcado de datos para la tabla `motivo_anulacion`
--

INSERT INTO `motivo_anulacion` (`id`, `motivo_anulacion`) VALUES
(1, 'Anulación de la operación'),
(2, 'Anulación por error en el RUC'),
(3, 'Corrección por error en la descripción'),
(4, 'Descuento global'),
(5, 'Descuento por ítem'),
(6, 'Devolución total'),
(7, 'Devolución por ítem'),
(8, 'Bonificación'),
(9, 'Disminución en el valor'),
(10, 'Otros Conceptos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `codigo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `codigo2` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio_compra` float DEFAULT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `compras` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Listado de Productos vendidos';

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `idSucursal`, `codigo`, `codigo2`, `nombre`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `ventas`, `compras`, `fecha`) VALUES
(1, 2, 1, 'LpKSKFkPEEJNO', 1, 'POLLO', '', 'vistas/img/productos/default/anonymous.png', 9973, 0, 85, 30, 0, '2021-06-03 04:32:33'),
(2, 2, 1, 'DI4e1kZCLypje', 2, 'Alitas', 'alas broaster', 'vistas/img/productos/default/anonymous.png', 9958, 0, 16, 52, 0, '2021-06-03 04:32:33'),
(3, 1, 1, 'sQKDK4sRANbXb', 3, 'CALOSTRO BOBINO COMPLETO 700 GRAMOS', 'CALOSTRO BOBINO COMPLETO 700 GRAMOS', 'vistas/img/productos/default/anonymous.png', 149, 5, 95, 1, 0, '2021-06-03 04:32:33'),
(4, 1, 1, 'n2963WbBmp3qb', 4, 'SK CACHORRO 20 KG', 'SK CACHORRO 20 KG', 'vistas/img/productos/default/anonymous.png', 14, 16, 98, 1, 0, '2021-06-03 04:32:32'),
(5, 1, 1, 'ca2OGVXo6SJnq', 5, 'SK 18% 25 KGS', 'SK 18% 25 KGS', 'vistas/img/productos/default/anonymous.png', 554, 15, 15, 1, 0, '2021-06-03 04:32:32'),
(6, 1, 1, 'rMPMwZzIXoM3K', 6, 'LECHE EN POLVO KALVO START ENERGY 25 KGS', 'LECHE EN POLVO KALVO START ENERGY 25 KGS', 'vistas/img/productos/default/anonymous.png', 98, 99, 158, 1, 0, '2021-06-03 04:32:32'),
(7, 1, 1, 'cshMghGn5D0r9', 7, 'SAL GANADERA (COLIMA) 50 KGS', 'SAL GANADERA (COLIMA) 50 KGS', 'vistas/img/productos/default/anonymous.png', 14, 19, 99, 1, 0, '2021-06-03 04:32:32'),
(8, 1, 1, 'N3bpFsJL4Yqpd', 8, 'PIEDRA DE SAL DESPARASITANTE', 'PIEDRA DE SAL DESPARASITANTE', 'vistas/img/productos/default/anonymous.png', 14, 15, 987, 1, 0, '2021-06-03 04:32:32'),
(9, 1, 1, 'DHq561YRVJdnu', 9, 'ALPISTE COSTAL 25 KGS', 'ALPISTE COSTAL 25 KGS', 'vistas/img/productos/default/anonymous.png', 139, 15, 98, 7, 0, '2021-07-15 15:37:42'),
(10, 1, 1, 'kb53PkA7ZalWw', 10, 'CHICHARO MEDIO GRANO 45 KG', 'CHICHARO MEDIO GRANO 45 KG', 'vistas/img/productos/default/anonymous.png', 149, 15, 966, 10, 0, '2021-07-15 15:37:42'),
(11, 1, 1, '3CHDTIt03m7nd', 11, 'SEMILLA DE GIRASOL BLACK OIL 5 KG', 'SEMILLA DE GIRASOL BLACK OIL 5 KG', 'vistas/img/productos/default/anonymous.png', 149, 15, 96, 11, 0, '2021-07-15 15:37:42'),
(12, 1, 1, 'gdCC0n3QS6bQs', 12, 'GARBANZO PARA SIEMBRA 25 KGS', 'GARBANZO PARA SIEMBRA 25 KGS', 'vistas/img/productos/default/anonymous.png', 133, 15, 55, 32, 0, '2021-07-15 15:41:33'),
(13, 1, 1, 'zsFUqggKPVeXG', 13, 'ALFALFA MOLIDA ENCOSTALADA 25 KGS.', 'ALFALFA MOLIDA ENCOSTALADA 25 KGS.', 'vistas/img/productos/default/anonymous.png', 123, 15, 966, 41, 0, '2021-07-15 15:41:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `ruc_proveedor` char(11) CHARACTER SET utf8 NOT NULL,
  `razon_social` text NOT NULL,
  `nombre_comercial` text DEFAULT NULL,
  `direccion_fiscal` text NOT NULL,
  `tipo_empresa` text CHARACTER SET utf8 DEFAULT NULL,
  `estado_empresa` text NOT NULL,
  `condicion_empresa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `ruc_proveedor`, `razon_social`, `nombre_comercial`, `direccion_fiscal`, `tipo_empresa`, `estado_empresa`, `condicion_empresa`) VALUES
(1, '20603425066', 'PIURASOFT SOLUTIONS', 'PIURASOFT SOLUTIONS', 'AV. VICTOR ANDRES BELAUNDE 287 MZA. G3 LOTE. 29 URB.  PIURA I ETAPA  (A 2 CDRAS DE PUESTO DE AUXILIO RAPIDO)', 'EMPRESA INDIVIDUAL DE RESP. LTDA', 'ACTIVO', 'HABIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id` int(11) NOT NULL,
  `sede` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre_del_almacen',
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'breve_descripcion_almacen',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Listado de Sucursales existentes en el sistema';

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id`, `sede`, `descripcion`, `fecha_registro`) VALUES
(1, 'Sucursal Principal', 'Almacen principal', '2021-05-28 00:47:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comprobante`
--

CREATE TABLE `tipo_comprobante` (
  `id` int(11) NOT NULL,
  `comprobante` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_comprobante`
--

INSERT INTO `tipo_comprobante` (`id`, `comprobante`) VALUES
(1, 'Factura de Venta'),
(2, 'Boleta de Venta'),
(3, 'Nota de Venta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_operacion`
--

CREATE TABLE `tipo_operacion` (
  `id` int(11) NOT NULL,
  `nombre` char(8) NOT NULL COMMENT 'Entrada[Compras] o Salida[Venta]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Entradas o salidas del sistema';

--
-- Volcado de datos para la tabla `tipo_operacion`
--

INSERT INTO `tipo_operacion` (`id`, `nombre`) VALUES
(1, 'entrada'),
(2, 'salida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencias`
--

CREATE TABLE `transferencias` (
  `id` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `destino` text NOT NULL,
  `productos` text NOT NULL,
  `nota` text NOT NULL,
  `id_concepto` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comprobante` char(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `transferencias`
--

INSERT INTO `transferencias` (`id`, `id_vendedor`, `destino`, `productos`, `nota`, `id_concepto`, `fecha`, `comprobante`) VALUES
(1, 64, 'Cocina', '[{\"id\":\"13\",\"descripcion\":\"ALFALFA MOLIDA ENCOSTALADA 25 KGS.\",\"cantidad\":\"1\",\"stock\":\"129\",\"total\":null},{\"id\":\"12\",\"descripcion\":\"GARBANZO PARA SIEMBRA 25 KGS\",\"cantidad\":\"1\",\"stock\":\"139\",\"total\":null}]', 'juan', 1, '2021-07-14 23:49:55', 'Transferencia'),
(2, 64, 'Cocina', '[{\"id\":\"13\",\"descripcion\":\"ALFALFA MOLIDA ENCOSTALADA 25 KGS.\",\"cantidad\":\"2\",\"stock\":\"128\",\"total\":null}]', 'ggg', 1, '2021-07-14 23:49:55', 'Transferencia'),
(3, 64, 'Cocina', '[{\"id\":\"9\",\"descripcion\":\"ALPISTE COSTAL 25 KGS\",\"cantidad\":\"5\",\"stock\":\"140\",\"total\":null}]', 'hola que hace', 1, '2021-07-15 02:15:54', 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Usuario existentes en el sistema';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `idSucursal`, `fecha`) VALUES
(64, 'administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', '', 1, '2021-07-15 11:21:39', 1, '2021-07-15 16:21:39'),
(67, 'cajero', 'cajero', '$2a$07$asxx54ahjppf45sd87a5auGZEtGHuyZwm.Ur.FJvWLCql3nmsMbXy', 'Vendedor', '', 1, '2021-07-15 00:16:13', 1, '2021-07-15 05:16:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` char(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de Comprobante',
  `id_cliente` int(11) NOT NULL COMMENT 'Cliente al que se le vende',
  `id_vendedor` int(11) NOT NULL COMMENT 'Vendedor',
  `productos` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'Productos vendidos',
  `impuesto` float NOT NULL COMMENT 'Subtotal',
  `neto` float NOT NULL COMMENT 'IGV',
  `total` float NOT NULL COMMENT 'Total a pagar',
  `metodo_pago` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'Metodo de Pago',
  `pagocon` float DEFAULT NULL COMMENT 'Con cuanto paga el cliente',
  `vuelto` float DEFAULT NULL COMMENT 'Devolucion al cliente',
  `codigoTransaccion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de la Venta',
  `estadoVenta` char(12) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Vendido' COMMENT 'Vendido[Color Verde] o Anulado[Rojo]',
  `id_comprobante` int(11) NOT NULL COMMENT 'Tipo de Comprobante[Factura, Boleta y Nota de Venta]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Ventas realizadas dentro del sistema';

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo`, `id_cliente`, `id_vendedor`, `productos`, `impuesto`, `neto`, `total`, `metodo_pago`, `pagocon`, `vuelto`, `codigoTransaccion`, `fecha`, `estadoVenta`, `id_comprobante`) VALUES
(1, '001', 7, 64, '[{\"id\":\"13\",\"descripcion\":\"ALFALFA MOLIDA ENCOSTALADA 25 KGS.\",\"cantidad\":\"1\",\"stock\":\"128\",\"precio\":\"966\",\"total\":966}]', 818.64, 147.36, 966, 'Efectivo', NULL, NULL, NULL, '2021-07-15 15:35:19', 'Vendido', 1),
(2, '0002', 7, 64, '[{\"id\":\"13\",\"descripcion\":\"ALFALFA MOLIDA ENCOSTALADA 25 KGS.\",\"cantidad\":\"1\",\"stock\":\"127\",\"precio\":\"966\",\"total\":966}]', 0, 0, 966, 'Tarjeta', NULL, NULL, NULL, '2021-07-15 15:36:11', 'Vendido', 3),
(3, '0003', 7, 64, '[{\"id\":\"13\",\"descripcion\":\"ALFALFA MOLIDA ENCOSTALADA 25 KGS.\",\"cantidad\":\"1\",\"stock\":\"126\",\"precio\":\"966\",\"total\":966},{\"id\":\"12\",\"descripcion\":\"GARBANZO PARA SIEMBRA 25 KGS\",\"cantidad\":\"1\",\"stock\":\"137\",\"precio\":\"55\",\"total\":55}]', 865.25, 155.75, 1021, 'Efectivo', NULL, NULL, NULL, '2021-07-15 15:36:49', 'Vendido', 1),
(4, '0004', 7, 64, '[{\"id\":\"13\",\"descripcion\":\"ALFALFA MOLIDA ENCOSTALADA 25 KGS.\",\"cantidad\":\"1\",\"stock\":\"125\",\"precio\":\"966\",\"total\":966},{\"id\":\"12\",\"descripcion\":\"GARBANZO PARA SIEMBRA 25 KGS\",\"cantidad\":\"1\",\"stock\":\"136\",\"precio\":\"55\",\"total\":55},{\"id\":\"11\",\"descripcion\":\"SEMILLA DE GIRASOL BLACK OIL 5 KG\",\"cantidad\":\"1\",\"stock\":\"150\",\"precio\":\"96\",\"total\":96}]', 0, 0, 1117, 'Tarjeta', NULL, NULL, NULL, '2021-07-15 15:37:12', 'Vendido', 2),
(5, '0005', 7, 64, '[{\"id\":\"11\",\"descripcion\":\"SEMILLA DE GIRASOL BLACK OIL 5 KG\",\"cantidad\":\"1\",\"stock\":\"149\",\"precio\":\"96\",\"total\":96},{\"id\":\"10\",\"descripcion\":\"CHICHARO MEDIO GRANO 45 KG\",\"cantidad\":\"1\",\"stock\":\"149\",\"precio\":\"966\",\"total\":966},{\"id\":\"9\",\"descripcion\":\"ALPISTE COSTAL 25 KGS\",\"cantidad\":\"1\",\"stock\":\"139\",\"precio\":\"98\",\"total\":98},{\"id\":\"12\",\"descripcion\":\"GARBANZO PARA SIEMBRA 25 KGS\",\"cantidad\":\"1\",\"stock\":\"135\",\"precio\":\"55\",\"total\":55}]', 1029.66, 185.34, 1215, 'Efectivo', NULL, NULL, NULL, '2021-07-15 15:37:43', 'Vendido', 1),
(6, '0006', 7, 64, '[{\"id\":\"13\",\"descripcion\":\"ALFALFA MOLIDA ENCOSTALADA 25 KGS.\",\"cantidad\":\"1\",\"stock\":\"124\",\"precio\":\"966\",\"total\":966},{\"id\":\"12\",\"descripcion\":\"GARBANZO PARA SIEMBRA 25 KGS\",\"cantidad\":\"1\",\"stock\":\"134\",\"precio\":\"55\",\"total\":55}]', 865.25, 155.75, 1021, 'Tarjeta', NULL, NULL, NULL, '2021-07-15 15:41:20', 'Vendido', 1),
(7, '0006', 7, 64, '[{\"id\":\"13\",\"descripcion\":\"ALFALFA MOLIDA ENCOSTALADA 25 KGS.\",\"cantidad\":\"1\",\"stock\":\"123\",\"precio\":\"966\",\"total\":966},{\"id\":\"12\",\"descripcion\":\"GARBANZO PARA SIEMBRA 25 KGS\",\"cantidad\":\"1\",\"stock\":\"133\",\"precio\":\"55\",\"total\":55}]', 865.25, 155.75, 1021, 'Tarjeta', NULL, NULL, NULL, '2021-07-15 15:41:33', 'Vendido', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`id_accion`);

--
-- Indices de la tabla `acciones_usuario`
--
ALTER TABLE `acciones_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `emisor`
--
ALTER TABLE `emisor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ruc` (`ruc`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`id_moneda`);

--
-- Indices de la tabla `motivo_anulacion`
--
ALTER TABLE `motivo_anulacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ru_proveedor` (`ruc_proveedor`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_operacion`
--
ALTER TABLE `tipo_operacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones`
--
ALTER TABLE `acciones`
  MODIFY `id_accion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `acciones_usuario`
--
ALTER TABLE `acciones_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `concepto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave primaria';

--
-- AUTO_INCREMENT de la tabla `emisor`
--
ALTER TABLE `emisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `moneda`
--
ALTER TABLE `moneda`
  MODIFY `id_moneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `motivo_anulacion`
--
ALTER TABLE `motivo_anulacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Llave principal', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_operacion`
--
ALTER TABLE `tipo_operacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
