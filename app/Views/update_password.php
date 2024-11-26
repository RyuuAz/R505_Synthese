
<?php echo view('common/head'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Mot de Passe oublié </h3>
                    <form method="post" action="/reset_password">
						<!-- Champ Token -->
						<div class="mb-3 d-flex justify-content-center">
							<input type="hidden" name="token" value="<?= $token ?>" />
						</div>
                        <!-- Champ Mot de Passe -->
                        <div class="mb-3 d-flex justify-content-center">
                            <input type="password" class="form-control w-75" name="password" placeholder="Mot de passe" required />
                        </div>
						<!-- Champ Confirmation Mot de Passe -->
						<div class="mb-3 d-flex justify-content-center">
							<input type="password" class="form-control w-75" name="confirm_password" placeholder="Confirmer le mot de passe" required />
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
