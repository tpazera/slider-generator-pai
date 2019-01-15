<?php include(dirname(__DIR__) . '/header.php') ?>

    <h2>Admin panel! You can manage user's role from here</h2>

<?php if(isset($message)): ?>
    <?php foreach($message as $item): ?>
        <h3 class="error"><?= $item ?></h3>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(isset($users)): ?>

    <table class="table table-striped userslist">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Surname</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <th scope="row"><?= $user['id'] ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['surname'] ?></td>
                <td><?= $user['email'] ?></td>
                <td data-user="<?= $user['id'] ?>" id="role<?= $user['id'] ?>">
                    <?php
                    if ($user['role'] == "user") {
                        ?>
                        <label class="radio-inline"><input type="radio" value=2 name="roleradio<?= $user['id'] ?>" checked> user</label>
                        <label class="radio-inline"><input type="radio" value=3 name="roleradio<?= $user['id'] ?>"> premium</label>
                        <?php
                    } else if ($user['role'] == "premium") {
                        ?>
                        <label class="radio-inline"><input type="radio" value=2 name="roleradio<?= $user['id'] ?>"> user</label>
                        <label class="radio-inline"><input type="radio" value=3 name="roleradio<?= $user['id'] ?>" checked> premium</label>
                        <?php
                    } else {
                        echo $user['role'];
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<?php include(dirname(__DIR__) . '/footer.php') ?>