
import { Toast,} from "../funciones";

const formulario = document.getElementById('formularioVenta');
const btnBuscar = document.getElementById('btnBuscar');

const buscar = async () => {
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;

    if (!fechaInicio || !fechaFin) {
        
        Toast.fire({
            title: 'seleccione ambas fechas.',
            icon: 'error'
        });
        return;
    }

    if (fechaInicio > fechaFin) {
        Toast.fire({
            title: 'La fecha de inicio es mayor a la fecha final',
            icon: 'error'
        });
        return;
    }

    const url = `/prueba_pdf2/API/ventas/buscar?fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log(data);

        if (data.length === 0) {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        } else {
        
            generarPDF(data);
        }
    } catch (error) {
        console.log(error);
    }
};



const generarPDF = async (datos) => {
    const url = `/prueba_pdf2/reporte/generarPDF`;

    const config = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos),
    };

    try {
        const respuesta = await fetch(url, config);

        if (respuesta.ok) {
            const blob = await respuesta.blob();

            if (blob) {
                const urlBlob = window.URL.createObjectURL(blob);

                window.open(urlBlob, '_blank');
            } else {
                console.error('No se pudo obtener el PDF.');
            }
        } else {
            console.error('Error al generar el PDF.');
        }
    } catch (error) {
        console.error(error);
    }
};



btnBuscar.addEventListener('click', buscar)