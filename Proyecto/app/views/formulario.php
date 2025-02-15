<hr>
<form method="POST" style="width:100%; margin-top:1rem;" enctype="multipart/form-data">
    <div style="display:flex; flex-direction:row; justify-content:space-between; gap:2rem; ">
        <div id="kmere" style="display:flex; flex-direction:column; align-items:start; width:50%;">
            <label for="id">Id:</label>
            <input type="text" name="id" readonly value="<?= $cli->id ?>">

            <label for="first_name">Nombre:</label>
            <input type="text" id="first_name" name="first_name" value="<?= $cli->first_name; ?>">

            <label for="last_name">Apellido:</label>
            <input type="text" id="last_name" name="last_name" value="<?= $cli->last_name; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $cli->email; ?>">

            <label for="gender">Género:</label>
            <input type="text" id="gender" name="gender" value="<?= $cli->gender; ?>">

            <label for="ip_address">Dirección IP:</label>
            <input type="text" id="ip_address" name="ip_address" value="<?= $cli->ip_address; ?>">

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?= $cli->telefono; ?>">
        </div>
        <div style="width:50%; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:1rem; margin-bottom:1rem;">
            <img src='<?= $imgURL ?>' style="max-width:50%; max-height:400px;" alt="">
            <input type="hidden" name="MAX_FILE_SIZE" value="512000">
            <input name="foto" id="archivo" type="file" accept="image/png,image/jpeg,image/jpg"/>
        </div>
    </div>
        <hr>
        <br><br>
    <?php if( $cli->id != "" ): ?>
        <input type="submit" name="orden" value="Anterior">
        <input type="submit" name="orden" value="<?= $orden ?>">
        <input type="submit" name="orden" value="Volver">
        <input type="submit" name="orden" value="Siguiente">
        <input type="hidden" value="<?= $_SESSION['current_id'] = $cli->id ?>">
    <?php else:?>
        <input type="submit" name="orden" value="Volver">
        <input type="submit" name="orden" value="<?= $orden ?>">
    <?php endif;?>

    
</form>