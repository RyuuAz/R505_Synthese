<?php echo view('common/head', [
        'titre' => 'Inscription'
    ]); ?>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Inscription</h3>
                    <form method="post" action="/register">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                        <?php endif; ?>
                        <!-- Champ E mail -->
                        <div class="mb-3 d-flex justify-content-center">
                            <input type="email" class="form-control w-75" id="email" name="email" placeholder="E-mail" required />
                        </div>
                        <!-- Champ Mot de passe -->
                        <div class="mb-3 d-flex justify-content-center">
                            <input type="password" class="form-control w-75" id="password" name="password" placeholder="Mot de passe" required />
                        </div>
                        <!-- Champ de confirmation de mot de passe -->
                        <div class="mb-3 d-flex justify-content-center"">
                            <input type="password" class="form-control w-75" id="password_confirm" name="password_confirm" placeholder="Confirmez le mot de passe" required />
                        </div>
                        <!-- Bouton Inscription -->
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary w-50">Inscription</button>
                        </div>
                    </form>
                    <!-- Lien Connexion à un compte utilisateur -->
                    <div class="text-center mt-3">
                        <a href="/" class="text-decoration-none">Vous avez déjà un compte ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view('common/foot'); ?>