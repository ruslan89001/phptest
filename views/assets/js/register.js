document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    if (formData.get('password') !== formData.get('confirm_password')) {
        alert('Пароли не совпадают');
        return;
    }

    try {
        const response = await fetch('/register', {
            method: 'POST',
            body: formData
        });

        if (response.redirected) {
            window.location.href = response.url;
        } else {
            const error = await response.text();
            alert(error);
        }
    } catch (err) {
        console.error('Registration error:', err);
    }
});