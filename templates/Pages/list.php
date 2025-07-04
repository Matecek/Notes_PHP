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
                    echo '<div class="message">Notatka została utworzona</div>';
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
        $by = $sort['by'] ?? 'title';
        $order = $sort['order'] ?? 'desc';

        $page = $params['page'] ?? [];
        $size = $page['size'] ?? 5;
        $currentPage = $page['number'] ?? 1;
        $pages = $page['pages'] ?? 1;

        $phrase = $params['phrase'] ?? null;
        ?>

        <div>
            <form class="settings-form" action="/" method="GET" id="sortForm">
                <div>
                    <label>Wyszukaj:<input type="text" name="phrase" value="<?= $phrase?>"/></label>
                </div>
                <div class="settings-field">
                    <div>Sortuj produkt po:</div>
                    <label>Tytule<input name="sortby" type="radio" value="title" <?= $by === 'title' ? 'checked' : ''?>/></label>
                    <label>Dacie edycji<input name="sortby" type="radio" value="edited" <?= $by === 'edited' ? 'checked' : ''?>/></label>

                    <div>Kierunek sortowania</div>
                    <label>Rosnąco <input name="sortorder" type="radio" value="asc" <?= $order === 'asc' ? 'checked' : ''?> /></label>
                    <label>Malejąco <input name="sortorder" type="radio" value="desc" <?= $order === 'desc' ? 'checked' : ''?> /></label>
                </div>
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
                    <th>Data utworzenia</th>
                    <th>Data edycji</th>
                    <th>Opcje</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($params['notes'] ?? [] as $note) : ?>
                    <tr class="clickable-row" data-href="/?action=show&id=<?= $note['id'] ?>">
                        <td><?= $note['id']?></td>
                        <td><?= $note['title'] ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($note['created'])) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($note['edited'])) ?></td>
                        <!--<td><button>Pokaż</button></td>-->
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

        <?php
            $paginationUrl = "&phrase=$phrase&pagesize=$size&sortby=$by&sortorder=$order";
        ?>
        <ul class="pagination">
            <?php if($currentPage !== 1): ?>
                <li>
                    <a href="/?page=<?= $currentPage - 1 . $paginationUrl ?>">
                        <button> < </button>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                <li>
                    <a href="/?page=<?= $i . $paginationUrl ?>">
                        <button><?php echo $i ?></button>
                    </a>
                </li>
            <?php endfor; ?>
            <?php if($currentPage < $pages): ?>
                <li>
                    <a href="/?page=<?= $currentPage + 1 . $paginationUrl ?>">
                        <button> > </button>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
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

        const sortForm = document.getElementById('sortForm');
        document.querySelectorAll('#sortForm input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', () => {
                sessionStorage.setItem('scrollY', window.scrollY);
                sortForm.submit();
            });
        });

        const phraseInput = document.querySelector('#sortForm input[name="phrase"]');
        let typingTimer;
        const doneTypingInterval = 500;

        phraseInput.addEventListener('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                sessionStorage.setItem('scrollY', window.scrollY);
                sortForm.submit();
            }, doneTypingInterval);
        });

        const scrollY = sessionStorage.getItem('scrollY');
        if (scrollY !== null) {
            window.scrollTo(0, parseInt(scrollY));
            sessionStorage.removeItem('scrollY');
        }
    });

</script>
