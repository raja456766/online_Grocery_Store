// Array to store inventory items (temporary; use a backend for persistence)
let inventory = [];

// Function to show the form for adding a product
function showAddForm(type) {
    const modal = document.getElementById('form-modal');
    const formFields = document.getElementById('form-fields');
    const form = document.getElementById('crud-form');

    // Set the form type to 'inventory'
    document.getElementById('form-type').value = type;
    document.getElementById('form-id').value = ''; // No ID for a new product

    if (type === 'inventory') {
        // Define the fields for adding a product
        formFields.innerHTML = `
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="0" required>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" min="0" required>
        `;
    }

    // Display the modal
    modal.style.display = 'block';
}

// Function to close the form modal
function closeForm() {
    const modal = document.getElementById('form-modal');
    modal.style.display = 'none';
    document.getElementById('crud-form').reset();
    document.getElementById('form-fields').innerHTML = '';
}

// Function to add a product to the table
function addProductToTable(product) {
    const tableBody = document.getElementById('inventory-table');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${product.id}</td>
        <td>${product.name}</td>
        <td>${product.quantity}</td>
        <td>$${parseFloat(product.price).toFixed(2)}</td>
        <td>
            <button onclick="editProduct(${product.id})">Edit</button>
            <button onclick="deleteProduct(${product.id})">Delete</button>
        </td>
    `;
    tableBody.appendChild(row);
}

// Handle form submission
document.getElementById('crud-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const type = document.getElementById('form-type').value;
    const id = document.getElementById('form-id').value;

    if (type === 'inventory' && id === '') { // New product
        const name = this.querySelector('input[name="name"]').value;
        const quantity = this.querySelector('input[name="quantity"]').value;
        const price = this.querySelector('input[name="price"]').value;

        // Create a new product object
        const newProduct = {
            id: inventory.length + 1, // Simple ID generation
            name: name,
            quantity: parseInt(quantity),
            price: parseFloat(price)
        };

        // Add to inventory array and table
        inventory.push(newProduct);
        addProductToTable(newProduct);

        // Close the form
        closeForm();
    }
});

// Placeholder functions for edit and delete (optional)
function editProduct(id) {
    alert('Edit functionality not implemented yet.');
}

function deleteProduct(id) {
    alert('Delete functionality not implemented yet.');
}