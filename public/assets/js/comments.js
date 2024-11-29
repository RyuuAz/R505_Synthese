document.addEventListener("DOMContentLoaded", function () {
    // Sélectionner tous les boutons d'édition
    document.querySelectorAll(".edit-btn").forEach(function (editBtn) {
        editBtn.addEventListener("click", function () {
            // Trouver le conteneur du commentaire associé
            const parentContainer = this.closest(".editable-parent");
            if (!parentContainer) {
                console.error("Parent container not found.");
                return;
            }

            const commentContainer = parentContainer.querySelector(".editable-comment");
            if (!commentContainer) {
                console.error("Comment container not found.");
                return;
            }

            const commentText = commentContainer.querySelector(".comment-text");
            const commentInput = commentContainer.querySelector(".comment-input");
            const validateBtn = parentContainer.querySelector(".validate-btn");

            if (!commentText || !commentInput || !validateBtn) {
                console.error("Comment text, input field or validate button not found.");
                return;
            }

            // Passer du mode affichage au mode édition
            commentText.classList.add("d-none");
            commentInput.classList.remove("d-none");
            commentInput.focus();

            // Afficher le bouton de validation et masquer le bouton d'édition
            this.classList.add("d-none");
            validateBtn.classList.remove("d-none");

            // Sauvegarder le commentaire lors de la perte de focus ou en appuyant sur Entrée
            commentInput.addEventListener("blur", saveComment);
            commentInput.addEventListener("keydown", function (e) {
                if (e.key === "Enter") {
                    saveComment.call(this);
                }
            });

            function saveComment() {
                const newValue = this.value;
                commentText.textContent = newValue;
                commentText.classList.remove("d-none");
                commentInput.classList.add("d-none");

                // Masquer le bouton de validation et réafficher le bouton d'édition
                validateBtn.classList.add("d-none");
                editBtn.classList.remove("d-none");

                // Récupérer l'ID du commentaire
                const commentId = parentContainer.querySelector(".edit-btn").getAttribute("data-comment-id");

				console.log("Comment ID:", commentId);
				console.log(JSON.stringify({
					content: newValue,
				}));
                // Envoi de la modification au serveur via AJAX
                fetch(`/comments/update/${commentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
						id : commentId,
                        content: newValue,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Comment saved:", newValue);
                    } else {
                        console.error("Error saving comment:", data.message);
                    }
                })
                .catch(error => {
                    console.error("Error during fetch:", error);
                });
            }

            console.log("Parent container:", parentContainer);
            console.log("Comment container:", commentContainer);
            console.log("Comment text:", commentText);
            console.log("Comment input:", commentInput);
        });
    });

    // Gérer le clic sur le bouton de validation
    document.querySelectorAll(".validate-btn").forEach(function (validateBtn) {
        validateBtn.addEventListener("click", function () {
            const parentContainer = this.closest(".editable-parent");
            if (!parentContainer) {
                console.error("Parent container not found.");
                return;
            }

            const commentContainer = parentContainer.querySelector(".editable-comment");
            const commentText = commentContainer.querySelector(".comment-text");
            const commentInput = commentContainer.querySelector(".comment-input");

            if (!commentText || !commentInput) {
                console.error("Comment text or input field not found.");
                return;
            }

            const newValue = commentInput.value;
            commentText.textContent = newValue;
            commentText.classList.remove("d-none");
            commentInput.classList.add("d-none");

            // Masquer le bouton de validation et réafficher le bouton d'édition
            this.classList.add("d-none");
            parentContainer.querySelector(".edit-btn").classList.remove("d-none");

            // Récupérer l'ID du commentaire
            const commentId = parentContainer.querySelector(".edit-btn").getAttribute("data-comment-id");

            // Envoi de la modification au serveur via AJAX
            fetch(`/comments/update/${commentId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    content: newValue,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Comment saved:", newValue);
                } else {
                    console.error("Error saving comment:", data.message);
                }
            })
            .catch(error => {
                console.error("Error during fetch:", error);
            });
        });
    });
});
