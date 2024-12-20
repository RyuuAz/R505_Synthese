<?php echo view('common/head', [
        'titre' => 'Connexion'
    ]); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Connexion</h3>
                    <form method="post" action="/login">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                        <?php endif; ?>
                        <!-- Champ E mail -->
                        <div class="mb-3 d-flex justify-content-center">
                            <input type="email" class="form-control w-75" name="email" placeholder="E-mail" required />
                        </div>
                        <!-- Champ Mot de passe -->
                        <div class="mb-3 d-flex justify-content-center flex-column align-items-center w-100">
                            <input type="password" class="form-control w-75" name="password" placeholder="Mot de passe" required/>
                            <!-- Lien mot de passe oublié -->
                            <div class="w-75 text-start mt-1">
                                <a href="/forgot_password" class="text-decoration-none">Mot de passe oublié ?</a>
                            </div>
                        </div>
                        <!-- Bouton Connexion -->
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary w-50">Connexion</button>
                        </div>
                    </form>
                    <!-- Lien Créer un compte utilisateur -->
                    <div class="text-center mt-3">
                        <a href="/register" class="text-decoration-none">Créer un compte utilisateur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view('common/foot'); ?>
