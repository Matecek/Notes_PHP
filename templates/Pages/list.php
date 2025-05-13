<div class="list">
    <section>
            <?php
            if (!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo '<div class="message">Notatka zostało utworzona</div>';
                        break;
                }
            }
            ?>

        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Tytuł</th>
                    <th>Data</th>
                    <th>Opcje</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($params['notes'] as $note) : ?>
                        <tr>
                            <td><?= $note['id']?></td>
                            <td><?= $note['title']?></td>
                            <td><?= (new DateTime($note['created']))->format('Y-m-d') ?></td>
                            <td>Options</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>