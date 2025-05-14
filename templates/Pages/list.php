<div class="list">
    <section>
        <?php
        if (!empty($params['error'])) {
            switch ($params['error']) {
                case 'noteNotFound':
                    echo '<div class="error">Notatka nie została znaleziona!</div>';
                    break;
                case 'missingNoteId':
                    echo '<div class="error">Niepoprawne id notatki</div>';
                    break;
            }
        }
        ?>

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
<!--                    <th>Opcje</th>-->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($params['notes'] ?? [] as $note) : ?>
                    <tr class="clickable-row" data-href="/?action=show&id=<?= (int) $note['id'] ?>">
                        <td><?= (int) $note['id']?></td>
                        <td><?= htmlentities($note['title']) ?></td>
                        <td><?= htmlentities($note['created']) ?></td>
<!--                        <td><button>Pokaż</button></td>-->
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </section>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const rows = document.querySelectorAll("tr.clickable-row");
        rows.forEach(row => {
            row.addEventListener("click", () => {
                window.location.href = row.dataset.href;
            });
        });
    });
</script>
