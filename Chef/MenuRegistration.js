document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('MenuForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        let valid = true;

        // Clear previous error messages
        document.querySelectorAll('.error').forEach(error => {
            error.style.display = 'none';
        });

        // Dish Name validation
        const menuName = document.getElementById('menuName').value.trim();
        if (menuName === '') {
            valid = false;
            document.getElementById('menuNameError').textContent = 'Dish name is required.';
            document.getElementById('menuNameError').style.display = 'block';
        }

        // Dish Description validation
        const menuDescription = document.getElementById('menuDescription').value.trim();
        if (menuDescription === '') {
            valid = false;
            document.getElementById('menuDescriptionError').textContent = 'Dish description is required.';
            document.getElementById('menuDescriptionError').style.display = 'block';
        }

        // Dish Price validation
        const menuPrice = document.getElementById('menuPrice').value.trim();
        if (menuPrice === '') {
            valid = false;
            document.getElementById('menuPriceError').textContent = 'Dish price is required.';
            document.getElementById('menuPriceError').style.display = 'block';
        } else if (isNaN(menuPrice) || parseFloat(menuPrice) <= 0) {
            valid = false;
            document.getElementById('menuPriceError').textContent = 'Enter a valid price.';
            document.getElementById('menuPriceError').style.display = 'block';
        }

        // Dish Image validation
        const menuImage = document.getElementById('menuImage').value;
        if (menuImage === '') {
            valid = false;
            document.getElementById('menuImageError').textContent = 'Dish image is required.';
            document.getElementById('menuImageError').style.display = 'block';
        }

        // Allergen Notice validation (optional, but if entered it must be meaningful)
        const allergens = document.getElementById('allergens').value.trim();
        if (allergens.length > 0 && allergens.length < 3) {
            valid = false;
            document.getElementById('allergensError').textContent = 'Please provide a valid allergen notice or leave it blank.';
            document.getElementById('allergensError').style.display = 'block';
        }

        // If valid, you can submit the form or do other actions
        if (valid) {
            alert('Form submitted successfully!');
            form.submit();
        }
    });
});
