<?php 
    include_once 'header.php';
?> 
<div class="flex items-center justify-center min-h-screen bg-gray-100">  
    <div id="successModal" class="fixed top-2 left-1/2 transform -translate-x-1/2 z-50 bg-green-500 p-5 shadow-lg w-4/5 md:w-4/6 lg:w-2/5 h-16 flex item-center justify-center hidden">
        <h3 id="successMessage" class="text-slate-500 text-center text-lg font-semibold">Signed up Successfully</h3>
    </div>
    <div id="errorModal" class="fixed top-2 left-1/2 transform -translate-x-1/2 z-50 bg-red-500 p-5 shadow-lg w-4/5 md:w-4/6 lg:w-2/5 h-16 flex item-center justify-center hidden">
        <h3 id="errorMessage" class="text-slate-500 text-center text-lg font-semibold">Signed up Successfully</h3>
    </div>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Login</h2>

        <form class="mt-6" id="LoginForm">
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

            <!-- Submit Button -->
            <button type="submit" id="signupBtn" disabled class="w-full mt-6 bg-gray-400 text-white font-bold py-2 rounded-lg cursor-not-allowed">
                Login
            </button>
        </form>

        <!-- Don't have an account? -->
        <p class="mt-4 text-sm text-center text-gray-600">
            Dont't have an account? 
            <a href="signup.php" class="text-blue-500 hover:underline">Signup</a>
        </p>
    </div>
</div> 

<script>
    // Check if there's a success message in localStorage
    let msg = localStorage.getItem('msg');
    if (msg) {
        // Show the modal with the success message
        document.getElementById('successMessage').textContent = msg;
        document.getElementById('successModal').style.display = 'block';
        // Hide the modal after 4 seconds
        setTimeout(() => {
            document.getElementById('successModal').style.display = 'none';
        }, 4000); // 4000 milliseconds = 4 seconds
        // Optionally, clear the message after displaying
        localStorage.removeItem('msg');
    }

    let isEmailValid = false;
    let isPasswordValid = false;
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
            if (field.id === "email") {
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
            updateSubmitButton();
        }, typingDelay); // Wait for the delay before executing validation
    }

    // Update submit button based on the validation status
    function updateSubmitButton() {
        let submitBtn = document.getElementById('signupBtn');
        if (isEmailValid && isPasswordValid) {
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
    document.getElementById('email').addEventListener('input', validateField);
    document.getElementById('password').addEventListener('input', validateField);
    document.getElementById("LoginForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission
        let formData = new FormData(this);
        fetch("../middlewares/loginHandler.php", {
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
                localStorage.setItem('user', data.user);
                document.getElementById('LoginForm').reset(); // Clear the form after successful signup
                window.location.href = "home.php"; // Redirect to login page or another page
            } else {
                // Show error messages
                if (data.emailError) {
                    document.getElementById("emailError").textContent = data.emailError;
                }
                if (data.passwordError) {
                    document.getElementById("passwordError").textContent = data.passwordError;
                }
                if (data.errorMessage){
                    // Show the modal with the error message
                    document.getElementById('errorMessage').textContent = data.errorMessage;
                    document.getElementById('errorModal').style.display = 'block';
                    // Hide the modal after 4 seconds
                    setTimeout(() => {
                        document.getElementById('errorModal').style.display = 'none';
                    }, 4000); // 4000 milliseconds = 4 seconds
                }
            }
        })
        .catch(error => console.error("Error:", error)); 
    });
</script>
<?php 
    include_once 'footer.php';
?>
