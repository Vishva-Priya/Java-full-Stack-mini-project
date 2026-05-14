// main.js

document.addEventListener('DOMContentLoaded', () => {
  // Elements
  const editProfileBtn = document.getElementById('editProfileBtn');
  const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
  const editProfileForm = document.getElementById('editProfileForm');

  // Open modal when clicking "Edit Profile" button
  if (editProfileBtn) {
    editProfileBtn.addEventListener('click', () => {
      editProfileModal.show();
    });
  }

  // Basic form validation on submit (optional)
  if (editProfileForm) {
    editProfileForm.addEventListener('submit', (event) => {
      const firstName = editProfileForm.querySelector('input[name="firstName"]').value.trim();
      const lastName = editProfileForm.querySelector('input[name="lastName"]').value.trim();

      if (!firstName || !lastName) {
        event.preventDefault();
        alert('Please fill in both first and last names.');
      }
    });
  }
});
