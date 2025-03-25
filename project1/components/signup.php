<?php 
    include_once 'header.php';
?>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div id="errorModal" class="fixed top-2 left-1/2 transform -translate-x-1/2 z-50 bg-red-500 p-5 shadow-lg w-4/5 md:w-4/6 lg:w-2/5 h-16 flex item-center justify-center hidden">
        <h3 id="errorMessage" class="text-slate-500 text-center text-lg font-semibold">Signed up Successfully</h3>
    </div>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Sign Up</h2>

        <form class="mt-6" id="SignupForm">
            <!-- Full Name -->
            <div>
                <label class="block text-gray-600 text-sm font-semibold">Full Name</label>
                <input type="text" name="username" id="username" required class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <span id="usernameError" class="text-red-500 text-sm"></span>
            </div>

            <!-- Email -->
            <div class="mt-4">
                <label class="block text-gray-600 text-sm font-semibold">Email</label>
                <input type="email" name="email" id="email" required class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <span id="emailError" class="text-red-500 text-sm"></span>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label class="block text-gray-600 text-sm font-semibold">Password</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <span id="passwordError" class="text-red-500 text-sm"></span>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label class="block text-gray-600 text-sm font-semibold">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" required class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <span id="cpasswordError" class="text-red-500 text-sm"></span>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="signupBtn" disabled class="w-full mt-6 bg-gray-400 text-white font-bold py-2 rounded-lg cursor-not-allowed">
                Sign Up
            </button>
        </form>

        <!-- Already have an account? -->
        <p class="mt-4 text-sm text-center text-gray-600">
            Already have an account? 
            <a href="login.php" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>
</div>

<script>
    let isUsernameValid = false;
    let isEmailValid = false;
    let isPasswordValid = false;
    let isCpasswordValid = false;
    let typingTimer; // Timer for detecting typing stop
    const typingDelay = 500; // Delay in milliseconds (0.5s)

    function validateField(event) {
        let field = event.target;
        // Clear the previous timeout if user is still typing
        clearTimeout(typingTimer);
        // Start a new timeout for validation after user stops typing
        typingTimer = setTimeout(() => {
            let value = field.value.trim();
            let errorSpan = document.getElementById(field.id + "Error");
            errorSpan.textContent = ""; // Clear previous error
            if (field.id === "username") {
                let usernameRegex = /^[a-zA-Z ]{3,30}$/;
                isUsernameValid = usernameRegex.test(value);
                if (!isUsernameValid) {
                    errorSpan.textContent = "Full Name should be between 3 and 30 characters, only containing letters and spaces.";
                }
            } 
            else if (field.id === "email") {
                let emailRegex = /^[^\s@]+@(gmail|hotmail)\.com$/;
                isEmailValid = emailRegex.test(value);
                if (!isEmailValid) {
                    errorSpan.textContent = "Please enter a valid Gmail or Hotmail email.";
                }
            } 
            else if (field.id === "password") {
                let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                isPasswordValid = passwordRegex.test(value);
                if (!isPasswordValid) {
                    errorSpan.textContent = "Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
                }
            } 
            else if (field.id === "cpassword") {
                let password = document.getElementById('password').value.trim();
                isCpasswordValid = (value === password && value !== "");
                if (!isCpasswordValid) {
                    errorSpan.textContent = "Passwords do not match.";
                }
            }
            updateSubmitButton();
        }, typingDelay); // Wait for the delay before executing validation
    }

    // Check if all fields are valid before submitting the form
    function updateSubmitButton() {
        let submitBtn = document.getElementById('signupBtn');
        if (isUsernameValid && isEmailValid && isPasswordValid && isCpasswordValid) {
            submitBtn.disabled = false;
            submitBtn.classList.remove("bg-gray-400", "cursor-not-allowed");
            submitBtn.classList.add("bg-blue-500", "hover:bg-blue-600");
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.remove("bg-blue-500", "hover:bg-blue-600");
            submitBtn.classList.add("bg-gray-400", "cursor-not-allowed");
        }
    }

    // Attach validation function to each input field individually
    document.getElementById('username').addEventListener('input', validateField);
    document.getElementById('email').addEventListener('input', validateField);
    document.getElementById('password').addEventListener('input', validateField);
    document.getElementById('cpassword').addEventListener('input', validateField);

    document.getElementById("SignupForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission
        
        let formData = new FormData(this);
        fetch("../middlewares/signupHandler.php", {
            method: "POST",
            body: formData 
        })
        .then(response => response.json()) // Parse the JSON response from PHP
        .then(data => {
            // Clear all previous error messages
            document.querySelectorAll('.text-red-500').forEach(el => el.textContent = "");
            // Handle success or error
            if (data.success) {
                // If success
                localStorage.setItem('msg', data.message);
                document.getElementById('SignupForm').reset(); // Clear the form after successful signup
                window.location.href = "login.php"; // Redirect to login page or another page
            } else {
                // Show error messages
                if (data.usernameError) {
                    document.getElementById("usernameError").textContent = data.usernameError;
                }
                if (data.emailError) {
                    document.getElementById("emailError").textContent = data.emailError;
                }
                if (data.passwordError) {
                    document.getElementById("passwordError").textContent = data.passwordError;
                }
                if (data.cpasswordError) {
                    document.getElementById("cpasswordError").textContent = data.cpasswordError;
                }
                if (data.errorMessage){
                    // Show the modal with the success message
                    document.getElementById('errorMessage').textContent = data.errorMessage;
                    document.getElementById('errorModal').style.display = 'block';
                    // Hide the modal after 4 seconds
                    setTimeout(() => {
                        document.getElementById('errorModal').style.display = 'none';
                    }, 2000); // 4000 milliseconds = 4 seconds
                }
            }
        })
        .catch(error => console.error("Error:", error)); // Log any network or other errors
    });
</script>
<?php 
    include_once 'footer.php';
?>
