document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('space-modal');
    const closeBtn = document.querySelector('#space-modal .close');

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.showAddSpaceForm = () => {
        document.getElementById('space-form').reset();
        document.getElementById('space-id').value = '';
        modal.style.display = 'block';
    };

    window.editSpace = async (spaceId) => {
        const response = await fetch(`/api/spaces/${spaceId}`);
        const space = await response.json();

        document.getElementById('space-id').value = space.id;
        document.getElementById('space-name').value = space.name;
        document.getElementById('space-description').value = space.description;
        document.getElementById('space-price').value = space.price;
        document.getElementById('space-location').value = space.location;
        document.getElementById('space-availability').value = space.availability ? '1' : '0';

        modal.style.display = 'block';
    };

    window.deleteSpace = async (spaceId) => {
        if (confirm('Вы уверены, что хотите удалить пространство?')) {
            await fetch(`/api/spaces/${spaceId}`, { method: 'DELETE' });
            window.location.reload();
        }
    };

    document.getElementById('space-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const spaceId = formData.get('id');

        await fetch(spaceId ? `/api/spaces/${spaceId}` : '/api/spaces', {
            method: spaceId ? 'PUT' : 'POST',
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