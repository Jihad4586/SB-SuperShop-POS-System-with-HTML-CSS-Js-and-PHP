const items = [
  { name: "Industries XL Blue Long Sleeve Shirt EUC", price: 44, qty: 3 },
  { name: "Panama Hat", price: 24, qty: 2 },
  { name: "Bikini Water (Kids)", price: 5, qty: 1 },
  { name: "DRESSTELLS Women Vintage Cocktail Dress", price: 100, qty: 1 },
  { name: "Black Gym Training Shoes", price: 350, qty: 1 },
  { name: "Banana Philippine 500g", price: 35, qty: 5 },
  { name: "Indian Papaya Fruit 1kg", price: 15, qty: 2 }
];

const orderItems = document.getElementById("order-items");
const itemsTotal = document.getElementById("items-total");
const discount = document.getElementById("discount");
const finalTotal = document.getElementById("final-total");
const paymentButton = document.getElementById("payment-button"); // Payment button

// Function to update totals
function updateTotals() {
  let total = items.reduce((sum, item) => sum + item.price * item.qty, 0);
  let discountAmount = total * 0.05;
  let finalAmount = total - discountAmount;

  itemsTotal.textContent = total.toFixed(2);
  discount.textContent = discountAmount.toFixed(2);
  finalTotal.textContent = finalAmount.toFixed(2);
}

// Function to render items dynamically
function renderItems() {
  if (items.every((item) => item.qty === 0)) {
    orderItems.innerHTML = `<tr><td colspan="3" style="text-align: center;">No items in the cart</td></tr>`;
  } else {
    orderItems.innerHTML = items
      .map(
        (item, index) => `
        <tr style="background-color: ${item.qty === 0 ? '#ffcccc' : 'transparent'}">
          <td>${item.name}</td>
          <td>
            <button onclick="decreaseQty(${index})">-</button>
            ${item.qty}
            <button onclick="increaseQty(${index})">+</button>
          </td>
          <td>$${item.price.toFixed(2)}</td>
        </tr>
      `
      )
      .join("");
  }
  updateTotals();
}

// Function to increase item quantity
function increaseQty(index) {
  items[index].qty++;
  renderItems();
}

// Function to decrease item quantity
function decreaseQty(index) {
  if (items[index].qty > 0) {
    items[index].qty--;
    renderItems();
  } else {
    alert("Quantity cannot be less than 0!");
  }
}

// Add event listener for the payment button
paymentButton.addEventListener("click", () => {
  if (items.every((item) => item.qty === 0)) {
    alert("Your cart is empty! Add items to proceed to payment.");
  } else {
    alert(`Final Total: $${finalTotal.textContent}. Proceeding to payment!`);
  }
});

// Initial rendering of items
renderItems();
