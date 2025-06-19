document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/api/spaces/featured');
    const spaces = await response.json();
    const container = document.getElementById('featured-spaces');

    spaces.forEach(space => {
        const card = document.createElement('div');
        card.className = 'space-card';
        card.innerHTML = `
            <h3>${space.name}</h3>
            <p>${space.location}</p>
            <p>${space.price} руб./час</p>
        `;
        container.appendChild(card);
    });
});