// FORM VALIDATON
const form = document.getElementById('contactForm');
        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            const responseData = await response.json();
            const responseElement = document.getElementById('response');
            if (response.ok) {
                responseElement.classList.remove('error');
                responseElement.classList.add('message');
                responseElement.textContent = responseData.message;
                form.reset();
            } else {
                responseElement.classList.remove('message');
                responseElement.classList.add('error');
                responseElement.textContent = responseData.error;
            }
        });


        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("quoteModal");
            const requestQuoteBtn = document.getElementById("requestQuoteBtn"); // Get button by ID
            const openModalButtons = document.querySelectorAll(".open-modal-btn");
            const closeModalBtn = document.querySelector(".close"); // Close button inside modal
            const captchaInput = document.getElementById("captcha");
            const captchaValue = document.getElementById("captchaValue");
            let correctAnswer;

            // Function to Open Modal
            function openModal() {
                modal.style.display = "flex";
                generateCaptcha();
            }

              // Open modal when any button is clicked
            openModalButtons.forEach(button => {
            button.addEventListener("click", () => {
                modal.style.display = "flex";
            });
        });


            // Function to Close Modal
            function closeModal() {
                modal.style.display = "none";
            }

            // Generate a Random CAPTCHA
            function generateCaptcha() {
                let num1 = Math.floor(Math.random() * 10); // Random number 0-9
                let num2 = Math.floor(Math.random() * 10);
                correctAnswer = num1 + num2;
                captchaValue.textContent = `${num1} + ${num2}`;
            }

            // Handle Form Submission
            document.getElementById("quoteForm").addEventListener("submit", function (event) {
                event.preventDefault();

                if (parseInt(captchaInput.value) !== correctAnswer) {
                    alert("Incorrect CAPTCHA. Please try again.");
                    generateCaptcha();
                    return;
                }

                alert("Form submitted successfully!");
                closeModal();
            });

            // Attach Event Listeners
            requestQuoteBtn.addEventListener("click", openModal);
            closeModalBtn.addEventListener("click", closeModal);

            // Close modal when clicking outside it
            window.addEventListener("click", function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
        



        document.getElementById("quoteForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission
    
            let formData = new FormData(this);
    
            fetch("submit_quote.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === "success") {
                    document.getElementById("quoteForm").reset(); // Reset form on success
                    document.getElementById("quoteModal").style.display = "none"; // Close modal
                }
            })
            .catch(error => console.error("Error:", error));
        });