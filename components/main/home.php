<main class="d-flex align-items-center justify-content-center text-white text-center vh-100">
  <div>
    <h1 class="display-4">Benvenuto su Re-View!</h1>
    <p class="lead">Il miglior sito di critica cinematografica</p>
    <form class="d-flex flex-row justify-content-center" action="public/catalog.php" method="POST">
      <input class="form-control mr-sm-2" type="search" name="searchBar" placeholder="Cerca" aria-label="Cerca">
      <div class="dropdown mx-sm-3">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-filter"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <label class="dropdown-item">
            <input type="radio" class="mr-1" id="nome" name="filter" value="Nome" checked>
            Nome
          </label>
          <label class="dropdown-item">
            <input type="radio" class="mr-1" id="genere" name="filter" value="Genere">
            Genere
          </label>
          <label class="dropdown-item">
            <input type="radio" class="mr-1" id="regista" name="filter" value="Regista">
            Regista
          </label>
          <label class="dropdown-item">
            <input type="radio" class="mr-1" id="paese" name="filter" value="Paese">
            Paese
          </label>
          <label class="dropdown-item">
            <input type="radio" class="mr-1" id="anno" name="filter" value="Anno">
            Anno
          </label>
          <label class="dropdown-item">
            <input type="radio" class="mr-1" id="casa_produzione" name="filter" value="Casa_Produzione">
            Casa di Produzione
          </label>
        </div>
      </div>
      <button class="btn btn-outline-light my-2 my-sm-0" type="submit" id="searchBtn">Cerca</button>
    </form>
  </div>
</main>