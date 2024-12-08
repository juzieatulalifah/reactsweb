const container= document.querySelector('.container');
const Loginlink=document.querySelector('.signinlink');
const Registerlink=document.querySelector('.signuplink');


Registerlink.addEventListener('click', ()=> {
    container.classList.add('active');
})
Loginlink.addEventListener('click', ()=> {
    container.classList.remove('active');
})

// JavaScript untuk melakukan AJAX cek username dan email
document.addEventListener("DOMContentLoaded", () => {
    const signUser = document.querySelector('input[name="signuser"]');
    const emailInput = document.querySelector('input[name="email"]');
    const loginUser = document.querySelector('input[name="username"]');

    const messageUser = document.getElementById("message-user");
    const messageEmail = document.getElementById("message-email");
    const messageLogin = document.getElementById("message-luser");

    const signupButton = document.querySelector('button[name="signup"]');
    const loginButton = document.querySelector('button[name="login"]');

    let isUsernameAvailable = false;
    let isEmailAvailable = false;
    let isLoginAvailable = false;

    function toggleSignupButton() {
        signupButton.disabled = !(isUsernameAvailable && isEmailAvailable);
    }

    function toggleLoginButton() {
        loginButton.disabled = !isLoginAvailable;
    }

    // Event listener untuk username
    signUser.addEventListener("blur", () => {
        const signuser = signUser.value.trim();
        if (signuser.length > 0) {
            fetch("check_availability.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `type=signuser&value=${signuser}`
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "available") {
                        messageUser.innerText = "";
                        isUsernameAvailable = true;
                    } else {
                        messageUser.innerText = data.message;
                        isUsernameAvailable = false;
                    }
                    toggleSignupButton();
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        } else {
            messageUser.innerText = "";
            isUsernameAvailable = false;
            toggleSignupButton();
        }
    });

    // Event listener untuk email
    emailInput.addEventListener("blur", () => {
        const email = emailInput.value.trim();
        if (email.length > 0) {
            fetch("check_availability.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `type=email&value=${email}`
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "available") {
                        messageEmail.innerText = "";
                        isEmailAvailable = true;
                    } else {
                        messageEmail.innerText = data.message;
                        isEmailAvailable = false;
                    }
                    toggleSignupButton();
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        } else {
            messageEmail.innerText = "";
            isLoginAvailable = false;
            toggleSignupButton();
        }
    });

    // Event listener untuk logun username
    loginUser.addEventListener("blur", () => {
        const user = loginUser.value.trim();
        if (user.length > 0) {
            fetch("check_availability.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `type=username&value=${user}`
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "available") {
                        messageLogin.innerText = "";
                        isLoginAvailable = true;
                    } else {
                        messageLogin.innerText = data.message;
                        isLoginAvailable = false;
                    }
                    toggleLoginButton();
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        } else {
            messageLogin.innerText = "";
            isLoginAvailable = false;
            toggleLoginButton();
        }
    });
});

// Toggle Sidebar with Hamburger Menu
document.getElementById('hamburgerMenu').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
});

// Optional: Close Sidebar When Clicking Outside
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('hamburgerMenu');
    if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
        sidebar.classList.remove('active');
    }
});


Registerlink.addEventListener('click', () => {
    console.log("Register link clicked");
    container.classList.add('active');
});
Loginlink.addEventListener('click', () => {
    console.log("Login link clicked");
    container.classList.remove('active');
});

fetch("check_availability.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `type=username&value=${username}`
})
.then((response) => response.json())
.then((data) => {
    console.log("Server response:", data); // Debugging
})
.catch((error) => {
    console.error("Error fetching data:", error);
});

fetch("check_availability.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `type=username&value=${username}`
})
.then((response) => response.json())
.then((data) => {
    console.log("Server response:", data); // Debugging
})
.catch((error) => {
    console.error("Error fetching data:", error);
});
