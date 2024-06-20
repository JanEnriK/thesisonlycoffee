<?php require 'partials/head.php'; ?>
<?php require 'partials/nav.php'; ?>
<link href="css/chathead.css" rel="stylesheet">
<link href="css/table.css" rel="stylesheet">
<?php
//alert if the item has reached max stocks to be ordered
if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['alert_message']) . "');</script>";
    unset($_SESSION['alert_message']); // Clear the message after displaying it
}
// Check if the session variable for the order number is set
if (isset($_SESSION['orderSubmited']['ordernumber'])) {
    // Output the order number
    $orderNumber = $_SESSION['orderSubmited']['ordernumber'];
    echo '
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            window.onload = function() {
                Swal.fire({
                    title: "Order Placed!",
                    text: "Your order number is ' . $orderNumber . '",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            };
        </script>
        ';
    // Clear the session variable to prevent showing the alert multiple times
    unset($_SESSION['orderSubmited']['ordernumber']);
}
?>

<style>
    .category-btn-checkbox {
        display: none;
        /* hide the checkbox */
        user-select: none;
    }

    .category-btn-label {
        display: inline-block;
        padding: 10px 20px;
        background-color: red;
        /* primary button color */
        color: #fff;
        cursor: pointer;
        user-select: none;
    }

    .category-btn-label.selected {
        background-color: #ff6f00;
        color: #080808;
        font-weight: bold;
        user-select: none;
        /* secondary button color */
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    button {
        background-color: #04AA6D;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: none;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #04AA6D;
    }

    .quantity-input {
        display: inline-flex;
        align-items: center;
    }

    .quantity-control {
        display: flex;
        align-items: center;
    }

    .quantity-btn {
        width: 20px;
        /* Adjust the width of the buttons */
        height: 30px;
        /* Adjust the height of the buttons */
        font-size: 20px;
        cursor: pointer;
        border: 1px solid #ccc;
        /* Add border for better visibility */
        border-radius: 4px;
        /* Add some border radius for a rounded look */
        display: flex;
        /* Use flexbox */
        justify-content: center;
        /* Center the text horizontally */
        align-items: center;
        /* Center the text vertically */
    }

    .quantity-field {
        width: 50px;
        text-align: center;
        margin: 0 10px;
        /* Add some margin between the input field and buttons */
    }
</style>



<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 position-relative overlay-bottom">
    <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
        <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">Menu</h1>
        <div class="d-inline-flex mb-lg-5">
            <p class="m-0 text-white"><a class="text-white" href="">Home</a></p>
            <p class="m-0 text-white px-2">/</p>
            <p class="m-0 text-white">Menu</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Menu Start -->
<div id="product-container" class="container-fluid pt-5">
    <div class="container" id="product-list">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Menu & Pricing</h4>
            <h1 class="display-4">Competitive Pricing</h1>

            <div class="dashboard">
                <div class="content">
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Description</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <script>
                // Fetch product data from the backend
                fetch('/get_products')
                    .then(response => response.json())
                    .then(products => {
                        const productContainer = document.getElementById('tbl_body');

                        // Loop through the products and display them
                        products.forEach(product => {
                            const productCard = document.createElement('tr');
                            // productCard.className = 'col-lg-4 col-md-6 mb-5';
                            // productCard.innerHTML = `
                            //                         <td><a href =/show_product?id=${product.product_id}>${product.product_name}</a></td>
                            //                         <td>${product.product_description}</td>
                            //                         <td>${product.price}</td>
                            //                         <td>${product.status}</td>
                            //                         <td><img height="100px" src="uploads/${product.image}" alt="${product.product_name}"></td>
                            //                     `;


                            if (product.status === "Available") {
                                // If the product is available, enable the link
                                productCard.innerHTML = `
                                <td><a href="/show_product?id=${product.product_id}">${product.product_name}</a></td>
                                <td>${product.product_description}</td>
                                <td>${product.price}</td>
                                <td>${product.status}</td>
                                <td><img height="100px" src="uploads/${product.image}" alt="${product.product_name}"></td>
                            `;
                            } else if (product.status === "Not Available") {
                                // If the product is not available, disable the link
                                productCard.innerHTML = `
                                <td><a style="color:#878787;" disabled>${product.product_name}</a></td>
                                <td>${product.product_description}</td>
                                <td>${product.price}</td>
                                <td>${product.status}</td>
                                <td><img height="100px" src="uploads/${product.image}" alt="${product.product_name}"></td>
                            `;
                            } else {
                                //display null products
                            }
                            productContainer.appendChild(productCard);
                            productContainer.appendChild(productCard);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            </script>
        </div>


    </div>
</div>

<!-- Menu End -->


<!-- Coffee Shop Cart section start -->
<div id="overlay"></div>

<div class="container">
    <!--Cart-Head Starts-->
    <div class="position-fixed rounded-circle bg-primary text-white p-3 cart-head" id="cartHead">
        <i class="fas fa-shopping-cart"></i>
    </div>
    <!--Cart-Head End-->

    <!-- Cart (Hidden) -->
    <div class="position-fixed bottom-0 right-0 m-3 cart bg-light border rounded w-50 h-75" id="cart" style="display: none;">
        <div class="cart-header bg-primary text-white p-2 rounded-top d-flex justify-content-between align-items-center">
            <h4 class="m-0">Your Cart</h4>
            <button class="close-btn btn btn-sm btn-light" id="closeCart">&times;</button>
        </div>
        <div class="cart-body p-3 w-30 h-75">
            <form action="/store_cart" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th style="width:30px;">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) : ?>
                            <tr>
                                <td colspan="4" class="text-center py-3">
                                    <div class="alert alert-info m-0" role="alert">
                                        NO CART ITEMS
                                    </div>
                                </td>
                            </tr>
                            <?php else :
                            $total = 0.0; // Initialize total variable
                            foreach ($_SESSION['cart'] as $key => $item) :
                                $id = $item['base_coffee_id'];
                                $prod = $db->query("SELECT product_id, 
                                product_name,
                                product_description, 
                                price,
                                SKU,
                                CONCAT(UCASE(SUBSTRING(category, 1, 1)), LOWER(SUBSTRING(category, 2))) AS category, 
                                image 
                                FROM tblproducts WHERE product_id = $id")->get();
                            ?>
                                <tr>
                                    <td><?= $item['base_coffee'] ?></td>
                                    <td><?= $prod[0]['price'] ?></td>
                                    <td>
                                        <div class="quantity-input">
                                            <button class="quantity-btn minus-btn" type="button" onclick="decrementQuantity(this)">-</button>
                                            <input style="width: 50px;" type="number" name="<?= $item['base_coffee_id'] ?>" value="<?= $item['quantity'] ?>" readonly data-stock-level="<?= $prod[0]['SKU'] ?>">
                                            <button class="quantity-btn plus-btn" type="button" onclick="incrementQuantity(this,<?= $prod[0]['price'] ?>)">+</button>
                                        </div>
                                    </td>
                                    <td data-base-coffee-id="<?= $item['base_coffee_id'] ?>" data-price="<?= $prod[0]['price'] ?>" data-quantity="<?= $item['quantity'] ?>">
                                        <button type="button" class="remove-item-btn btn btn-danger" name="remove_item" data-base-coffee-id="<?= $item['base_coffee_id'] ?>" value="">X</button>
                                    </td> <!-- Button to remove item -->
                                <?php
                                $total += ($prod[0]['price'] * $item['quantity']); // Accumulate price to total
                            endforeach;
                                ?>
                                <tr>
                                    <th>Total:</th>
                                    <td colspan="3">
                                        <input style="border:none; width:100px;" disabled id="total_order" type="float" value="<?= number_format($total, 2) ?>" step="2" readonly></input> php
                                    </td> <!-- Output total here -->
                                </tr>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
                                <tr>
                                    <td colspan="4">
                                        <button type="submit" class="btn btn-primary btn-block">Checkout</button>
                                    </td> <!-- Checkout button -->
                                </tr>
                            <?php endif; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>


<!-- Chatbot section start -->

<div id="overlay"></div>

<div class="container">
    <!-- <div class="position-fixed bottom-0 end-0 p-2">
        <div class="chat-icon bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" id="toggleChat">
            <i class="fas fa-comment-alt"></i>
        </div>
    </div> -->
    <div class="chat-box bg-light border rounded position-fixed bottom-0 end-0" id="chatBot" style="display: none;">
        <div class="chat-header bg-primary text-white p-2 rounded-top d-flex justify-content-between align-items-center">
            <h4 class="m-0">Order your own coffee here</h4>
            <button class="close-chat-btn btn btn-link text-white">&times;</button>
        </div>
        <div class="chat-body p-3" id="chatBody">
            <form id="chatForm" action="/menu" method="POST">
                <!-- One "tab" for each step in the form: -->
                <div class="tab" id="categories">
                    <?php foreach ($productCategories as $categories) : ?>
                        <label id="<?= ucfirst($categories['category']) ?>" for="<?= $categories['category'] ?>" class="category-btn-label"><?= ucfirst($categories['category']) ?></label>
                        <input id="<?= $categories['category'] ?>" type="radio" name="category" class="category-btn-checkbox" value="<?= ucfirst($categories['category']) ?>">

                    <?php endforeach; ?>
                </div>
                <div class="tab" id="base-coffee">
                    <!-- Coffee Base -->
                </div>
                <div class="tab" id="size-con">
                    <!-- Sizes -->
                </div>
                <div style="overflow:auto;">
                    <div style="float:right;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                </div>
                <!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Chatbot section end-->



<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/tempusdominus/js/moment.min.js"></script>
<script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Template Javascript -->
<?php require "js/main.php"; ?>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryCheckboxes = document.querySelectorAll('.category-btn-checkbox');
        const baseCoffeeContainer = document.getElementById('base-coffee');
        const ingredientsContainer = document.getElementById('prod_ingredients');

        const baseCoffeeOptions = <?= json_encode($products) ?>;
        // Function to update base coffee options based on selected categories
        function updateBaseCoffeeOptions() {
            const selectedCategories = Array.from(categoryCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            // Clear previous options
            baseCoffeeContainer.innerHTML = '';

            // Populate base coffee options for selected categories
            const filteredBaseCoffee = baseCoffeeOptions.filter(coffee => {
                return selectedCategories.includes(coffee.category);
            });

            filteredBaseCoffee.forEach(coffee => {
                const label = document.createElement('label');
                label.textContent = coffee.product_name;
                label.setAttribute('for', coffee.product_name.toLowerCase().replaceAll(' ', '-'));
                label.classList.add('category-btn-label');
                label.id = coffee.product_name.toLowerCase().replaceAll(' ', '_');

                const input = document.createElement('input');
                input.type = 'radio';
                input.name = 'base_coffee';
                input.classList.add('category-btn-checkbox');
                input.value = coffee.product_name.toLowerCase().replaceAll(' ', '_');
                input.id = coffee.product_name.toLowerCase().replaceAll(' ', '-');

                const input1 = document.createElement('input');
                input1.type = 'hidden';
                input1.name = 'order_type';
                input1.value = "take-out";
                input1.id = coffee.product_id;

                const input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'base_coffee_id';
                input2.value = coffee.product_id;
                input2.id = coffee.product_id;

                const div = document.createElement('div');
                div.classList.add('btn-group');
                div.appendChild(label);
                div.appendChild(input);
                div.appendChild(input1);
                div.appendChild(input2);

                baseCoffeeContainer.appendChild(div);
            });

            $('input[name=base_coffee]').change(function() {
                if ($(this).is(':checked')) {
                    const amer = document.getElementById(this.value);
                    amer.classList.add("selected");
                    $('.category-btn-label').not('#' + this.value).removeClass('selected');
                }
            });
        }

        // Event listener for category checkboxes change
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBaseCoffeeOptions);
        });

        // Initially update base coffee options
        updateBaseCoffeeOptions();

        sizes = ["Small", "Medium", "Large"];
        const baseSizeContainer = document.getElementById('size-con');

        sizes.forEach(size => {
            const label = document.createElement('label');
            label.textContent = size;
            label.setAttribute('for', size);
            label.classList.add('category-btn-label');
            label.id = size.toLowerCase();;

            const input = document.createElement('input');
            input.type = 'radio';
            input.name = 'size';
            input.classList.add('category-btn-checkbox');
            input.value = size.toLowerCase();
            input.id = size;

            const div = document.createElement('div');
            div.classList.add('btn-group');
            div.appendChild(label);
            div.appendChild(input);

            baseSizeContainer.appendChild(div);

            $('input[name=size]').change(function() {
                if ($(this).is(':checked')) {
                    const amer = document.getElementById(this.value);
                    amer.classList.add("selected");
                    $('.category-btn-label').not('#' + this.value).removeClass('selected');
                }
            });

        });

    });

    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const baseCoffeeId = this.getAttribute('data-base-coffee-id');
            removeItemFromCart(baseCoffeeId);
        });
    });

    function removeItemFromCart(baseCoffeeId) {
        fetch('/remove_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    base_coffee_id: baseCoffeeId,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Item removed successfully');
                const button = document.querySelector(`button[data-base-coffee-id="${baseCoffeeId}"]`);
                if (button) {
                    // Find the closest ancestor that is a table row (<tr>)
                    const row = button.closest('tr');
                    if (row) {
                        // Remove the row from the DOM
                        row.remove();
                    }
                    // Update total cost after removing the item
                    const newtotalInput = document.getElementById('total_order');
                    newtotalInput.value = calculateTotal();
                }

                // Check if cart is empty
                const cartIsEmpty = document.querySelectorAll('#cart tbody tr').length <= 2;
                if (cartIsEmpty) {
                    // Reload the page
                    location.reload();
                }
            })
            .catch((error) => {
                console.error('Error removing item:', error);
            });
    }




    function calculateTotal() {
        const items = document.querySelectorAll('#cart tbody tr');
        let total = 0.0;
        items.forEach(item => {
            const quantityInput = item.querySelector('input[type="number"]');
            if (quantityInput) {
                const price = parseFloat(item.querySelector('td:nth-child(2)').textContent);
                const quantity = parseInt(quantityInput.value);
                total += price * quantity;
            }
        });
        console.log('Total:', total.toFixed(2)); // Debugging statement
        return total.toFixed(2); // Round to two decimal places
    }


    function incrementQuantity(button) {
        const input = button.parentNode.querySelector('input');
        const currentValue = parseInt(input.value);
        const totalInput = document.getElementById('total_order');
        // Extract baseCoffeeId from the input's name attribute
        const baseCoffeeId = input.name;

        // Assuming the stock level is stored in a data attribute on the input element
        const stockLevel = parseInt(input.dataset.stockLevel); // Get the stock level from the data-stock-level attribute

        // Check if there is enough stock to increase the quantity
        if (currentValue < stockLevel) { // Only allow increment if the current value is less than the stock level
            input.value = currentValue + 1;
            totalInput.value = calculateTotal();

            // Update the session cart
            updateSessionCart(baseCoffeeId, currentValue + 1);
        } else {
            // Optionally, show an alert or notification that the stock level has been reached
            alert('Stock level reached for this product.');
        }
    }

    function decrementQuantity(button) {
        const input = button.parentNode.querySelector('input');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            const totalInput = document.getElementById('total_order');
            // Extract baseCoffeeId from the input's name attribute
            const baseCoffeeId = input.name;
            totalInput.value = calculateTotal();

            // Update the session cart
            updateSessionCart(baseCoffeeId, currentValue - 1);
        }
    }

    function updateSessionCart(baseCoffeeId, newQuantity) {
        fetch('/update_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    base_coffee_id: baseCoffeeId, // Ensure this matches the key expected by the server
                    quantity: newQuantity, // Ensure this matches the key expected by the server
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Cart updated successfully');
            })
            .catch((error) => {
                console.error('Error updating cart:', error);
            });
    }
</script>


<?php require 'partials/foot.php'; ?>