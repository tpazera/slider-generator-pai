<?php include(dirname(__DIR__) . '/header.php') ?>

    <h1>Slider Generator</h1>
    <h2>Manage your sliders from this panel!</h2>
    <h3>If you want to go to the main page click <a href="/?page=index">here</a>.</h3>

<?php if(isset($message)): ?>
    <?php foreach($message as $item): ?>
        <h3 class="error"><?= $item ?></h3>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(isset($sliders)): ?>
    <table>
    <?php foreach($sliders as $slider): ?>
        <tr>
            <td><?= $slider['name'] ?></td>
            <td>
                <form action="?page=code&slider=<?= $slider['id'] ?>" method="POST">
                    <input type="submit" class="code" value="Generate code"/>
                </form>
            </td>
            <td>
                <form action="?page=edit$slider=<?= $slider['id'] ?>" method="POST">
                    <input type="submit" class="edit" value="Edit"/>
                </form>
            </td>
            <td>
                <form action="?page=remove&slider=<?= $slider['id'] ?>" method="POST">
                    <input type="submit" class="remove" value="Remove"/>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>

    <h2>Add new slider:</h2>

    <form class="addslider" action="?page=addslider" method="POST">
        <input name="name" placeholder="Slider's name" type="text"/><br>
        <input type="submit" value="+"/>
    </form>

<?php include(dirname(__DIR__) . '/footer.php') ?>