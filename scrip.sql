-- MySQL database export
START TRANSACTION;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id_usuario` INT NOT NULL,
    `nombre_usuario` VARCHAR(255),
    `user_usuario` VARCHAR(255) UNIQUE,
    `telefono_usuario` VARCHAR(255) UNIQUE,
    `direccion_usuario` VARCHAR(255),
    `id_rol` INT,
    `password_usuario` VARCHAR(255),
    `estado` tinyint,
    PRIMARY KEY (`id_usuario`)
);



CREATE TABLE IF NOT EXISTS `rol_usuario` (
    `id_rol` INT NOT NULL,
    `nombre_rol` VARCHAR(255),
    `estado` tinyint,
    PRIMARY KEY (`id_rol`)
);



CREATE TABLE IF NOT EXISTS `Productos` (
    `id_producto` INT NOT NULL,
    `nombre_produto` VARCHAR(150),
    `descripcion_producto` VARCHAR(256),
    `stock_producto` INT,
    `estado` tinyint,
    PRIMARY KEY (`id_producto`)
);



CREATE TABLE IF NOT EXISTS `presentacion_producto` (
    `id_presentacion` INT NOT NULL,
    `id_producto` INT,
    `tamano_presentacion` VARCHAR(256),
    `precio_compra_presentacion` DECIMAL(10, 2),
    `precio_venta_cliente_presentacion` DECIMAL(10, 2),
    `precio_venta_jm_presentacion` DECIMAL(10, 2),
    `stock_disponible_presentacion` INT,
    `estado` tinyint,
    PRIMARY KEY (`id_presentacion`)
);



CREATE TABLE IF NOT EXISTS `pedidos` (
    `id_pedidos` INT NOT NULL,
    `id_usuario` INT,
    `id_cliente` INT,
    `id_estado` INT,
    `fecha_pedido` DATETIME,
    `fecha_entrega_pedido` DATE,
    `costo_total_pedido` DECIMAL(10, 2),
    `valor_total_pedido` DECIMAL(10, 2),
    `ganancia_total_pedido` DECIMAL(10, 2),
    `estado` tinyint,
    PRIMARY KEY (`id_pedidos`)
);



CREATE TABLE IF NOT EXISTS `estados_pedido` (
    `id_estado_pedido` INT NOT NULL,
    `nombre_estado` VARCHAR(150),
    PRIMARY KEY (`id_estado_pedido`)
);



CREATE TABLE IF NOT EXISTS `detalle_pedido` (
    `id_detalle_pedido` INT NOT NULL,
    `id_pedido` INT,
    `id_presentacion` INT,
    `cantidad_detalle_pedido` INT,
    `precio_unidaterio_detalle_pedido` DECIMAL(10, 2),
    `subtotal_unidatario_detalle_pedido` DECIMAL(10, 2),
    `estado` tinyint,
    PRIMARY KEY (`id_detalle_pedido`)
);


-- Foreign key constraints
ALTER TABLE `rol_usuario` ADD CONSTRAINT `fk_rol_usuario_id_rol` FOREIGN KEY(`id_rol`) REFERENCES `usuarios`(`id_rol`);
ALTER TABLE `Productos` ADD CONSTRAINT `fk_Productos_id_producto` FOREIGN KEY(`id_producto`) REFERENCES `presentacion_producto`(`id_producto`);
ALTER TABLE `usuarios` ADD CONSTRAINT `fk_usuarios_id_usuario` FOREIGN KEY(`id_usuario`) REFERENCES `pedidos`(`id_usuario`);
ALTER TABLE `usuarios` ADD CONSTRAINT `fk_usuarios_id_usuario` FOREIGN KEY(`id_usuario`) REFERENCES `pedidos`(`id_cliente`);
ALTER TABLE `estados_pedido` ADD CONSTRAINT `fk_estados_pedido_id_estado_pedido` FOREIGN KEY(`id_estado_pedido`) REFERENCES `pedidos`(`id_estado`);
ALTER TABLE `pedidos` ADD CONSTRAINT `fk_pedidos_id_pedidos` FOREIGN KEY(`id_pedidos`) REFERENCES `detalle_pedido`(`id_pedido`);
ALTER TABLE `presentacion_producto` ADD CONSTRAINT `fk_presentacion_producto_id_presentacion` FOREIGN KEY(`id_presentacion`) REFERENCES `detalle_pedido`(`id_presentacion`);

COMMIT;

