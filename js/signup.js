const regForm = document.querySelector('#signup-form');
const nameIn = document.querySelector('#name');
const emailIn = document.querySelector('#email');
const pass1In = document.querySelector('#pwd1');
const pass2In = document.querySelector('#pwd2');
const phoneIn = document.querySelector('#phone-number');
const errFields = document.querySelectorAll(".form-error");
errFields.forEach((field) => field.remove());
const errMsg = document.querySelector('#error-message');

function clearErrs() {
    const errElements = document.querySelectorAll(".form-error");
    errElements.forEach((element) => {
        element.remove();
    });

    nameIn.classList.remove("is-invalid");
    emailIn.classList.remove("is-invalid");
    pass1In.classList.remove("is-invalid");
    pass2In.classList.remove("is-invalid");
    phoneIn.classList.remove("is-invalid");

}

regForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    clearErrs();

    const name = nameIn.value.trim();
    const email = emailIn.value.trim();
    const pass1 = pass1In.value.trim();
    const pass2 = pass2In.value.trim();
    const phone = phoneIn.value.trim();

    let hasErr = false;

    if (name === "") {
        showError(nameIn, "Full name is required");
        hasErr = true;
    }

    if (email === "") {
        showError(emailIn, "Username is required");
        hasErr = true;
    }

    if (pass1 === "") {
        showError(pass1In, "Password is required");
        hasErr = true;
    }

    if (pass2 === "") {
        showError(pass2In, "Confirm password is required");
        hasErr = true;
    }

    if (pass1 != pass2) {
        showError(pass2In, "Passwords do not match");
        hasErr = true;
    }

    if (phone === "") {
        showError(phoneIn, "Phone number is required");
        hasErr = true;
    }

    if (!hasErr) {
        try {
            const response = await fetch('register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `email=${encodeURIComponent(email)}&name=${encodeURIComponent(name)}&pwd1=${encodeURIComponent(pass1)}&number=${encodeURIComponent(phone)}`,
            });

            const data = await response.json();
            console.log(data);

            if (data.success) {
                // Redirect user to home page
                window.location.href = 'home.php';
            } else {
                errMsg.textContent = data.message;
            }
        } catch (error) {
            console.error(error);
            errMsg.textContent = 'An error occurred. Please try again later.';
        }
    }
});

function showError(input, message) {
    let errEl = document.createElement("div");
    errEl.classList.add("form-error", "text-danger");
    errEl.innerText = message;

    input.parentElement.appendChild(errEl);
    input.classList.add("is-invalid");

}






