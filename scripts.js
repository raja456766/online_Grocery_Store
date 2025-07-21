document.addEventListener('DOMContentLoaded', () => {
    const cart = [];
    const cartModal = document.getElementById('cart-modal');
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    const cartCount = document.getElementById('cart-count');
    const closeModal = document.getElementById('close-modal');
    const cartBtn = document.getElementById('cart-btn');

    // Handle "Add to Cart"
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const name = button.dataset.name;
            const basePrice = parseFloat(button.dataset.price);
            const img = button.dataset.img;
            const select = button.previousElementSibling;
            const quantity = parseFloat(select.value);
            const unit = select.options[select.selectedIndex].dataset.unit;

            const price = basePrice * quantity;
            const existingItem = cart.find(item => item.name === name && item.quantity === quantity);

            if (existingItem) {
                existingItem.count++;
            } else {
                cart.push({ name, price, img, quantity, unit, count: 1 });
            }

            updateCart();
        });
    });

    // Handle "Buy Now"
    document.querySelectorAll('.buy-now').forEach(button => {
        button.addEventListener('click', () => {
            const name = encodeURIComponent(button.dataset.name);
            const price = parseFloat(button.dataset.price);
            const img = encodeURIComponent(button.dataset.img);
            const unit = button.dataset.unit;
            const select = button.parentElement.querySelector('.quantity-select');
            const quantity = parseFloat(select.value);

            // Redirect with single item details
            const url = `order.php?name=${name}&price=${price}&img=${img}&quantity=${quantity}&unit=${unit}&count=1`;
            window.location.href = url;
        });
    });

    // Update price when quantity changes
    document.querySelectorAll('.quantity-select').forEach(select => {
        select.addEventListener('change', () => {
            const card = select.closest('.product-card');
            const priceElement = card.querySelector('.price');
            const basePrice = parseFloat(priceElement.dataset.basePrice);
            const quantity = parseFloat(select.value);
            priceElement.textContent = `₹${(basePrice * quantity).toFixed(2)} / ${select.options[select.selectedIndex].dataset.unit}`;
        });
    });

    // Cart modal functionality
    cartBtn.addEventListener('click', () => {
        cartModal.style.display = 'block';
    });

    closeModal.addEventListener('click', () => {
        cartModal.style.display = 'none';
    });

    // Handle Checkout
    document.getElementById('checkout-btn').addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default link behavior

        if (cart.length > 0) {
            const cartParams = cart.map(item => {
                return `items[]=${encodeURIComponent(JSON.stringify({
                    name: item.name,
                    price: item.price / item.quantity, // Base price per unit
                    img: item.img,
                    quantity: item.quantity,
                    unit: item.unit,
                    count: item.count
                }))}`;
            }).join('&');

            window.location.href = `order.php?${cartParams}`;
        } else {
            alert('Your cart is empty!');
        }
    });

    function updateCart() {
        cartItems.innerHTML = '';
        let total = 0;

        cart.forEach((item, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px;">
                    <div style="display: flex; align-items: center;">
                        <img src="${item.img}" alt="${item.name}" style="width: 50px; height: 50px; margin-right: 15px; border-radius: 5px;">
                        <span>${item.name} - ₹${(item.price).toFixed(2)} x ${item.count} (${item.quantity} ${item.unit})</span>
                    </div>
                    <button class="remove-item" data-index="${index}" style="background: #ff4444; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Remove</button>
                </div>
            `;
            cartItems.appendChild(li);
            total += item.price * item.count;
        });

        cartTotal.textContent = total.toFixed(2);
        cartCount.textContent = cart.reduce((sum, item) => sum + item.count, 0);

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', (e) => {
                const index = parseInt(e.target.dataset.index);
                const item = cart[index];

                if (item.count > 1) {
                    item.count--;
                } else {
                    cart.splice(index, 1);
                }

                updateCart();
            });
        });
    }
});