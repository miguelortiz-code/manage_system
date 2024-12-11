<?php global $rolesData; ?>

<form action="/create-user" method="post">
    <input type="text" name="full_name" id="full_name" placeholder="Nombres">
    <input type="text" name="last_name" id="last_name" placeholder="Apellidos">
    <input type="tel" name="phone" id="phone" placeholder="Teléfono">
    <input type="text" name="address" id="address" placeholder="Dirección">
    <input type="email" name="email" id="email" placeholder="Correo Electrónico">
    <input type="password" name="password" id="password" placeholder="Contraseña">
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar Contraseña">

    <label for="super__root">Administrador general</label>
    <select name="super__root" id="super_root">
        <option value="0">No</option>
        <option value="1">Sí</option>
    </select>

    <label for="admin_parent">Administrador padre</label>
    <select name="admin_parent" id="admin_parent">
        <option value="0">No</option>
        <option value="1">Sí</option>
    </select>

    <label for="rol">Tipo de usuario</label>
    <select name="rol" id="rol">
        <option value="">Selecciona el tipo de usuario</option>
        <?php if (isset($rolesData) && !empty($rolesData)): ?>
            <?php foreach ($rolesData as $rol): ?>
                <option value="<?= $rol['id_rol'] ?>"><?= htmlspecialchars($rol['rol'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">No hay roles disponibles</option>
        <?php endif; ?>
    </select>

    <input type="submit" name="submit" value="Crear Usuario">
</form>