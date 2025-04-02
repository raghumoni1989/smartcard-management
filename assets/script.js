// script.js - JavaScript for Smart Card Booking System

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    
    if (form) {
        form.addEventListener("submit", function (event) {
            let isValid = true;
            const inputs = form.querySelectorAll("input[required], select[required], textarea[required]");
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.border = "2px solid red";
                } else {
                    input.style.border = "";
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                alert("Please fill in all required fields correctly.");
            }
        });
    }

    // Razorpay Payment Button Trigger
    const razorpayBtn = document.getElementById("razorpay-btn");
    if (razorpayBtn) {
        razorpayBtn.addEventListener("click", function () {
            var options = {
                "key": "RAZORPAY_KEY_ID", // Replace with your Razorpay Key ID
                "amount": "100", // Amount in paise
                "currency": "INR",
                "name": "Smart Card Booking",
                "description": "Payment for Smart Card",
                "order_id": "ORDER_ID", // Replace dynamically
                "handler": function (response) {
                    window.location.href = "razorpay_success.php?payment_id=" + response.razorpay_payment_id;
                },
                "theme": {
                    "color": "#007bff"
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        });
    }
});