<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note) : ?>
    <ul>
        <li>Utworzono: <?= $note['created'] ?></li>
        <li>
            Tytuł: <?= $note['title'] ?>
        </li>
        <li>
           <?= $note['description'] ?>
        </li>
    </ul>
    <?php else : ?>
    <div>
        <p>Brak notatek do wyświetlenia</p>
    </div>
    <?php endif; ?>
    <a href="/"><button>Powrót do listy notatek</button></a>
</div>