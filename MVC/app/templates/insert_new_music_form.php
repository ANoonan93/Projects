<h3>Insert, Delete And Update Music<h3>
<h4>Enter Details You Wish To Enter, Delete Or Update<h4>
<form action = "index.php" method = "post">
<fieldset>

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
		<label for="fComment">Comment</label> <input type="text"
			id="fComment" name="fComment" placeholder="comment"
			maxlength="100"/>
	</p>
	<p>
		<label for="fGenre">Genre</label><input type="text"
			id="fGenre" name="fGenre" placeholder="genre"
			maxlength="25"/>
		<!--<select>
			<option value = "Rock">Rock</option>
			<option value = "Pop">Pop</option>
			<option value = "Jazz">Jazz</option>
			<option value = "Dance">Dance</option>
			<option value = "Classic">Classic</option>
			<option value = "R&B">R&B </option>
		</select> -->
	</p>
		
	<p>
	<div class="form-group">
		<div class="controls">
			<button type="submit" class="btn btn-success" id = "action" type="hidden" name="action" value="insertNewMusic">Insert Music</button>
			<p>
			<h5>To Delete A Song Enter The Artist And Song</h5>
			<button type="submit" class="btn btn-success" id = "action" type="hidden" name="action" value="deleteMusic">Delete A Song</button>
			</p>
			<p>
			<h5>To Update A Song Enter The Artist And Song and change the comment or genre<h5>
			<button type="submit" class="btn btn-success" id = "action" type="hidden" name="action" value="updateMusic">Update A Song</button>
			</p>
		</div>
	</div>
	</p>
</fieldset>
</form>