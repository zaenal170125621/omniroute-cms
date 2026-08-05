/* OmniRoute CMS admin JS — Enhanced */
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

    requestAnimationFrame(function () {
      toast.classList.add('show');
    });

    setTimeout(function () {
      toast.classList.remove('show');
      setTimeout(function () { toast.remove(); }, 250);
    }, 3000);
  }

  function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || 
           document.querySelector('input[name="_token"]')?.value || '';
  }

  // ============================================================
  // Sidebar (mobile)
  // ============================================================
  var menuOpen = document.querySelector('.menu-open');
  var sidebar = document.querySelector('.sidebar');
  var sidebarClose = document.querySelector('.sidebar-close');
  if (menuOpen && sidebar) {
    menuOpen.addEventListener('click', function () { sidebar.classList.add('open'); });
    if (sidebarClose) {
      sidebarClose.addEventListener('click', function () { sidebar.classList.remove('open'); });
    }
  }

  // ============================================================
  // Confirm delete forms
  // ============================================================
  document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!window.confirm(form.getAttribute('data-confirm'))) {
        e.preventDefault();
      }
    });
  });

  // ============================================================
  // Dynamic list inputs (features / tech stack)
  // ============================================================
  document.querySelectorAll('.dyn-list').forEach(function (list) {
    var addBtn = list.querySelector('.dyn-add');

    function addRow(value) {
      var row = document.createElement('div');
      row.className = 'dyn-row';
      row.innerHTML =
        '<input type="text" class="form-control" name="' + list.getAttribute('data-name') + '[]" value="' +
        (value ? value.replace(/"/g, '&quot;') : '') + '" placeholder="' +
        (list.getAttribute('data-placeholder') || window.t('Item')) + '">' +
        '<button type="button" class="dyn-remove" title="' + window.t('Hapus') + '">×</button>';
      row.querySelector('.dyn-remove').addEventListener('click', function () {
        row.remove();
      });
      list.insertBefore(row, addBtn);
    }

    if (addBtn) {
      addBtn.addEventListener('click', function () { addRow(''); });
      list.querySelectorAll('.dyn-row').forEach(function (row) {
        row.querySelector('.dyn-remove').addEventListener('click', function () {
          row.remove();
        });
      });
    }
  });

  // ============================================================
  // Inline status update (leads) — AJAX
  // ============================================================
  document.querySelectorAll('.status-inline select').forEach(function (sel) {
    sel.addEventListener('change', function () {
      var form = this.closest('form');
      var leadId = form?.getAttribute('data-lead-id');
      var newStatus = this.value;
      var originalStatus = this.getAttribute('data-original');

      if (!leadId || newStatus === originalStatus) return;

      var btn = this;
      btn.disabled = true;

      fetch('/admin/leads/' + leadId + '/status', {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken()
        },
        body: JSON.stringify({ status: newStatus })
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          showToast(window.t('Status diperbarui'), 'success');
          btn.setAttribute('data-original', newStatus);
          // Update badge color/class if needed
          var badge = btn.closest('td')?.querySelector('.badge');
          if (badge && data.status_color) {
            badge.style.background = data.status_color + '1a';
            badge.style.color = data.status_color;
            badge.textContent = data.status_label;
          }
        } else {
          showToast(data.message || window.t('Gagal memperbarui'), 'error');
          btn.value = originalStatus;
        }
      })
      .catch(function () {
        showToast(window.t('Kesalahan jaringan'), 'error');
        btn.value = originalStatus;
      })
      .finally(function () {
        btn.disabled = false;
      });
    });
  });

  // ============================================================
  // Dark mode toggle (initialized early for command palette)
  // ============================================================
  var themeToggle = document.getElementById('theme-toggle');
  var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  var savedTheme = localStorage.getItem('admin-theme');
  var userThemePreference = document.querySelector('meta[name="user-theme-preference"]')?.getAttribute('content') || '';
  
  function applyTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
  }
  
  function saveThemeToDatabase(theme) {
    if (!authUser()) return;
    fetch('/admin/theme-preference', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken()
      },
      body: JSON.stringify({ theme: theme })
    }).catch(function () { /* silent fail */ });
  }
  
  function authUser() {
    return document.querySelector('meta[name="user-theme-preference"]') !== null;
  }
  
  // Initialize theme - priority: user preference (DB) > localStorage > system preference
  var initialTheme = userThemePreference || savedTheme || (prefersDark ? 'dark' : 'light');
  applyTheme(initialTheme);
  if (initialTheme === 'dark') {
    localStorage.setItem('admin-theme', 'dark');
  } else {
    localStorage.setItem('admin-theme', 'light');
  }
  
  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
      var newTheme = isDark ? 'light' : 'dark';
      applyTheme(newTheme);
      localStorage.setItem('admin-theme', newTheme);
      saveThemeToDatabase(newTheme);
      showToast(newTheme === 'dark' ? window.t('Mode gelap diaktifkan') : window.t('Mode terang diaktifkan'), 'info');
    });
  }
  
  // Keyboard shortcut: Ctrl+Shift+D
  document.addEventListener('keydown', function (e) {
    if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'D') {
      e.preventDefault();
      if (themeToggle) themeToggle.click();
    }
  });

  // ============================================================
  // Command Palette (Cmd/Ctrl + K)
  // ============================================================
  var palette = document.createElement('div');
  palette.className = 'cmd-palette';
  palette.setAttribute('role', 'dialog');
  palette.setAttribute('aria-modal', 'true');
  palette.innerHTML = `
    <input type="search" placeholder="' + window.t('Cari perintah... (Cmd/Ctrl+K)') + '" aria-label="Command palette">
    <div class="cmd-list"></div>
  `;
  document.body.appendChild(palette);

  var paletteInput = palette.querySelector('input');
  var paletteList = palette.querySelector('.cmd-list');

  var commands = [
    { label: 'Dashboard', desc: window.t('Lihat ringkasan'), icon: '▦', url: '/admin' },
    { label: 'Leads / Pesanan', desc: window.t('Kelola lead masuk'), icon: '✉', url: '/admin/leads' },
    { label: 'Tambah Layanan', desc: window.t('Buat layanan baru'), icon: '◈', url: '/admin/services/create' },
    { label: 'Tambah Portofolio', desc: window.t('Buat portofolio baru'), icon: '▣', url: '/admin/portfolios/create' },
    { label: 'Tambah Artikel', desc: window.t('Tulis blog post'), icon: '☰', url: '/admin/posts/create' },
    { label: 'Tambah Halaman', desc: window.t('Buat halaman statis'), icon: '▤', url: '/admin/pages/create' },
    { label: 'Pengaturan', desc: window.t('Konfigurasi website'), icon: '⚙', url: '/admin/settings' },
    { label: 'Pengguna', desc: window.t('Kelola tim'), icon: '♟', url: '/admin/users' },
    { label: 'Lihat Website', desc: window.t('Buka tampilan publik'), icon: '↗', url: '/', target: '_blank' },
    { label: window.t('Toggle Dark Mode'), desc: window.t('Ganti mode gelap/terang'), icon: '☾', url: '#', action: 'toggleTheme' },
  ];

  function renderPalette(filter) {
    var html = '';
    commands.forEach(function (cmd) {
      var match = !filter || 
        cmd.label.toLowerCase().includes(filter.toLowerCase()) ||
        cmd.desc.toLowerCase().includes(filter.toLowerCase());
      if (match) {
        if (cmd.action) {
          html += '<a class="cmd-item" href="#" data-action="' + cmd.action + '">' +
            '<span class="cmd-icon">' + cmd.icon + '</span>' +
            '<span class="cmd-label">' + cmd.label + '</span>' +
            '<span class="cmd-desc">' + cmd.desc + '</span>' +
          '</a>';
        } else {
          var target = cmd.target ? ' target="' + cmd.target + '"' : '';
          html += '<a class="cmd-item" href="' + cmd.url + '"' + target + '>' +
            '<span class="cmd-icon">' + cmd.icon + '</span>' +
            '<span class="cmd-label">' + cmd.label + '</span>' +
            '<span class="cmd-desc">' + cmd.desc + '</span>' +
          '</a>';
        }
      }
    });
    paletteList.innerHTML = html || '<div class="cmd-item" style="justify-content:center;color:var(--muted);">' + window.t('Tidak ditemukan') + '</div>';
  }

  function openPalette() {
    palette.classList.add('open');
    paletteInput.value = '';
    renderPalette('');
    setTimeout(function () { paletteInput.focus(); }, 50);
  }

  function closePalette() {
    palette.classList.remove('open');
  }

  document.addEventListener('keydown', function (e) {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
      e.preventDefault();
      if (palette.classList.contains('open')) closePalette();
      else openPalette();
    }
    if (e.key === 'Escape' && palette.classList.contains('open')) closePalette();
  });

  paletteInput.addEventListener('input', function () {
    renderPalette(this.value);
  });

  // Click handler for command palette items
  paletteList.addEventListener('click', function (e) {
    var item = e.target.closest('.cmd-item');
    if (!item) return;
    
    var action = item.getAttribute('data-action');
    if (action === 'toggleTheme') {
      e.preventDefault();
      if (themeToggle) themeToggle.click();
      closePalette();
    }
    // For regular links, let them navigate normally
  });

  // Click outside to close
  palette.addEventListener('click', function (e) {
    if (e.target === palette) closePalette();
  });

  // ============================================================
  // Keyboard shortcuts cheatsheet (press ?)
  // ============================================================
  var shortcutsModal = document.createElement('div');
  shortcutsModal.className = 'shortcuts-modal';
  shortcutsModal.setAttribute('role', 'dialog');
  shortcutsModal.setAttribute('aria-modal', 'true');
  shortcutsModal.innerHTML = `
    <div class="shortcuts-modal-content">
      <div class="shortcuts-modal-header">
        <h3>' + window.t('Keyboard Shortcuts') + '</h3>
        <button class="shortcuts-modal-close" aria-label="' + window.t('Tutup') + '">×</button>
      </div>
      <div class="shortcuts-modal-body">
        <table class="shortcuts-table">
          <thead>
            <tr>
              <th>' + window.t('Shortcut') + '</th>
              <th>' + window.t('Action') + '</th>
            </tr>
          </thead>
          <tbody>
            <tr><td><kbd>Cmd</kbd>+<kbd>K</kbd></td><td>' + window.t('Open Command Palette') + '</td></tr>
            <tr><td><kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>D</kbd></td><td>' + window.t('Toggle Dark Mode') + '</td></tr>
            <tr><td><kbd>?</kbd></td><td>' + window.t('Show This Help') + '</td></tr>
            <tr><td><kbd>Esc</kbd></td><td>' + window.t('Close Modal / Palette') + '</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  `;
  document.body.appendChild(shortcutsModal);
  
  var shortcutsModalClose = shortcutsModal.querySelector('.shortcuts-modal-close');
  
  function openShortcutsModal() {
    shortcutsModal.classList.add('open');
    shortcutsModalClose.focus();
  }
  
  function closeShortcutsModal() {
    shortcutsModal.classList.remove('open');
  }
  
  shortcutsModalClose.addEventListener('click', closeShortcutsModal);
  shortcutsModal.addEventListener('click', function (e) {
    if (e.target === shortcutsModal) closeShortcutsModal();
  });
  
  document.addEventListener('keydown', function (e) {
    // Press ? (Shift+/) to show shortcuts
    if (e.shiftKey && e.key === '/') {
      // Don't trigger if typing in an input
      var target = e.target;
      if (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.isContentEditable) return;
      e.preventDefault();
      if (shortcutsModal.classList.contains('open')) closeShortcutsModal();
      else openShortcutsModal();
    }
    if (e.key === 'Escape' && shortcutsModal.classList.contains('open')) closeShortcutsModal();
  });

  // ============================================================
  // Keyboard shortcuts hint (footer)
  // ============================================================
  var hint = document.createElement('div');
  hint.style.cssText = 'position:fixed;bottom:12px;right:12px;font-size:10px;color:var(--muted);pointer-events:none;z-index:50;';
  hint.textContent = window.t('Cmd/Ctrl+K: Command Palette') + ' | ' + window.t('Press ? for Help');
  document.body.appendChild(hint);
  setTimeout(function () { hint.style.opacity = '0'; hint.style.transition = 'opacity 1s'; }, 5000);
  setTimeout(function () { hint.remove(); }, 6000);

})();