
<?php
session_start();

$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
?>
<header class="container-fluid bg-dark py-4">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand col-md-2" href="../index.php">
            <img src="src/img/tp.png" alt="Votre Logo" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/index.php?page=accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?page=apropos">Qui sommes nous?</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?page=membres">Les membres</a>
                    </li>
                    <li class="nav-item">
                    <?php if ($authenticated) : ?>
                        <button class="btn btn-warning ml-lg-3" disabled>Connecté</button>
                    <?php else : ?>
                        <button class="btn btn-warning ml-lg-3" data-toggle="modal" data-target="#loginModal" id="loginButton">
                            <?php echo $authenticated ? 'Connecté' : 'Connexion'; ?>
                        </button>
                    <?php endif; ?>
                </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Modal -->
    
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="loginModalLabel">Connexion</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control" name="login" id="login" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe:</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


