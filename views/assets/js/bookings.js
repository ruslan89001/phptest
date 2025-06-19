document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/api/bookings/my');
    const bookings = await response.json();
    const tbody = document.querySelector('#bookings-table tbody');

    bookings.forEach(booking => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${booking.spaceName}</td>
            <td>${new Date(booking.startTime).toLocaleString()}</td>
            <td>${new Date(booking.endTime).toLocaleString()}</td>
            <td>${booking.status}</td>
            <td><button onclick="cancelBooking(${booking.id})">Отменить</button></td>
        `;
        tbody.appendChild(row);
    });
});

async function cancelBooking(id) {
    if (confirm('Вы уверены, что хотите отменить бронирование?')) {
        await fetch(`/api/bookings/${id}`, { method: 'DELETE' });
        window.location.reload();
    }
}