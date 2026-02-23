// Menu tab switching
document.querySelectorAll('.tab').forEach(tab => {
  tab.addEventListener('click', () => {
    const category = tab.dataset.tab;

    // Update active tab
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');

    // Show/hide menu items
    document.querySelectorAll('.menu-item').forEach(item => {
      item.style.display = item.dataset.category === category ? 'flex' : 'none';
    });
  });
});

// Order form submission
const form = document.querySelector('.order-form form');
if (form) {
  form.addEventListener('submit', e => {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    btn.textContent = '✅ Order Placed!';
    btn.style.background = '#16a34a';
    btn.disabled = true;
    form.reset();
    setTimeout(() => {
      btn.textContent = 'Place Order';
      btn.style.background = '';
      btn.disabled = false;
    }, 3000);
  });
}

// Smooth "Add" button feedback
document.querySelectorAll('.btn-add').forEach(btn => {
  btn.addEventListener('click', () => {
    const original = btn.textContent;
    btn.textContent = '✓ Added!';
    btn.style.background = '#16a34a';
    setTimeout(() => {
      btn.textContent = original;
      btn.style.background = '';
    }, 1500);
  });
});
