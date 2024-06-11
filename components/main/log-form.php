<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
    <div class="form-container">
        <h1 class="text-center">Accedi</h1>
        <p class="text-center">Inserisci i tuoi dati per accedere</p>
        <form action="private/login.php" method="POST" class='row g-3 needs-validation' novalidate>
          <div class="col-md-7">
            <label for="validationCustomEmail" class="form-label">Email</label>
            <div class="input-group has-validation">
              <input type="email" name="email" class="form-control" id="validationCustomEmail" required>
              <div class="invalid-feedback">
                Per favore inserisci una mail valida.
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <label for="validationCustonPwd" class="col-form-label">Password</label>
            <div class="col-auto">
              <input type="password" name="pass" id="validationCustonPwd" class="form-control" minlength="8" required>
              <div class="invalid-feedback">
                  Per favore inserisci una password valida.
              </div>
            </div>
          </div>
          <div class="col-12">
            <button class="btn btn-primary" name="submit" type="submit">Invia</button>
          </div>
        </form>
    </div>
</div>