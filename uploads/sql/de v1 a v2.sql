
USE `srp`;

/* Alter table in target */
ALTER TABLE `afiliados` 
	ADD COLUMN `id_archivo` int(11)   NOT NULL after `fecha_alta`, 
	CHANGE `date_add` `date_add` datetime   NOT NULL after `id_archivo`, 
	CHANGE `date_upd` `date_upd` datetime   NOT NULL after `date_add`, 
	CHANGE `eliminado` `eliminado` tinyint(4)   NOT NULL after `date_upd`, 
	CHANGE `user_add` `user_add` int(11)   NOT NULL after `eliminado`, 
	CHANGE `user_upd` `user_upd` int(11)   NOT NULL after `user_add`;

/* Create table in target */
CREATE TABLE `archivos`(
	`id_archivo` int(11) NOT NULL  auto_increment , 
	`nombre` varchar(64) COLLATE latin1_swedish_ci NOT NULL  , 
	`extension` varchar(8) COLLATE latin1_swedish_ci NOT NULL  , 
	`path` varchar(128) COLLATE latin1_swedish_ci NOT NULL  , 
	`size` float NOT NULL  , 
	`tipo` varchar(32) COLLATE latin1_swedish_ci NOT NULL  , 
	`full_path` varchar(128) COLLATE latin1_swedish_ci NOT NULL  , 
	`id_usuario` int(11) NOT NULL  , 
	`id_ente` int(11) NOT NULL  , 
	`id_origen` int(11) NOT NULL  , 
	`date_add` datetime NOT NULL  , 
	`date_upd` datetime NOT NULL  , 
	`user_add` int(11) NOT NULL  , 
	`user_upd` int(11) NOT NULL  , 
	`eliminado` tinyint(4) NOT NULL  , 
	PRIMARY KEY (`id_archivo`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1';


/* Create table in target */
CREATE TABLE `archivos_origen`(
	`id_origen` int(11) NOT NULL  auto_increment , 
	`origen` varchar(32) COLLATE latin1_swedish_ci NOT NULL  , 
	`eliminado` int(11) NOT NULL  , 
	PRIMARY KEY (`id_origen`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1';


/* Alter table in target */
ALTER TABLE `config` 
	ADD COLUMN `alerta_pago_no_ingresado_tarjetas` tinyint(4)   NOT NULL after `alerta_pago_no_ingresado`, 
	ADD COLUMN `alerta_codigo_no_existe_tarjetas` tinyint(4)   NOT NULL after `alerta_pago_no_ingresado_tarjetas`, 
	CHANGE `alerta_codigo_no_existe` `alerta_codigo_no_existe` tinyint(4)   NOT NULL after `alerta_codigo_no_existe_tarjetas`, 
	CHANGE `alerta_afiliado_incompleto` `alerta_afiliado_incompleto` tinyint(4)   NOT NULL after `alerta_codigo_no_existe`, 
	CHANGE `alerta_afiliado_existente` `alerta_afiliado_existente` tinyint(4)   NOT NULL after `alerta_afiliado_incompleto`, 
	CHANGE `alerta_login_no_entes` `alerta_login_no_entes` tinyint(4)   NOT NULL after `alerta_afiliado_existente`, 
	CHANGE `alerta_login_user_dlt` `alerta_login_user_dlt` tinyint(4)   NOT NULL after `alerta_login_no_entes`, 
	CHANGE `delete_afiliado_boleta` `delete_afiliado_boleta` tinyint(4)   NOT NULL after `alerta_login_user_dlt`, 
	CHANGE `delete_ente_boleta` `delete_ente_boleta` tinyint(4)   NOT NULL after `delete_afiliado_boleta`, 
	CHANGE `boletas_cantidad` `boletas_cantidad` int(11)   NOT NULL after `delete_ente_boleta`, 
	CHANGE `boletas_dias` `boletas_dias` int(11)   NOT NULL after `boletas_cantidad`, 
	ADD COLUMN `boletas_pagos` int(11)   NOT NULL after `boletas_dias`, 
	ADD COLUMN `tarjetas_dias` int(11)   NOT NULL after `boletas_pagos`, 
	CHANGE `input_max` `input_max` int(11)   NOT NULL after `tarjetas_dias`, 
	CHANGE `importe_max` `importe_max` int(11)   NOT NULL after `input_max`, 
	CHANGE `usar_min_fecha` `usar_min_fecha` tinyint(4)   NOT NULL after `importe_max`, 
	CHANGE `min_fecha` `min_fecha` int(11)   NOT NULL after `usar_min_fecha`, 
	CHANGE `maximo_afiliados_importacion` `maximo_afiliados_importacion` int(11)   NOT NULL after `min_fecha`, 
	CHANGE `maximo_afiliados_alertas` `maximo_afiliados_alertas` int(11)   NOT NULL after `maximo_afiliados_importacion`, 
	CHANGE `maximo_afiliados_boletas` `maximo_afiliados_boletas` int(11)   NOT NULL after `maximo_afiliados_alertas`, 
	CHANGE `date_upd` `date_upd` datetime   NOT NULL after `maximo_afiliados_boletas`, 
	CHANGE `user_upd` `user_upd` int(11)   NOT NULL after `date_upd`, 
	CHANGE `eliminado` `eliminado` tinyint(4)   NOT NULL after `user_upd`;

/* Create table in target */
CREATE TABLE `config_archivos`(
	`id_config` int(11) NOT NULL  auto_increment , 
	`dias_warning` int(11) NOT NULL  , 
	`dias_danger` int(11) NOT NULL  , 
	`mensaje_warning` int(11) NOT NULL  , 
	`mensaje_danger` int(11) NOT NULL  , 
	`pagos_size` int(11) NOT NULL  , 
	`pagos_type` varchar(32) COLLATE latin1_swedish_ci NOT NULL  , 
	`afiliados_size` int(11) NOT NULL  , 
	`afiliados_type` varchar(32) COLLATE latin1_swedish_ci NOT NULL  , 
	PRIMARY KEY (`id_config`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1';


/* Alter table in target */
ALTER TABLE `entes` 
	ADD COLUMN `boletas` tinyint(4)   NOT NULL after `id_impresion`, 
	ADD COLUMN `tarjetas` tinyint(4)   NOT NULL after `boletas`, 
	CHANGE `date_add` `date_add` datetime   NOT NULL after `tarjetas`, 
	CHANGE `date_upd` `date_upd` datetime   NOT NULL after `date_add`, 
	CHANGE `user_add` `user_add` int(11)   NOT NULL after `date_upd`, 
	CHANGE `user_upd` `user_upd` int(11)   NOT NULL after `user_add`, 
	CHANGE `eliminado` `eliminado` tinyint(4)   NOT NULL after `user_upd`;

/* Create table in target */
CREATE TABLE `pagos_boletas`(
	`id_pago` bigint(20) NOT NULL  auto_increment , 
	`id_boleta` int(11) NOT NULL  , 
	`agencia` int(11) NOT NULL  , 
	`terminal` int(11) NOT NULL  , 
	`nro_transaccion` int(11) NOT NULL  , 
	`fechapago` date NOT NULL  , 
	`importe` double NOT NULL  , 
	`codigo_pago` varchar(128) COLLATE latin1_swedish_ci NOT NULL  , 
	`id_archivo` int(11) NOT NULL  , 
	`date_add` datetime NOT NULL  , 
	`user_add` int(11) NOT NULL  , 
	`eliminado` tinyint(4) NOT NULL  , 
	PRIMARY KEY (`id_pago`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1';


/* Create table in target */
CREATE TABLE `pagos_tarjetas`(
	`id_pago` int(11) NOT NULL  auto_increment , 
	`id_tarjeta` int(11) NOT NULL  , 
	`agencia` int(11) NOT NULL  , 
	`terminal` int(11) NOT NULL  , 
	`nro_transaccion` int(11) NOT NULL  , 
	`fecha_pago` date NOT NULL  , 
	`importe` float NOT NULL  , 
	`id_archivo` int(11) NOT NULL  , 
	`date_add` datetime NOT NULL  , 
	`user_add` int(11) NOT NULL  , 
	`eliminado` int(11) NOT NULL  , 
	PRIMARY KEY (`id_pago`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1';


/* Create table in target */
CREATE TABLE `tarjetas`(
	`id_tarjeta` int(11) NOT NULL  auto_increment , 
	`id_afiliado` int(11) NOT NULL  , 
	`cod_afiliado` int(11) NOT NULL  , 
	`id_ente` int(11) NOT NULL  , 
	`cod_ente` int(11) NOT NULL  , 
	`codigo_barra` varchar(32) COLLATE latin1_swedish_ci NOT NULL  , 
	`date_add` datetime NOT NULL  , 
	`date_upd` datetime NOT NULL  , 
	`user_add` int(11) NOT NULL  , 
	`user_upd` int(11) NOT NULL  , 
	`eliminado` tinyint(4) NOT NULL  , 
	PRIMARY KEY (`id_tarjeta`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1';
