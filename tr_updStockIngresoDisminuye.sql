DELIMITER //
CREATE TRIGGER tr_updStockIngresoAnular AFTER UPDATE ON ingresos
  FOR EACH ROW BEGIN
  UPDATE articulos a
    JOIN detalle_ingresos di
    ON di.idarticulo = a.id
    AND di.idingreso = NEW.id
    SET a.stock = a.stock - di.cantidad;
END
//
DELIMITER ;