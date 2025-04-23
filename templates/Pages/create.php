<div>
	<h3>Nowa notatka</h3>
	<div>
		<?php dump($params); ?>
		<form class="note-form" action="/?_action=create" method="POST">
			<ul>
				<li>
					<label>Tytuł <span class="required">*</span></label>
					<input type="text" name="title" class="field-long" />
				</li>
				<li>
					<label>Treść</label>
					<textarea name="description" id="field5" class="field-long field-textarea"></textarea>
				</li>
				<li>
					<input type="submit" value="Submit">
				</li>
			</ul>
		</form>
	</div>
</div>
