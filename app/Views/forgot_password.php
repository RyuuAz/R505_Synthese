<?php echo view('common/head', [
        'titre' => 'Mot de Passe oublié'
    ]); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Mot de Passe oublié </h3>
                    <form method="post" action="/forgot_password">
                        <!-- Champ E mail -->
                        <div class="mb-3 d-flex justify-content-center">
                            <input type="email" class="form-control w-75" name="email" placeholder="E-mail" required />
                        </div>
                        <!-- Bouton Valider -->
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary w-50">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view('common/foot'); ?>
