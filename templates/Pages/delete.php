<div class="show">

        <div>
            <p><b>Czy na pewno chcesz usunąć notatkę?</b></p>
        </div>
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note) : ?>
    <form method="POST" action="/?action=delete">
        <input type="hidden" name="id" value="<?= $note['id']; ?>"/>
        <input type="submit" value="Tak" />
    </form>
    <?php else : ?>
        <p>Nie znaleziono notatki</p>
    <?php endif; ?>
    <a href="/"><button>Anuluj</button></a>
</div>