
// Grab form elements
const loginFrm = document.getElementById('login-form');
const userEmail = document.getElementById('email');
const userPassword = document.getElementById('password');
const errorMsg = document.getElementById('error-message');

// Form event listener
loginFrm.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Get form values
    const emailValue = userEmail.value.trim();
    const passwordValue = userPassword.value.trim();

// Ensure both fields have data
    if (emailValue === '' || passwordValue === '') {
        errorMsg.textContent = 'Please fill in both fields.';
        return;
    }

    try {
        // Submit login details
        const resp = await fetch('index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `Login=1&email=${encodeURIComponent(emailValue)}&password=${encodeURIComponent(passwordValue)}`,
        });

        // Process response
        const responseData = await resp.json();
        console.log(responseData);

        // Redirect to home page if successful, display error if not
        if (responseData.success) {
            window.location.href = 'home.php';
        } else {
            errorMsg.textContent = responseData.message;
        }
    } catch (err) {
        // Show error message if there is a problem
        console.error(err);
        errorMsg.textContent = 'An issue occurred. Please try again later.';
    }
});
