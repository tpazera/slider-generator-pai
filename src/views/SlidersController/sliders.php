<?php include(dirname(__DIR__) . '/header.php') ?>

    <h2>Manage your sliders from this panel!</h2>

<?php if(isset($message)): ?>
    <?php foreach($message as $item): ?>
        <h3 class="error"><?= $item ?></h3>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(isset($sliders)): ?>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Name</th>
            <th scope="col">Generate code</th>
            <th scope="col">Edit slider</th>
            <th scope="col">Remove slider</th>
        </tr>
        </thead>
        <tbody class="table-striped">
        <?php foreach($sliders as $slider): ?>
        <tr>
            <th scope="row"><?= $slider->getId() ?></th>
            <td><?= $slider->getName() ?></td>
            <td>
                <form action="?page=codeslider&slider=<?= $slider->getId() ?>" method="POST">
                    <input type="submit" class="code" value="Generate code"/>
                </form>
            </td>
            <td>
                <form action="?page=editslider&slider=<?= $slider->getId() ?>" method="POST">
                    <input type="submit" class="edit" value="Edit"/>
                </form>
            </td>
            <td>
                <form action="?page=removeslider&slider=<?= $slider->getId() ?>" method="POST">
                    <input type="submit" class="remove" value="Remove"/>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

    <h2>Add new slider:</h2>

    <form class="addslider" action="?page=addslider" method="POST">
        <input name="name" placeholder="Slider's name" type="text"/>
        <input type="submit" value="+"/>
    </form>

<?php include(dirname(__DIR__) . '/footer.php') ?>