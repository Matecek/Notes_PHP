<div>
    <h3>Nowa notatka</h3>
    <div>
        <?php if (!empty($params['error'])): ?>
            <div class="error-message" style="color: red; margin-bottom: 10px;">
                <?= htmlspecialchars($params['error']) ?>
            </div>
        <?php endif; ?>
        <form class="note-form" action="/?_action=create" method="POST">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <label>
                        <input type="text" name="title" class="field-long"
                               value="<?= htmlspecialchars($params['title'] ?? '') ?>" />
                    </label>
                </li>
                <li>
                    <label>Treść</label>
                    <label for="field5"></label><textarea name="description" id="field5" class="field-long field-textarea"></textarea>
                </li>
                <li>
                    <input type="submit" value="Submit">
                </li>
            </ul>
        </form>
    </div>
</div>
