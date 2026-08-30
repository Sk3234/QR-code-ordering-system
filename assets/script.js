/* ==============================================
   Hotel Menu System – Shared JS
   ============================================== */

// Retrieve cart from localStorage
function getCart() {
  return JSON.parse(localStorage.getItem('cart')) || [];
}

// Save cart to localStorage
function saveCart(cart) {
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartBadge();
}

// Add item to cart
function addToCart(id, name, price) {
  const cart = getCart();
  const existing = cart.find(item => item.id === id);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({ id, name, price, qty: 1 });
  }
  saveCart(cart);
  alert(`${name} added to cart!`);
}

// Update badge
function updateCartBadge() {
  const cart = getCart();
  const count = cart.reduce((sum, item) => sum + item.qty, 0);
  const badge = document.getElementById('cart-count');
  if (badge) badge.textContent = count;
}

// Remove item from cart
function removeFromCart(id) {
  let cart = getCart();
  cart = cart.filter(item => item.id !== id);
  saveCart(cart);
  location.reload();
}

// Calculate total
function getCartTotal() {
  const cart = getCart();
  return cart.reduce((total, item) => total + item.price * item.qty, 0);
}

// Proceed order
async function placeOrder() {
  const table_no = prompt("Enter table number:");
  if (!table_no) return alert("Table number required.");

  const cart = getCart();
  if (!cart.length) return alert("Your cart is empty!");

  const orderData = {
    table_no,
    items: cart,
    total: getCartTotal()
  };

  const res = await fetch('../api/add_order.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(orderData)
  });

  const data = await res.json();
  if (data.status === 'success') {
    alert("✅ Order placed successfully!");
    localStorage.removeItem('cart');
    localStorage.setItem('tableNo', table_no);

    // also store order for kitchen
    const allOrders = JSON.parse(localStorage.getItem('orderStatus')) || [];
    orderData.items.forEach(it => {
      allOrders.push({ ...it, status: 'preparing' });
    });
    localStorage.setItem('orderStatus', JSON.stringify(allOrders));

    window.location.href = 'status.html';
  } else {
    alert("❌ Failed to place order: " + data.message);
  }
}
