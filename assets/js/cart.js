const CART_KEY = 'shoestore_cart';

function getCart() {
    return JSON.parse(localStorage.getItem(CART_KEY)) || { cart_id: Date.now(), items: [] };
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function addToCart(productId, size, qty = 1) {
    let cart = getCart();
    let item = cart.items.find(i => i.product_id == productId && i.size == size);

    if (item) item.quantity += qty;
    else cart.items.push({ product_id: productId, size: size, quantity: qty });

    saveCart(cart);
    alert('Товар добавлен в корзину');
}

function updateQty(productId, size, qty) {
    let cart = getCart();
    let item = cart.items.find(i => i.product_id == productId && i.size == size);
    if (item) item.quantity = qty > 0 ? qty : 1;
    saveCart(cart);
    location.reload();
}

function removeItem(productId, size) {
    let cart = getCart();
    cart.items = cart.items.filter(i => !(i.product_id == productId && i.size == size));
    saveCart(cart);
    location.reload();
}

function clearCart() {
    localStorage.removeItem(CART_KEY);
    location.reload();
}
