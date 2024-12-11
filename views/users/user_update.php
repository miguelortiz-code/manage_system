<?php global $userData, $rolesData, $statesData; ?>



<form action="/update-user" method="post">
    <!-- Campo oculto para enviar el user_id -->
    <input type="hidden" name="id_user" value="<?= $userData['id_user']?>">
    <input type="text" name="full_name" id="full_name" placeholder="Nombres" value="<?= htmlspecialchars($userData['fullname_user'], ENT_QUOTES, 'UTF-8')?>">
    <input type="text" name="last_name" id="last_name" placeholder="Apellidos" value="<?= htmlspecialchars($userData['lastname_user'], ENT_QUOTES, 'UTF-8')?>">
    <input type="tel" name="phone" id="phone" placeholder="Teléfono" value="<?= htmlspecialchars($userData['phone_user'], ENT_QUOTES, 'UTF-8')?>">
    <input type="text" name="address" id="address" placeholder="Dirección" value="<?= htmlspecialchars($userData['address_user'], ENT_QUOTES, 'UTF-8')?>">
    <input type="email" name="email" id="email" placeholder="Correo Electrónico" value="<?= htmlspecialchars($userData['email_user'], ENT_QUOTES, 'UTF-8')?>">
    <input type="password" name="password" id="password" placeholder="Contraseña">
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar Contraseña">

    <!-- Administrador General -->
    <label for="super_root">Administrador general</label>
    <select name="super__root" id="super_root">
        <option value="0" <?= $userData['super_root'] == 0 ? 'selected' : ''; ?>>No</option>
        <option value="1" <?= $userData['super_root'] == 1 ? 'selected' : ''; ?>>Sí</option>
    </select>

    <!-- Administrador Padre -->
    <label for="admin_parent">Administrador padre</label>
    <select name="admin_parent" id="admin_parent">
        <option value="0" <?= $userData['admin_parent'] == 0 ? 'selected' : ''; ?>>No</option>
        <option value="1" <?= $userData['admin_parent'] == 1 ? 'selected' : ''; ?>>Sí</option>
    </select>

    <!-- Tipo de Usuario -->
    <label for="rol">Tipo de usuario</label>
    <select name="rol" id="rol">
        <?php 
        if (!empty($rolesData)): 
            foreach ($rolesData as $rol): ?>
                <option value="<?= $rol['id_rol']; ?>" 
                        <?= $userData['id_rol'] == $rol['id_rol'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($rol['rol'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
        <?php endforeach; 
        else: ?>
            <option value="">No hay roles disponibles</option>
        <?php endif; ?>
    </select>

     <!-- Tipo de estado -->
     <label for="state">Estado</label>
    <select name="state" id="state">
        <?php 
        if (!empty($statesData)): 
            foreach ($statesData as $state): ?>
                <option value="<?= $state['id_state']; ?>" 
                        <?= $userData['id_state'] == $state['id_state'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($state['state'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
        <?php endforeach; 
        else: ?>
            <option value="">No hay estados disponibles</option>
        <?php endif; ?>
    </select>

    <input type="submit" name="submit" value="Actualizar Usuario">
</form>