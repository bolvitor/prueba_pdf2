<?php

namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Venta;
use Exception;

class VentaController
{
    public static function index(Router $router)
    {
        $router->render('ventas/index', []);
    }


    public static function buscarAPI()
    {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        $fechaInicioFormateada = date('Y-m-d H:i', strtotime($fechaInicio));
        $fechaFinFormateada = date('Y-m-d H:i', strtotime($fechaFin));

        
        $sql = "
    SELECT
        v.venta_fecha AS fecha,
        dv.detalle_cantidad AS cantidad,
        p.producto_nombre AS producto,
        c.cliente_nombre AS cliente
    FROM
        ventas v
        INNER JOIN detalle_ventas dv ON v.venta_id = dv.detalle_venta
        INNER JOIN productos p ON dv.detalle_producto = p.producto_id
        INNER JOIN clientes c ON v.venta_cliente = c.cliente_id
    WHERE
        v.venta_fecha BETWEEN '{$fechaInicioFormateada}' AND '{$fechaFinFormateada}'";

        try {
     
            $ventas = Venta::fetchArray($sql);
            echo json_encode($ventas);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    
 }    