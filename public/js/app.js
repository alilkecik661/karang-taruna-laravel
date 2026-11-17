document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.nav-toggle');
  const menu = document.getElementById('menu');

  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      const open = menu.classList.toggle('open');
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
    });

    menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
      menu.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Buka menu');
    }));
  }

  const isEmail = v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
  const rules = {
    nama_lengkap: v => v.trim().length >= 3 || 'Isi nama lengkap minimal 3 karakter.',
    tanggal_lahir: v => !!v || 'Pilih tanggal lahir.',
    jenis_kelamin: v => !!v || 'Pilih jenis kelamin.',
    no_whatsapp: v => /^(08|\+?62)\d{8,13}$/.test(v.replace(/[\s-]/g, '')) || 'Nomor WhatsApp tidak valid.',
    alamat: v => v.trim().length >= 10 || 'Isi alamat lengkap minimal 10 karakter.',
    email: v => !v || isEmail(v) || 'Format email tidak valid.',
    nama: v => v.trim().length >= 3 || 'Isi nama Anda minimal 3 karakter.',
    isi: v => v.trim().length >= 10 || 'Tulis pesan minimal 10 karakter.'
  };

  function check(input) {
    const wrap = input.closest('.field');
    if (!wrap) return true;
    const msg = wrap.querySelector('.error');
    const rule = rules[input.name];
    if (!rule) return true;

    if (input.name === 'email' && input.required && !input.value.trim()) {
      wrap.classList.add('invalid');
      input.setAttribute('aria-invalid', 'true');
      if (msg) msg.textContent = 'Alamat email wajib diisi.';
      return false;
    }

    const result = rule(input.value);
    const ok = result === true;
    wrap.classList.toggle('invalid', !ok);
    input.setAttribute('aria-invalid', String(!ok));
    if (msg) msg.textContent = ok ? '' : result;
    return ok;
  }

  document.querySelectorAll('form[data-validate="true"]').forEach(form => {
    const fields = [...form.querySelectorAll('input[name], select[name], textarea[name]')]
      .filter(f => f.name !== 'website' && f.name !== '_token');

    fields.forEach(f => f.addEventListener('blur', () => check(f)));

    form.addEventListener('submit', e => {
      let firstBad = null;
      fields.forEach(f => {
        if (!check(f) && !firstBad) firstBad = f;
      });

      if (firstBad) {
        e.preventDefault();
        firstBad.focus();
        return;
      }

      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
      }
    });
  });

  // Lightbox Galeri
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const lightboxCaption = document.getElementById('lightbox-caption');
  const lightboxClose = document.getElementById('lightbox-close');

  if (lightbox && lightboxImg) {
    document.querySelectorAll('[data-lightbox-src]').forEach(item => {
      item.addEventListener('click', () => {
        const src = item.getAttribute('data-lightbox-src');
        const cap = item.getAttribute('data-lightbox-caption') || '';
        lightboxImg.src = src;
        lightboxImg.alt = cap;
        if (lightboxCaption) lightboxCaption.textContent = cap;
        lightbox.classList.add('open');
        lightbox.setAttribute('aria-hidden', 'false');
      });
    });

    const closeBox = () => {
      lightbox.classList.remove('open');
      lightbox.setAttribute('aria-hidden', 'true');
      lightboxImg.src = '';
    };

    if (lightboxClose) lightboxClose.addEventListener('click', closeBox);
    lightbox.addEventListener('click', e => {
      if (e.target === lightbox) closeBox();
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && lightbox.classList.contains('open')) closeBox();
    });
  }
});
