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

        <div class="tbl-header">
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Tytuł</th>
                    <th>Data</th>
                    <th>Opcje</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table>
                <tbody>

                </tbody>
            </table>
        </div>
    </section>
</div>