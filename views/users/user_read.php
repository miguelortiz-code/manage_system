<h1 class="title">Listado de usuarios</h1>
<a href="/users/create-user">Nuevo usuario</a>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>nombres</th>
                <th>apellidos</th>
                <th>telefono</th>
                <th>dirección</th>
                <th>correo electrónico</th>
                <th>estado</th>
                <th>acción</th>
            </tr>
        </thead>

        <tbody>
            <?php global $usersData;
            if (!empty($usersData)) { ?>
                <?php foreach ($usersData as $user) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['fullname_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user['lastname_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user['phone_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user['address_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user['email_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="status <?php echo strtolower($user['state']); ?>">
                            <?php echo htmlspecialchars($user['state'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="users/set-user-session?id=<?php echo $user['id_user'] ?>"
                                    title="Editar usuario" aria-label="Editar usuario">
                                    <span class="material-symbols-outlined icon update">person_edit</span>
                                </a>

                                <a href="/users/delete-user?id=<?php echo $user['id_user']; ?>"
                                    title="Eliminar usuario"
                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                                    <span class="material-symbols-outlined icon delete">group_remove</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="7" class="no-data">Actualmente no hay usuarios registrados.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>