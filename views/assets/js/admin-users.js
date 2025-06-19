document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('edit-modal');
    const closeBtn = document.querySelector('.close');

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.editUser = async (userId) => {
        const response = await fetch(`/api/users/${userId}`);
        const user = await response.json();

        document.getElementById('edit-user-id').value = user.id;
        document.getElementById('edit-username').value = user.username;
        document.getElementById('edit-email').value = user.email;
        document.getElementById('edit-role').value = user.role;

        modal.style.display = 'block';
    };

    window.deleteUser = async (userId) => {
        if (confirm('Вы уверены, что хотите удалить пользователя?')) {
            await fetch(`/api/users/${userId}`, { method: 'DELETE' });
            window.location.reload();
        }
    };

    document.getElementById('user-edit-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        await fetch(`/api/users/${formData.get('id')}`, {
            method: 'PUT',
            body: formData
        });

        modal.style.display = 'none';
        window.location.reload();
    });

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
});