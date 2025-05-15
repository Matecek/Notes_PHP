<div>
    <h3>Dodawanie notatki</h3>
    <div>
        <div id="client-error" style="color: red; margin-bottom: 10px; display: none;"></div>

        <form id="note-form" class="note-form" action="/?action=create" method="POST">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <label>
                        <input type="text" name="title" id="title" class="field-long"/>
                    </label>
                </li>
                <li>
                    <label>Treść</label>
                    <label for="field5"></label>
                    <textarea name="description" id="field5" class="field-long field-textarea"></textarea>
                </li>
                <li>
                    <input type="submit" value="Zapisz">
                </li>
            </ul>
        </form>

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
