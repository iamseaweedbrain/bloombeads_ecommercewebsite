<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bloombeads | Cart 2</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .icon-outline {
      color: transparent;
      -webkit-text-stroke: 1.6px black;
    }
  </style>
</head>
<body class="bg-[#F9F9F9] min-h-screen flex flex-col items-center">

  <?php
    $cartItems = [
      ["name" => "Custom Beaded Bracelet", "price" => 250, "color" => "bg-pink-100", "tag" => "Custom"],
      ["name" => "Anime Figurine Keychain", "price" => 0, "color" => "bg-blue-100", "tag" => "Key"]
    ];

    $shipping = 39;
    $subtotal = array_sum(array_column($cartItems, "price"));
    $total = $subtotal + $shipping;
  ?>

  <!-- Navbar -->
  <header class="w-full flex justify-between items-center py-4 px-12 shadow-sm bg-white">
    <!-- Left: Logo -->
    <h1 class="text-2xl font-bold text-pink-600">Bloombeads</h1>

    <!-- Center: Navigation -->
    <nav class="flex space-x-8 text-gray-700 font-medium">
      <a href="#" class="hover:text-pink-500">Home</a>
      <a href="#" class="hover:text-pink-500">Browse Catalogue</a>
      <a href="#" class="hover:text-pink-500">Design Yours</a>
      <a href="#" class="hover:text-pink-500">Help & FAQ</a>
    </nav>

    <!-- Right: Icons -->
    <div class="flex items-center space-x-6 text-black">
      <a href="#" class="hover:text-gray-700"><i class="fas fa-cog text-xl icon-outline"></i></a>
      <a href="#" class="hover:text-gray-700"><i class="fas fa-shopping-cart text-xl icon-outline"></i></a>
      <a href="#" class="hover:text-gray-700"><i class="fas fa-user text-xl icon-outline"></i></a>
    </div>
  </header>

  <!-- Cart Section -->
  <div class="flex flex-col md:flex-row gap-6 mt-10 w-11/12 md:w-9/12">

    <!-- Left: Items -->
    <div class="flex-1">
      <h2 class="text-2xl font-bold text-gray-800 mb-5">Your Shopping Cart</h2>
      <div class="space-y-4">
        <?php foreach ($cartItems as $item): ?>
          <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm">
            <div class="flex items-center space-x-4">
              <div class="<?php echo $item['color']; ?> text-sm font-bold text-gray-700 px-4 py-2 rounded-lg">
                <?php echo $item['tag']; ?>
              </div>
              <div>
                <h3 class="text-gray-800 font-semibold"><?php echo $item['name']; ?></h3>
                <p class="text-gray-600">₱<?php echo number_format($item['price'], 2); ?></p>
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <button class="bg-gray-200 text-gray-700 px-2 rounded hover:bg-gray-300">-</button>
              <span class="font-medium">1</span>
              <button class="bg-gray-200 text-gray-700 px-2 rounded hover:bg-gray-300">+</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Right: Order Summary -->
    <div class="md:w-1/3">
      <div class="bg-white rounded-2xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h3>
        <div class="flex justify-between text-gray-600 mb-2">
          <span>Sub Total</span>
          <span>₱<?php echo number_format($subtotal, 2); ?></span>
        </div>
        <div class="flex justify-between text-gray-600 mb-2">
          <span>Shipping</span>
          <span>₱<?php echo number_format($shipping, 2); ?></span>
        </div>
        <hr class="my-3 border-gray-300">
        <div class="flex justify-between font-bold text-gray-800 text-lg mb-5">
          <span>Total</span>
          <span class="text-pink-600">₱<?php echo number_format($total, 2); ?></span>
        </div>

        <button class="bg-orange-400 text-white w-full py-2 rounded-lg font-semibold hover:bg-orange-500 mb-3">
          Proceed to Checkout
        </button>
        <button class="text-gray-600 font-medium w-full py-2 rounded-lg hover:bg-gray-100">
          Continue Browsing
        </button>
      </div>
    </div>
  </div>
</body>
</html>