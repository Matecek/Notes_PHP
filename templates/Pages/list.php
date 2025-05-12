<div>
        <?php
            if(!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo '<div class="message">Notatka została utworzona</div>';
                        break;
                }
            }
        ?>
	<h3>Lista notatek</h3>
	<b><?php echo $params['resultList'] ?? ""; ?></b>
</div>
