<div>
	<h3>Nowa notatka</h3>
	<div>
		<?php if ($params['created']): ?>
		<div>
			<div>Tytuł: <?php echo $params['title']?></div>
			<div>Treść: <?php echo $params['description']?></div>
		</div>
		<?php else: ?>
		<form class="note-form" action="/?_action=create" method="POST">
			<ul>
				<li>
					<label>Tytuł <span class="required">*</span></label>
					<label>
						<input type="text" name="title" class="field-long" />
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
		<?php endif; ?>
	</div>
</div>
