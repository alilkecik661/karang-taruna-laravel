@php
  $waNumber = preg_replace('/[^0-9]/', '', (string) ($pengaturanGlobal['whatsapp'] ?? '6281234567890'));
  if (str_starts_with($waNumber, '0')) {
      $waNumber = '62' . substr($waNumber, 1);
  }
@endphp
<a class="wa-float" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
  <svg width="28" height="28" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm0 2a8 8 0 1 1-4.1 14.9l-.3-.2-2.9.8.8-2.8-.2-.3A8 8 0 0 1 12 4z"/></svg>
</a>
