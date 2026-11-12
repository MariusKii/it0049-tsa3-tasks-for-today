@props(['name', 'size' => 20])
<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" {{ $attributes }}>
@switch($name)
@case('dashboard') <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/> @break
@case('tasks') <rect x="4" y="3" width="16" height="18" rx="3"/><path d="m8 9 1 1 2-2m3 1h3M8 15h3m3 0h3"/> @break
@case('user') <circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/> @break
@case('info') <circle cx="12" cy="12" r="9"/><path d="M12 11v6m0-10v.1"/> @break
@case('calendar') <rect x="3" y="5" width="18" height="16" rx="3"/><path d="M16 3v4M8 3v4M3 11h18m-13 5h.01m4 0h.01m4 0h.01"/> @break
@case('check') <path d="m5 12 4 4L19 6"/> @break
@case('clock') <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/> @break
@case('arrow') <path d="M4 12h16m-6-6 6 6-6 6"/> @break
@case('spark') <path d="m12 3 2.5 6.5L21 12l-6.5 2.5L12 21l-2.5-6.5L3 12l6.5-2.5Z"/> @break
@case('code') <path d="m8 6-6 6 6 6m8-12 6 6-6 6m-3-15-2 18"/> @break
@case('mail') <rect x="3" y="5" width="18" height="14" rx="3"/><path d="m3 6 9 7 9-7"/> @break
@default <circle cx="12" cy="12" r="8"/>
@endswitch
</svg>
