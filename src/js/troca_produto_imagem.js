let currentProductIndex = 0;
const products = document.querySelectorAll('.lista .cartao');

function changeProduct(direction) {
    products[currentProductIndex].style.display = 'none';
    currentProductIndex += direction;
    
    if (currentProductIndex < 0) {
        currentProductIndex = products.length - 1;
    } else if (currentProductIndex >= products.length) {
        currentProductIndex = 0;
    }

    products[currentProductIndex].style.display = 'block';

    // Reset button colors
    document.querySelectorAll('.prev, .next').forEach(button => {
        button.classList.remove('active');
    });

    // Set the active button
    if (direction === 1) {
        products[currentProductIndex].querySelector('.next').classList.add('active');
    } else {
        products[currentProductIndex].querySelector('.prev').classList.add('active');
    }
}

// Initially show the first product
products[currentProductIndex].style.display = 'block';
