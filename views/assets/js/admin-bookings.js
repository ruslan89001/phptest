document.addEventListener('DOMContentLoaded', () => {
    window.updateBookingStatus = async (bookingId, status) => {
        await fetch(`/api/bookings/${bookingId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status })
        });
    };

    window.deleteBooking = async (bookingId) => {
        if (confirm('Вы уверены, что хотите удалить бронирование?')) {
            await fetch(`/api/bookings/${bookingId}`, { method: 'DELETE' });
            window.location.reload();
        }
    };
});