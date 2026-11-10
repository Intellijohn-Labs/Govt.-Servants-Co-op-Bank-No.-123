/**
 * Services Co-operative Bank / Society Frontend JavaScript
 * Vanilla JS only - zero external JS dependencies
 */

document.addEventListener('DOMContentLoaded', function () {
  // 1. Popup Modal Notice Auto-Show (once per 24 hours per notice ID)
  const noticeModal = document.getElementById('announcementPopupModal');
  if (noticeModal) {
    const noticeId = noticeModal.getAttribute('data-notice-id');
    const dismissedKey = 'dismissed_notice_' + noticeId;
    const dismissedTime = localStorage.getItem(dismissedKey);

    const now = Date.now();
    // Show if never dismissed or dismissed more than 24 hours ago
    if (!dismissedTime || (now - parseInt(dismissedTime, 10)) > 86400000) {
      if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const bsModal = new bootstrap.Modal(noticeModal);
        setTimeout(() => bsModal.show(), 1200);

        noticeModal.addEventListener('hidden.bs.modal', function () {
          localStorage.setItem(dismissedKey, Date.now().toString());
        });
      }
    }
  }

  // 2. Quick EMI Calculator Widget
  const emiAmountInput = document.getElementById('quickEmiAmount');
  const emiRateInput = document.getElementById('quickEmiRate');
  const emiTenureInput = document.getElementById('quickEmiTenure');
  const emiResultElem = document.getElementById('quickEmiResult');
  const emiTotalInterestElem = document.getElementById('quickEmiTotalInterest');

  function calculateQuickEmi() {
    if (!emiAmountInput || !emiRateInput || !emiTenureInput || !emiResultElem) {
      return;
    }

    const principal = parseFloat(emiAmountInput.value) || 0;
    const annualRate = parseFloat(emiRateInput.value) || 0;
    const tenureMonths = parseInt(emiTenureInput.value, 10) || 0;

    if (principal <= 0 || annualRate <= 0 || tenureMonths <= 0) {
      emiResultElem.textContent = '₹ 0';
      if (emiTotalInterestElem) emiTotalInterestElem.textContent = '₹ 0';
      return;
    }

    const monthlyRate = (annualRate / 12) / 100;
    const emi = (principal * monthlyRate * Math.pow(1 + monthlyRate, tenureMonths)) /
                (Math.pow(1 + monthlyRate, tenureMonths) - 1);

    const totalPayment = emi * tenureMonths;
    const totalInterest = totalPayment - principal;

    emiResultElem.textContent = '₹ ' + Math.round(emi).toLocaleString('en-IN');
    if (emiTotalInterestElem) {
      emiTotalInterestElem.textContent = '₹ ' + Math.round(totalInterest).toLocaleString('en-IN');
    }
  }

  if (emiAmountInput && emiRateInput && emiTenureInput) {
    [emiAmountInput, emiRateInput, emiTenureInput].forEach(elem => {
      elem.addEventListener('input', calculateQuickEmi);
    });
    calculateQuickEmi();
  }

  // 3. Search Bar Toggle
  const searchToggleBtn = document.getElementById('searchToggleBtn');
  const searchCollapse = document.getElementById('searchCollapse');
  if (searchToggleBtn && searchCollapse) {
    searchToggleBtn.addEventListener('click', function () {
      searchCollapse.classList.toggle('d-none');
      const input = searchCollapse.querySelector('input');
      if (input && !searchCollapse.classList.contains('d-none')) {
        input.focus();
      }
    });
  }
});

// First-visit splash: keep it for a short minimum so the animation is seen,
// hide it once the page has loaded (hard cap so a slow CDN can never trap visitors).
(function () {
  var splash = document.getElementById('splash');
  if (!splash) return;
  var root = document.documentElement;
  if (!root.classList.contains('has-splash')) {
    splash.remove();
    return;
  }
  var MIN_MS = 1700, MAX_MS = 5000, started = Date.now(), hidden = false;
  function hide() {
    if (hidden) return;
    hidden = true;
    splash.classList.add('splash-hide');
    setTimeout(function () {
      root.classList.remove('has-splash');
      splash.remove();
    }, 700);
  }
  function onReady() {
    setTimeout(hide, Math.max(0, MIN_MS - (Date.now() - started)));
  }
  if (document.readyState === 'complete') onReady();
  else window.addEventListener('load', onReady);
  setTimeout(hide, MAX_MS);
})();
