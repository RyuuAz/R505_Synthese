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

					<!-- Informations de l'utilisateur -->
					<div class="mb-3">
						<label for="firstname" class="form-label"> <?= esc($user['first_name']) ?></label>
					</div>
					<div class="mb-3">
						<label for="lastname" class="form-label"> <?= esc($user['last_name']) ?></label>
					</div>
					<div class="mb-3">
						<label for="email" class="form-label"> <?= esc($user['email']) ?></label>
					</div>

					<!-- Bouton de modifcation -->
					<div class="mt-3">
						<button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#ModificationUser">
							Modifier mes informations
						</button>
					</div>

					<!-- Modal de modification -->
					<div class="modal fade" id="ModificationUser" tabindex="-1" aria-labelledby="modificationUser" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="modificationUser">Confirmer la modifcation ?</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
								</div>
								<div class="modal-body">
									<!-- Formulaire de modification -->
									<form method="post" action="/users/update">
										<?= csrf_field() ?>
										<div class="mb-3">
											<input type="text" class="form-control" id="firstname" name="first_name" value="<?= esc($user['first_name']) ?>" required>
										</div>
										<div class="mb-3">
											<input type="text" class="form-control" id="lastname" name="last_name" value="<?= esc($user['last_name']) ?>" required>
										</div>
										<div class="mb-3">
											<input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
										</div>
										<div class="mb-3">
											<input type="password" class="form-control" id="password" name="password" required>
										</div>
										<div class="mb-3">
											<input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
										</div>
										<button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
									</form>
								</div>
								<div class="modal-footer">
									<!-- Bouton pour fermer le modal -->
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
								</div>
							</div>
						</div>
					</div>

                    
							
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
