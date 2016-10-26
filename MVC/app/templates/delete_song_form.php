<h2>Delete Music<h2>
<h3>You may delete a song here<h3>
<form action = "index.php" method = "post">
<fieldset>
	<input id='action' type='hidden' name='action' value='delteMusic' />
	<p>
		<label for="fArtist">Artist</label> <input type="text"
			id="fArtist" name="fArtist" placeholder="artist"
			maxlength="25" required />
	</p>
	<p>
		<label for="fSong">Song</label> <input type="text"
			id="fSong" name="fSong" placeholder="song"
			maxlength="35" required />
	</p>
	<p>
	<div class="form-group">
		<div class="controls">
			<button type="submit" class="btn btn-success">Delete Music</button>
		</div>
	</div>
	</p>
</fieldset>
</form>