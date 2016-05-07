INSERT INTO `archivos_origen` (`id_origen`, `origen`, `eliminado`) VALUES
(1, 'Upload', 0),
(2, 'Create', 0);

INSERT INTO `barcore` (`id_barcore`, `width`, `height`, `id_formato`, `id_tipo`, `size_x`, `size_y`, `canvas_x`, `canvas_y`, `date_upd`, `user_upd`, `eliminado`) VALUES
(1, '3.00', 90, 1, 9, 920, 100, 460, 50, '2016-03-08 14:54:56', 1, 0);

INSERT INTO `config_archivos` (`id_config`, `dias_warning`, `dias_danger`, `mensaje_warning`, `mensaje_danger`, `pagos_size`, `pagos_type`, `afiliados_size`, `afiliados_type`) VALUES
(1, 7, 14, 5000, 10000, 1000, 'txt', 1000, 'xls');

INSERT INTO `impresiones` (`id_impresion`, `impresion`, `x_hoja`, `date_upd`, `user_upd`, `eliminado`) VALUES
(1, '<table border="1" cellpadding="1" cellspacing="1" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td>Ente</td>\r\n			<td>#ente#</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Codigo ente</td>\r\n			<td>#codigo_ente#</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Codigo #leyenda#</td>\r\n			<td>#codigo_afiliado#</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Nombre #leyenda#</td>\r\n			<td>#nombre#</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Apellido #leyenda#</td>\r\n			<td>#apellido#</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Primer vencimiento</td>\r\n			<td>#fecha_venc_1#</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Primer importe</td>\r\n			<td>#importe_venc_1#</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Segundo vencimiento</td>\r\n			<td>#fecha_venc_2#</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Segundo importe</td>\r\n			<td>#importe_venc_2#</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 3, '2016-03-07 20:24:53', 1, 0);


INSERT INTO `impresiones_campos` (`id_campo`, `opcion`, `campo`, `cadena`, `formato`, `eliminado`) VALUES
(1, 'Nombre', 'nombre', '#nombre#', '', 0),
(2, 'Apellido', 'apellido', '#apellido#', '', 0),
(3, 'Fecha primer vencimiento', 'fecha_venc_1', '#fecha_venc_1#', 'date', 0),
(4, 'Fecha segundo vencimiento', 'fecha_venc_2', '#fecha_venc_2#', 'date', 0),
(5, 'Importe primer vencimiento', 'importe_venc_1', '#importe_venc_1#', 'importe', 0),
(6, 'Importe segundo vencimiento', 'importe_venc_2', '#importe_venc_2#', 'importe', 0),
(7, 'Codigo de barra', 'codigo_barra', '#codigo_barra#', '', 0),
(8, 'Ente', 'ente', '#ente#', '', 0),
(9, 'Código afiliado', 'codigo_afiliado', '#codigo_afiliado#', '', 0),
(10, 'Código ente', 'codigo_ente', '#codigo_ente#', '', 0),
(11, 'Leyenda', 'leyenda', '#leyenda#', '', 0);

INSERT INTO `config` (`id_config`, `mensaje_login`, `comparar_decimales`, `alerta_pago_iguales`, `alerta_pago_no_ingresado`, `alerta_pago_no_ingresado_tarjetas`, `alerta_codigo_no_existe_tarjetas`, `alerta_codigo_no_existe`, `alerta_afiliado_incompleto`, `alerta_afiliado_existente`, `alerta_login_no_entes`, `alerta_login_user_dlt`, `delete_afiliado_boleta`, `delete_ente_boleta`, `boletas_cantidad`, `boletas_dias`, `boletas_pagos`, `tarjetas_dias`, `input_max`, `importe_max`, `usar_min_fecha`, `min_fecha`, `maximo_afiliados_importacion`, `maximo_afiliados_alertas`, `maximo_afiliados_boletas`, `date_upd`, `user_upd`, `eliminado`) VALUES
(1, '<p>Comunicarse con los n&uacute;meros del Banco.</p>\r\n', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 40, 20, 65, 60, 64, 9, 1, 1, 5001, 400, 500, '0000-00-00 00:00:00', 0, 0);


INSERT INTO `permisos` (`id_permiso`, `id_perfil`, `seccion`, `ver`, `agregar`, `modificar`, `eliminar`, `eliminado`) VALUES
(1, 1, 'afiliados', 0, 0, 0, 0, 0),
(2, 1, 'boletas', 0, 0, 0, 0, 0),
(3, 1, 'config', 1, 0, 0, 0, 0),
(4, 1, 'entes', 1, 1, 1, 1, 0),
(5, 1, 'home', 1, 0, 0, 0, 0),
(6, 1, 'usuarios', 1, 1, 1, 1, 0),
(7, 2, 'afiliados', 1, 1, 1, 1, 0),
(8, 2, 'boletas', 1, 0, 0, 0, 0),
(9, 2, 'config', 0, 0, 0, 0, 0),
(10, 2, 'entes', 1, 0, 0, 0, 0),
(11, 2, 'home', 1, 0, 0, 0, 0),
(12, 2, 'usuarios', 0, 0, 0, 0, 0),
(13, 1, 'pagos_boletas', 0, 0, 0, 0, 0),
(14, 2, 'pagos_boletas', 1, 0, 0, 0, 0),
(15, 2, 'diccionarios', 0, 0, 0, 0, 0),
(16, 1, 'diccionarios', 1, 1, 1, 1, 0),
(17, 1, 'tarjetas', 1, 1, 1, 1, 0),
(18, 2, 'tarjetas', 1, 1, 1, 1, 0),
(19, 1, 'pagos_tarjetas', 0, 0, 0, 0, 0),
(20, 2, 'pagos_tarjetas', 1, 0, 0, 0, 0),
(21, 1, 'archivos', 1, 1, 1, 1, 0),
(22, 2, 'archivos', 0, 0, 0, 0, 0);

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `pass`, `id_perfil`, `date_add`, `date_upd`, `eliminado`, `user_add`, `user_upd`, `last_login`, `ip_login`, `navegador`, `sistema`) VALUES
(1, 'admin', 'tMjDvMc=', 1, '2016-02-04 00:00:00', '2016-02-24 20:01:27', 0, 0, 1, '2016-03-15 16:16:38', '::1', 'Chrome', 'Windows 10'),
(2, 'usuario', 'yNfLtMvNvw==', 2, '0000-00-00 00:00:00', '2016-03-11 17:19:30', 0, 0, 1, '2016-03-15 16:15:52', '::1', 'Chrome', 'Windows 10');