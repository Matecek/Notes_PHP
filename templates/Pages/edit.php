<div>
    <h3>Edycja notatki</h3>
    <div>
        <div id="client-error" style="color: red; margin-bottom: 10px; display: none;"></div>

        <?php if(empty($params['error'])) : ?>
        <?php $note = $params['note'] ?? null; ?>
        <form id="note-form" class="note-form" action="/?action=edit" method="POST">
            <input type="hidden" value="<?= $note['id'] ?>" name="id">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <label>
                        <input type="text" name="title" id="title" class="field-long"
                               value="<?= $note['title'] ?? '' ?>" />
                    </label>
                </li>
                <li>
                    <label>Treść</label>
                    <label for="field5"></label>
                    <textarea name="description" id="field5" class="field-long field-textarea"><?= $note['description'] ?? '' ?></textarea>
                </li>
                <li>
                    <input type="submit" value="Zapisz">
                </li>
            </ul>
        </form>
        <?php else: ?>
            <div>Brak danych do wyświetlenia</div>
            <a href="/"><button>Powrót do listy notatek</button></a>
        <?php endif; ?>
        <script>
            document.getElementById('note-form').addEventListener('submit', function (e) {
                const titleInput = document.getElementById('title');
                const errorDiv = document.getElementById('client-error');

                if (titleInput.value.trim() === '') {
                    e.preventDefault();
                    errorDiv.style.display = 'block';
                    errorDiv.textContent = 'Tytuł nie może być pusty.';
                } else {
                    errorDiv.style.display = 'none';
                }
            });
        </script>
    </div>
</div>
