<?php echo view('common/head', ['titre' => 'Profile']); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Mon Profil</h3>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <!-- Formulaire de modification -->
                    <form method="post" action="/users/update">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmez le mot de passe</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                    </form>

                    <!-- Bouton de suppression -->
					<div class="mt-3">
						<button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#ConfirmerSuppression">
							Supprimer mon compte
						</button>
					</div>

					<!-- Modal de confirmation de suppression -->
					<div class="modal fade" id="ConfirmerSuppression" tabindex="-1" aria-labelledby="confirmersuppressionLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="confirmersuppressionLabel">Confirmer la suppression ?</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
								</div>
								<div class="modal-body">
									Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.
									<form action="/users/delete" method="post" class="mt-3">
										<?= csrf_field() ?>
										<!-- Champ de confirmation -->
										<div class="mb-3">
											<?php echo form_input('confirm', '', [
												'class' => 'form-control', 
												'required' => 'required', 
												'placeholder' => 'Confirmer'
											]); ?>
										</div>
										<!-- Bouton de confirmation -->
										<button type="submit" class="btn btn-danger w-100">Confirmer</button>
									</form>
								</div>
								<div class="modal-footer">
									<!-- Bouton pour fermer le modal -->
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
								</div>
							</div>
						</div>
</div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view('common/foot'); ?>
