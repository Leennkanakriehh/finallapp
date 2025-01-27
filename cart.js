const cartItems = document.querySelectorAll('.item');

cartItems.forEach(item => {
    const decrementButton = item.querySelector('.decrement');
    const incrementButton = item.querySelector('.increment');
    const quantitySpan = item.querySelector('.quantity span:nth-child(2)');
    const totalPrice = item.querySelector('.totalPrice');

    let quantity = parseInt(quantitySpan.textContent);
    let pricePerItem = parseInt(totalPrice.textContent.replace('$', ''));

    decrementButton.addEventListener('click', () => {
        if (quantity > 1) {
            quantity--;
            quantitySpan.textContent = quantity;
            totalPrice.textContent = "$" + (quantity * pricePerItem);
        }
    });

    incrementButton.addEventListener('click', () => {
        quantity++;
        quantitySpan.textContent = quantity;
        totalPrice.textContent = "$" + (quantity * pricePerItem);

    });
});
