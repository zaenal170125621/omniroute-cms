/* OmniRoute public site JS — Enhanced */
(function () {
  'use strict';

  // ============================================================
  // Utilities
  // ============================================================
  function showToast(message, type = 'info') {
    var existing = document.querySelector('.toast');
    if (existing) existing.remove();

    var toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    toast.textContent = message;
    document.body.appendChild(toast);

    // Force reflow then show
    requestAnimationFrame(function () {
      toast.classList.add('show');
    });

    setTimeout(function () {
      toast.classList.remove('show');
      setTimeout(function () { toast.remove(); }, 250);
    }, 4000);
  }

  function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  }

  // ============================================================
  // Mobile navigation
  // ============================================================
  var toggle = document.querySelector('.menu-toggle');
  var nav = document.querySelector('.nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      nav.classList.toggle('open');
    });
  }

  // ============================================================
  // Portfolio filter
  // ============================================================
  var pills = document.querySelectorAll('.filter-bar .pill');
  var items = document.querySelectorAll('[data-category]');
  if (pills.length && items.length) {
    pills.forEach(function (pill) {
      pill.addEventListener('click', function () {
        pills.forEach(function (p) { p.classList.remove('active'); });
        pill.classList.add('active');
        var filter = pill.getAttribute('data-filter');
        items.forEach(function (item) {
          var show = filter === 'all' || item.getAttribute('data-category') === filter;
          item.style.display = show ? '' : 'none';
        });
      });
    });
  }

  // ============================================================
  // Order multi-step form
  // ============================================================
  var orderForm = document.getElementById('order-form');
  if (orderForm) {
    var panels = orderForm.querySelectorAll('.step-panel');
    var steps = document.querySelectorAll('.order-step');
    var current = 0;

    function showStep(index) {
      panels.forEach(function (p, i) {
        p.classList.toggle('active', i === index);
      });
      steps.forEach(function (s, i) {
        s.classList.toggle('active', i === index);
        s.classList.toggle('done', i < index);
      });
      window.scrollTo({ top: orderForm.offsetTop - 80, behavior: prefersReducedMotion() ? 'auto' : 'smooth' });
    }

    function validateStep(index) {
      // Step 1 requires a package selection
      if (index === 0 && !packageInput.value) {
        var pkgError = orderForm.querySelector('.package-error');
        if (pkgError) pkgError.style.display = 'block';
        var firstOption = orderForm.querySelector('.package-option');
        if (firstOption) firstOption.focus();
        return false;
      }

      var panel = panels[index];
      var fields = panel.querySelectorAll('[required]');
      for (var i = 0; i < fields.length; i++) {
        if (!fields[i].value.trim()) {
          fields[i].focus();
          fields[i].style.borderColor = '#dc2626';
          setTimeout(function () { fields[i].style.borderColor = ''; }, 1600);
          return false;
        }
        var email = fields[i].getAttribute('type') === 'email';
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fields[i].value.trim())) {
          fields[i].focus();
          fields[i].style.borderColor = '#dc2626';
          setTimeout(function () { fields[i].style.borderColor = ''; }, 1600);
          return false;
        }
      }
      return true;
    }

    orderForm.querySelectorAll('[data-next]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        if (!validateStep(current)) return;
        current = Math.min(current + 1, panels.length - 1);
        showStep(current);
      });
    });

    orderForm.querySelectorAll('[data-prev]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        current = Math.max(current - 1, 0);
        showStep(current);
      });
    });

    // Package selection
    var packageInput = orderForm.querySelector('input[name="package"]');
    orderForm.querySelectorAll('.package-option').forEach(function (opt) {
      opt.addEventListener('click', function () {
        orderForm.querySelectorAll('.package-option').forEach(function (o) { o.classList.remove('selected'); });
        opt.classList.add('selected');
        packageInput.value = opt.getAttribute('data-package');
        var pkgError = orderForm.querySelector('.package-error');
        if (pkgError) pkgError.style.display = 'none';
      });
      // Keyboard support
      opt.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          opt.click();
        }
      });
    });

    // Preselect package from URL (?package=xxx) — e.g. from pricing page
    var urlPackage = new URLSearchParams(window.location.search).get('package');
    if (urlPackage) {
      orderForm.querySelectorAll('.package-option').forEach(function (opt) {
        if (opt.getAttribute('data-package') === urlPackage) opt.click();
      });
    }

    showStep(0);
  }

  // ============================================================
  // Newsletter form (AJAX)
  // ============================================================
  document.querySelectorAll('.newsletter-form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = form.querySelector('button[type="submit"]');
      var input = form.querySelector('input[name="email"]');
      var originalText = btn.textContent;
      var successMsg = form.getAttribute('data-toast') || window.t('Terima kasih!');

      btn.disabled = true;
      btn.textContent = '...';

      fetch(form.action, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: new URLSearchParams({ email: input.value })
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          showToast(data.message || successMsg, 'success');
          input.value = '';
        } else {
          showToast(data.message || window.t('Gagal mendaftar'), 'error');
        }
      })
      .catch(function () {
        showToast(window.t('Terjadi kesalahan jaringan'), 'error');
      })
      .finally(function () {
        btn.disabled = false;
        btn.textContent = originalText;
      });
    });
  });

  // ============================================================
  // Case study modal (portofolio)
  // ============================================================
  var modalOverlay = document.createElement('div');
  modalOverlay.className = 'modal-overlay';
  modalOverlay.innerHTML = `
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
      <div class="modal-header">
        <img src="" alt="" id="modal-img">
        <button class="modal-close" aria-label="' + window.t('Tutup') + '">&times;</button>
      </div>
      <div class="modal-body">
        <h2 id="modal-title"></h2>
        <div class="modal-meta" id="modal-meta"></div>
        <p id="modal-desc"></p>
        <div id="modal-tech" style="margin-top:16px;"></div>
        <div style="margin-top:24px;">
          <a id="modal-link" class="btn" href="#" target="_blank" rel="noopener">' + window.t('Lihat Proyek →') + '</a>
        </div>
      </div>
    </div>
  `;
  document.body.appendChild(modalOverlay);

  var modal = modalOverlay.querySelector('.modal');
  var modalImg = modal.querySelector('#modal-img');
  var modalTitle = modal.querySelector('#modal-title');
  var modalMeta = modal.querySelector('#modal-meta');
  var modalDesc = modal.querySelector('#modal-desc');
  var modalTech = modal.querySelector('#modal-tech');
  var modalLink = modal.querySelector('#modal-link');
  var modalClose = modal.querySelector('.modal-close');

  function openModal(portfolioCard) {
    var img = portfolioCard.querySelector('img');
    var title = portfolioCard.querySelector('h3')?.textContent || '';
    var meta = portfolioCard.querySelector('.meta')?.textContent || '';
    var desc = portfolioCard.getAttribute('data-description') || '';
    var link = portfolioCard.getAttribute('href') || '#';
    var tech = portfolioCard.getAttribute('data-tech') || '';

    modalImg.src = img?.src || '';
    modalImg.alt = title;
    modalTitle.textContent = title;
    modalMeta.innerHTML = meta.split('•').map(function (m) {
      return '<span class="tag">' + m.trim() + '</span>';
    }).join('');
    modalDesc.textContent = desc;
    
    // Render tech stack
    if (tech) {
      modalTech.innerHTML = tech.split(',').map(function (t) {
        return '<span class="tag tag-tech">' + t.trim() + '</span>';
      }).join('');
    } else {
      modalTech.innerHTML = '';
    }
    
    modalLink.href = link;

    modalOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    modalClose.focus();
  }

  function closeModal() {
    modalOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  modalClose.addEventListener('click', closeModal);
  modalOverlay.addEventListener('click', function (e) {
    if (e.target === modalOverlay) closeModal();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modalOverlay.classList.contains('open')) closeModal();
  });

  // Attach to portfolio cards with data attributes
  document.querySelectorAll('.portfolio-card[data-description]').forEach(function (card) {
    card.style.cursor = 'pointer';
    card.addEventListener('click', function (e) {
      // Don't open modal if clicking a link inside
      if (e.target.closest('a')) return;
      e.preventDefault();
      openModal(card);
    });
    card.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openModal(card);
      }
    });
  });

  // ============================================================
  // FAQ accordion smooth animation (CSS handles it, but ensure)
  // ============================================================
  document.querySelectorAll('.faq-item summary').forEach(function (summary) {
    summary.addEventListener('click', function () {
      // Let browser handle <details> toggle, CSS animates
    });
  });

  // ============================================================
  // Count-up stats (animasi angka statistik)
  // ============================================================
  function animateCount(el) {
    var target = parseFloat(el.getAttribute('data-count'));
    if (isNaN(target)) return;
    var decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
    var suffix = el.getAttribute('data-suffix') || '';
    var duration = 1400;
    var start = null;

    function format(value) {
      return value.toFixed(decimals).replace('.', ',');
    }

    function step(ts) {
      if (start === null) start = ts;
      var progress = Math.min((ts - start) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
      el.innerHTML = format(target * eased) + (suffix ? '<sup>' + suffix + '</sup>' : '');
      if (progress < 1) requestAnimationFrame(step);
    }

    el.innerHTML = format(0) + (suffix ? '<sup>' + suffix + '</sup>' : '');
    requestAnimationFrame(step);
  }

  var nums = document.querySelectorAll('.stat .num[data-count]');
  if (nums.length) {
    if ('IntersectionObserver' in window && !prefersReducedMotion()) {
      var statsObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            animateCount(entry.target);
            statsObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.4 });
      nums.forEach(function (num) { statsObserver.observe(num); });
    } else {
      // Fallback: tampilkan nilai akhir langsung
      nums.forEach(function (el) {
        var decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
        var suffix = el.getAttribute('data-suffix') || '';
        var value = parseFloat(el.getAttribute('data-count')).toFixed(decimals).replace('.', ',');
        el.innerHTML = value + (suffix ? '<sup>' + suffix + '</sup>' : '');
      });
    }
  }

  // ============================================================
  // Theme toggle
  // ============================================================
  var themeToggle = document.getElementById('theme-toggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      var root = document.documentElement;
      var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', next);
      localStorage.setItem('theme', next);
      var msg = next === 'dark' ? 'Mode gelap diaktifkan' : 'Mode terang diaktifkan';
      showToast(window.t(msg), 'success');
    });
  }

  // ============================================================
  // Scroll reveal
  // ============================================================
  (function initReveal() {
    var targets = document.querySelectorAll(
      '.section-header, .grid-3 > *, .grid-2 > *, .process-step, .stat, .logo-strip, .cs-metrics, .case-main, .case-aside'
    );
    if (!targets.length) return;

    function addIn(el) { el.classList.add('in'); }

    if (!prefersReducedMotion() && 'IntersectionObserver' in window) {
      var idx = 0;
      targets.forEach(function (el) {
        el.classList.add('js-reveal');
        // Stagger anak grid supaya muncul berurutan
        if (/grid-(2|3|4)/.test(el.parentElement.className)) {
          el.style.transitionDelay = Math.min(idx * 70, 350) + 'ms';
          idx++;
        }
      });

      var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            addIn(entry.target);
            revealObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -36px 0px' });

      targets.forEach(function (el) { revealObserver.observe(el); });
    } else {
      targets.forEach(addIn);
    }
  })();

  // ============================================================
  // Scroll handler gabungan: header, to-top, mobile CTA
  // ============================================================
  var toTop = document.getElementById('to-top');
  var siteHeader = document.querySelector('.site-header');
  var mobileCta = document.getElementById('mobile-cta');

  var onScroll = function () {
    var y = window.scrollY || 0;
    if (siteHeader) siteHeader.classList.toggle('scrolled', y > 10);
    if (toTop) {
      var show = y > 600;
      if (toTop.hidden && show) toTop.hidden = false;
      if (!toTop.hidden && !show) toTop.hidden = true;
      toTop.classList.toggle('visible', show);
    }
    if (mobileCta) {
      var showCta = y > 600;
      mobileCta.classList.toggle('visible', showCta);
      document.body.classList.toggle('cta-open', showCta);
    }
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if (toTop) {
    toTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: prefersReducedMotion() ? 'auto' : 'smooth' });
    });
  }

})();