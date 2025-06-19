document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/api/spaces');
    const spaces = await response.json();
    const container = document.getElementById('spaces-container');

    spaces.forEach(space => {
        const card = document.createElement('div');
        card.className = 'space-card';
        card.innerHTML = `
            <img src="/uploads/${space.image || 'default.jpg'}" alt="${space.name}">
            <h3>${space.name}</h3>
            <p>${space.description}</p>
            <p>Цена: ${space.price} руб./час</p>
            <p>Локация: ${space.location}</p>
            ${space.availability ? `
                <div class="booking-form">
                    <input type="datetime-local" id="start-${space.id}">
                    <input type="datetime-local" id="end-${space.id}">
                    <button onclick="bookSpace(${space.id})">Забронировать</button>
                </div>
            ` : '<p class="not-available">Недоступно</p>'}
        `;
        container.appendChild(card);
    });
});

async function bookSpace(spaceId) {
    const start = document.getElementById(`start-${spaceId}`).value;
    const end = document.getElementById(`end-${spaceId}`).value;

    if (!start || !end) {
        alert('Укажите даты бронирования');
        return;
    }

    try {
        const response = await fetch('/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                space_id: spaceId,
                start_time: start,
                end_time: end
            })
        });

        if (response.ok) {
            window.location.href = '/bookings';
        } else {
            const error = await response.text();
            alert(error);
        }
    } catch (err) {
        console.error('Booking error:', err);
    }
}