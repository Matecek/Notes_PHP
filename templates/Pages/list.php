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
        if (!empty($params['after'])) {
            switch ($params['after']) {
                case 'created':
                    echo '<div class="message">Notatka zostało utworzona</div>';
                    break;
                case 'edited':
                    echo '<div class="message">Notatka została edytowana</div>';
                    break;
                case 'deleted':
                    echo '<div class="message">Notatka została usunięta</div>';
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
                <?php foreach ($params['notes'] ?? [] as $note) : ?>
                    <tr class="clickable-row" data-href="/?action=show&id=<?= $note['id'] ?>">
                        <td><?= $note['id']?></td>
                        <td><?= $note['title'] ?></td>
                        <td><?= $note['created'] ?></td>
<!--                        <td><button>Pokaż</button></td>-->
                        <td>
                            <a href="/?action=delete&id=<?= $note['id']?>">
                                <button>Usuń</button>
                            </a>
                        </td>
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
