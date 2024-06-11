<h2>Recensisci il Film</h2>
<form action="private/send_review.php" method="post">
    <div class="form-group">
        <label for="Regia">Regia</label><input type="number" class="form-control" id="Regia" name="Regia" min="0" max="5" required>
    </div>
    <div class="form-group">
        <label for="Sceneggiatura">Sceneggiatura</label><input type="number" class="form-control" id="Sceneggiatura" name="Sceneggiatura" min="0" max="5" required>
    </div>
    <div class="form-group">
        <label for="Colonna_Sonora">Colonna Sonora</label><input type="number" class="form-control" id="Colonna_Sonora" name="Colonna_Sonora" min="0" max="5" required>
    </div>
    <div class="form-group">
        <label for="Recitazione">Recitazione</label><input type="number" class="form-control" id="Recitazione" name="Recitazione" min="0" max="5" required>
    </div>
    <div class="form-group">
        <label for= "Fotografia">Fotografia</label><input type="number" class="form-control" id="Fotografia" name="Fotografia" min="0" max="5" required>
    </div>
    <button type="submit" class="btn btn-primary">Invia</button>
</form>
