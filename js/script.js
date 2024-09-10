document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.getElementById("menu-toggle");
    const navbarLinks = document.querySelector(".navbar-links");

    menuToggle.addEventListener("click", function() {
        navbarLinks.classList.toggle("active");
        if (navbarLinks.classList.contains("active")) {
            menuToggle.textContent = "X";
        } else {
            menuToggle.textContent = "☰";
        }
    });
});
// JavaScript for Modal Behavior
const deleteButtons = document.querySelectorAll('.delete-product-btn');

deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        const productId = button.dataset.productId;

        // Show modal
        document.getElementById('deleteModal').style.display = 'block';

        // Handle confirmation
        document.getElementById('confirmDelete').addEventListener('click', () => {
            // Redirect to delete script or perform AJAX delete request
            window.location.href = `delete_product.php?id=${productId}`;
        });

        // Handle cancel
        document.getElementById('cancelDelete').addEventListener('click', () => {
            // Hide modal
            document.getElementById('deleteModal').style.display = 'none';
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const track = document.querySelector(".carousel-track");
    const slides = document.querySelectorAll(".carousel-slide");
    
    let index = 0;
    let slideWidth = slides[0].clientWidth; // Initial slide width calculation

    function moveToSlide(index) {
        const position = -slideWidth * index;
        track.style.transform = `translateX(${position}px)`;
    }
    
    function nextSlide() {
        index = (index + 1) % slides.length;
        moveToSlide(index);
    }
    
    // Automatically move to the next slide every 5 seconds
    setInterval(nextSlide, 5000);

    window.addEventListener("resize", function () {
        slideWidth = slides[0].clientWidth;
        moveToSlide(index); // Move to the current slide after resizing
    });
    
    // Initial position adjustment
    moveToSlide(index);
});