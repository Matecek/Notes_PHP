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

        <?php
        $sort = $params['sort'] ?? [];
        $by = $sort['by'] ?? 'created';
        $order = $sort['order'] ?? 'desc';

        $page = $params['page'] ?? [];
        $size = $page['size'] ?? 5;
        $number = $page['number'] ?? 1;
        var_dump($size);
        ?>

        <div>
            <form class="settings-form" action="/" method="GET" id="sortForm">
                <div>
                    <div>Sortuj produkt po:</div>
                    <label>Tytule<input name="sortby" type="radio" value="title" <?= $by === 'title' ? 'checked' : ''?>/></label>
                    <label>Dacie<input name="sortby" type="radio" value="created" <?= $by === 'created' ? 'checked' : ''?>/></label>
                </div>
<!--                <div>-->
<!--                    <div>Kierunek sortowania</div>-->
<!--                    <label>Rosnąco <input name="sortorder" type="radio" value="asc" --><?php //= $order === 'asc' ? 'checked' : ''?><!-- /></label>-->
<!--                    <label>Malejąco <input name="sortorder" type="radio" value="desc" --><?php //= $order === 'desc' ? 'checked' : ''?><!-- /></label>-->
<!--                </div>-->
                <div>
                    <div>Wyświetl</div>
                    <label>1 <input name="pagesize" type="radio" value="1" <?= $size === 1 ? 'checked': ''?>/> </label>
                    <label>5 <input name="pagesize" type="radio" value="5" <?= $size === 5 ? 'checked': ''?>/> </label>
                    <label>10 <input name="pagesize" type="radio" value="10" <?= $size === 10 ? 'checked': ''?>/> </label>
                </div>
            </form>
        </div>

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

    document.querySelectorAll('#sortForm input[type="radio"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.getElementById('sortForm').submit();
        });
    });
</script>
