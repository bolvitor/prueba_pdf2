<?php

namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Venta;
use Exception;
class ReporteController
{
    public static function pdf(Router $router)
    {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        // Obtener los datos de ventas utilizando la funcion buscar
        $ventas = VentaController::buscarAPI($fechaInicio, $fechaFin);

        // Crear un objeto mPDF
        $mpdf = new Mpdf([
            "orientation" => "P",
            "default_font_size" => 12,
            "default_font" => "arial",
            "format" => "Letter",
            "mode" => 'utf-8'
        ]);
        $mpdf->SetMargins(30, 35, 25);

        // Cargar una vista HTML con los datos de ventas
        $html = $router->load('reporte/pdf', [
            'ventas' => $ventas
        ]);


        // Configurar encabezado y pie de página
        $htmlHeader = $router->load('reporte/header');
        $htmlFooter = $router->load('reporte/footer');
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);

        // Agregar el contenido HTML al PDF
        $mpdf->WriteHTML($html);

        // Generar el PDF y mostrarlo o descargarlo
        $mpdf->Output();
    }

    public static function generarPDF(Router $router)
    {
        $datos = json_decode(file_get_contents('php://input'));

        // Cargar una vista HTML con los datos
        $html = $router->load('reporte/pdf', [
            'ventas' => $datos // Pasa los datos directamente a la vista
        ]);

        // Crear un objeto mPDF
        $mpdf = new Mpdf();

        // Configurar encabezado y pie de página si es necesario
        $htmlHeader = $router->load('reporte/header');
        $htmlFooter = $router->load('reporte/footer');
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);

        // Agregar el contenido HTML al PDF
        $mpdf->WriteHTML($html);

        // Generar el PDF y mostrarlo o descargarlo
        $mpdf->Output();
    }
}
