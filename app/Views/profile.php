<?php echo view('common/head', ['titre' => 'Profile']); ?>
<link rel="stylesheet" href="/assets/css/profile.css">

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

					<!-- Boutons pour ouvrir les modals -->
					<button class="btn btn-primary" onclick="openModal('editModal')">Modifier mes informations</button>
					<button class="btn btn-danger" onclick="openModal('deleteModal')">Supprimer mon compte</button>


                </div>
            </div>
			<!-- Modal de modification -->
			<div id="editModal" class="modal">
				<div class="modal-header">
					<h3 class="modal-title">Modifier mes informations</h3>
					<button class="modal-close" onclick="closeModal('editModal')">&times;</button>
				</div>
				<div class="modal-body">
					<form method="post" action="/users/update">
						<?= csrf_field() ?>
						<div class="mb-3">
							<label for="firstname">Prénom :</label>
							<input type="text" id="firstname" name="first_name" value="<?= esc($user['first_name']) ?>" required>
						</div>
						<div class="mb-3">
							<label for="lastname">Nom :</label>
							<input type="text" id="lastname" name="last_name" value="<?= esc($user['last_name']) ?>" required>
						</div>
						<div class="mb-3">
							<label for="email">Email :</label>
							<input type="email" id="email" name="email" value="<?= esc($user['email']) ?>" required>
						</div>
						<div class="mb-3">
							<label for="password">Mot de passe :</label>
							<input type="password" id="password" name="password">
						</div>
						<div class="mb-3">
							<label for="confirm_password">Confirmer le mot de passe :</label>
							<input type="password" id="confirm_password" name="confirm_password">
						</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" onclick="closeModal('editModal')">Annuler</button>
							<button class="btn btn-primary" type="submit">Enregistrer</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Modal de confirmation de suppression -->
			<div id="deleteModal" class="modal">
				<div class="modal-header">
					<h3 class="modal-title">Confirmer la suppression</h3>
					<button class="modal-close" onclick="closeModal('deleteModal')">&times;</button>
				</div>
				<div class="modal-body">
					<p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>
					<form action="/users/delete" method="post">
						<?= csrf_field() ?>
						<div class="mb-3">
							<input type="text" name="confirm" placeholder="Tapez CONFIRMER" required>
						</div>
						<button type="submit" class="btn btn-danger">Confirmer</button>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" onclick="closeModal('deleteModal')">Annuler</button>
				</div>
			</div>

        </div>
    </div>
</div>

<script src="/assets/js/profile.js"></script>

<?php echo view('common/foot'); ?>
