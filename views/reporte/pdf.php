<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table, th, td {
        border: 1px solid #ccc;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:nth-child(odd) {
        background-color: #fff;
    }
</style>

<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Producto</th>
            <th>Cliente</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ventas as $venta) : ?>
            <tr>
                <td><?= $venta->fecha ?></td>
                <td><?= $venta->cantidad ?></td>
                <td><?= $venta->producto ?></td>
                <td><?= $venta->cliente ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
