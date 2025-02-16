<form>
    <button type="submit" name="orden" value="Nuevo"> Cliente Nuevo </button>
    <button type="submit" name="orden" value="Cerrar">Cerrar sesión</button><br>
</form>
<br>
<table>
    <thead>
        <tr>
            <th><a href="?ordenacion=id">ID</a></th>
            <th><a href="?ordenacion=first_name">First Name</a></th>
            <th><a href="?ordenacion=email">Email</a></th>
            <th><a href="?ordenacion=gender">Gender</a></th>
            <th><a href="?ordenacion=ip_address">IP address</a></th>
            <th><a href="?ordenacion=telefono">Teléfono</a></th>
            <th colspan="3" ></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tclientes as $cli): ?>
            <tr>
                <td><?= $cli->id ?> </td>
                <td><?= $cli->first_name ?> </td>
                <td><?= $cli->email ?> </td>
                <td><?= $cli->gender ?> </td>
                <td><?= $cli->ip_address ?> </td>
                <td><?= $cli->telefono ?> </td>
                
                <?php if($_SESSION['rol'] == 1): ?>
                    <td><a href="#" onclick="confirmarBorrar('<?= $cli->first_name ?>','<?= $cli->id ?>');">Borrar</a></td>
                    <td><a href="?orden=Modificar&id=<?= $cli->id ?>">Modificar</a></td>
                <?php endif; ?>

                <td><a href="?orden=Detalles&id=<?= $cli->id ?>">Detalles</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<form>
    <button name="nav" value="Primero"> << </button>
    <button name="nav" value="Anterior"> < </button>
    <button name="nav" value="Siguiente"> > </button>
    <button name="nav" value="Ultimo"> >> </button>
</form>