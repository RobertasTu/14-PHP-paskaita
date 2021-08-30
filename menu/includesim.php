<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Įmonių valdymo sistema</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="imones.php">Įmonės <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="imonespildymoforma.php">Nauja įmonė</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Klientai
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="klientupildymoforma.php">Naujas klientas</a>
          <a class="dropdown-item" href="klientai.php">Klientų sarašas</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="vartotojai.php" method="get">
      <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search User" aria-label="Search User">
      <button class="btn btn-primary my-2 my-sm-0" type="submit" name="search_button">Search</button>
    </form>
  </div>
</nav>