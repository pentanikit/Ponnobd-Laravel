// /public/js/analytics.js
window.dataLayer = window.dataLayer || [];

// ---- Virtual pageview for Livewire/SPA updates ----
document.addEventListener('livewire:navigated', () => {
  window.dataLayer.push({
    event: 'virtual_pageview',
    page_location: window.location.href,
    page_title: document.title
  });
});

// ---- Optional: pass logged-in user id (Blade injects it if available) ----
(function () {
  try {
    const el = document.getElementById('app-user-id');
    if (el && el.dataset.uid) {
      window.dataLayer.push({ user_id: el.dataset.uid });
    }
  } catch (e) {}
})();

// ---- GA4 Ecommerce Helpers ----
window.Analytics = {
  addToCart(item) {
    window.dataLayer.push({
      event: 'add_to_cart',
      ecommerce: {
        currency: 'BDT',
        value: (item.price || 0) * (item.quantity || 1),
        items: [{
          item_id: item.id,
          item_name: item.name,
          item_brand: item.brand,
          item_category: item.category,
          price: item.price,
          quantity: item.quantity || 1
        }]
      }
    });
  },

  beginCheckout(cart) {
    window.dataLayer.push({
      event: 'begin_checkout',
      ecommerce: {
        currency: 'BDT',
        value: cart.total || 0,
        items: (cart.items || []).map(p => ({
          item_id: p.id,
          item_name: p.name,
          item_brand: p.brand,
          item_category: p.category,
          price: p.price,
          quantity: p.qty
        }))
      }
    });
  },

  purchase(order) {
    window.dataLayer.push({
      event: 'purchase',
      ecommerce: {
        currency: 'BDT',
        transaction_id: order.invoice_no,
        value: order.total,
        shipping: order.shipping || 0,
        tax: order.tax || 0,
        items: (order.items || []).map(it => ({
          item_id: it.id,
          item_name: it.name,
          item_brand: it.brand,
          item_category: it.category,
          price: it.price,
          quantity: it.qty
        }))
      }
    });
  }
};


window.addEventListener('view-item', (e) => {
  const p = e.detail || {};
  // GA4 view_item expects ecommerce.items
  window.dataLayer.push({
    event: 'view_item',
    ecommerce: {
      currency: 'BDT',
      value: p.price || 0,
      items: [{
        item_id: p.id,
        item_name: p.name,
        item_brand: p.brand,
        item_category: p.category,
        price: p.price,
        quantity: p.quantity || 1
      }]
    }
  });
});

window.addEventListener('add-to-wishlist', (e) => {
  const p = e.detail || {};
  window.dataLayer.push({
    event: 'add_to_wishlist',
    ecommerce: {
      currency: 'BDT',
      value: p.price || 0,
      items: [{
        item_id: p.id,
        item_name: p.name,
        item_brand: p.brand,
        item_category: p.category,
        price: p.price,
        quantity: 1
      }]
    }
  });
});

window.addEventListener('review-submitted', (e) => {
  const d = e.detail || {};
  // Custom, non-ecommerce event (handy for funnels)
  window.dataLayer.push({
    event: 'review_submitted',
    product_id: d.product_id,
    rating: d.rating
  });
});

// ---- Listen for Livewire/Alpine custom browser events (easy mode) ----
window.addEventListener('add-to-cart',  e => window.Analytics.addToCart(e.detail));
window.addEventListener('begin-checkout', e => window.Analytics.beginCheckout(e.detail));
window.addEventListener('purchase', e => window.Analytics.purchase(e.detail));
