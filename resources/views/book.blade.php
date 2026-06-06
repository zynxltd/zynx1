@extends('layouts.site')

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => 'Book a Consultation — Zynx',
    'description' => $description,
    'url' => route('book'),
    'potentialAction' => [
        '@type' => 'ReserveAction',
        'target' => route('book'),
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
    <div class="page-head">
        <span class="section-label">// consultation</span>
        <h1>Book a consultation</h1>
        <p>Pick a date and time for a free 30-minute call. We'll discuss your goals and how we can help with software, data, AI or automation.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error" role="alert">
            <strong>Please fix the following:</strong>
            <ul style="margin:0.5rem 0 0;padding-left:1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('book.store') }}" id="booking-form" novalidate>
        @csrf
        <input type="hidden" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}" />

        <div class="booking-layout">
            <div class="card slots-panel @error('scheduled_at') is-invalid @enderror" id="slots-panel">
                <div class="calendar-nav">
                    <button type="button" id="cal-prev" aria-label="Previous month">&larr;</button>
                    <h2 id="cal-month"></h2>
                    <button type="button" id="cal-next" aria-label="Next month">&rarr;</button>
                </div>
                <div class="calendar-grid" id="cal-dows"></div>
                <div class="calendar-grid" id="cal-days"></div>

                <p style="margin:1.25rem 0 0;font-size:0.88rem;color:var(--muted);">Available times (UK) *</p>
                <div class="slots" id="slots" role="listbox" aria-label="Available time slots">
                    <span class="slots-empty">Select a date to see available times</span>
                </div>
                @error('scheduled_at')<p class="field-error" id="error-scheduled_at">{{ $message }}</p>@enderror
                <p class="field-error" id="error-scheduled_at-js" hidden></p>
            </div>

            <div class="card">
                <div class="form-grid">
                    <div class="field @error('name') is-invalid @enderror" data-field="name">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required minlength="2" maxlength="120" autocomplete="name" />
                        @error('name')<p class="field-error">{{ $message }}</p>@enderror
                        <p class="field-error" data-error-for="name" hidden></p>
                    </div>
                    <div class="field @error('email') is-invalid @enderror" data-field="email">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" inputmode="email" />
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                        <p class="field-error" data-error-for="email" hidden></p>
                    </div>
                    <div class="form-grid two">
                        <div class="field @error('company') is-invalid @enderror" data-field="company">
                            <label for="company">Company</label>
                            <input type="text" id="company" name="company" value="{{ old('company') }}" maxlength="120" autocomplete="organization" />
                            @error('company')<p class="field-error">{{ $message }}</p>@enderror
                            <p class="field-error" data-error-for="company" hidden></p>
                        </div>
                        <div class="field @error('phone') is-invalid @enderror" data-field="phone">
                            <label for="phone">Phone *</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required maxlength="20" autocomplete="tel" inputmode="tel" placeholder="+447123456789" />
                            @error('phone')<p class="field-error">{{ $message }}</p>@enderror
                            <p class="field-error" data-error-for="phone" hidden></p>
                        </div>
                    </div>
                    <div class="field @error('message') is-invalid @enderror" data-field="message">
                        <label for="message">What would you like to discuss? *</label>
                        <textarea id="message" name="message" rows="4" required minlength="10" maxlength="2000">{{ old('message') }}</textarea>
                        @error('message')<p class="field-error">{{ $message }}</p>@enderror
                        <p class="field-error" data-error-for="message" hidden></p>
                    </div>
                    <button type="submit" class="button button-primary" id="submit-btn" disabled>
                        Confirm booking
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    const slotsUrl = @json(route('book.slots'));
    const maxDays = {{ config('booking.advance_days') }};
    const workDays = @json(config('booking.working_days'));

    const form = document.getElementById('booking-form');
    const monthEl = document.getElementById('cal-month');
    const dowsEl = document.getElementById('cal-dows');
    const daysEl = document.getElementById('cal-days');
    const slotsEl = document.getElementById('slots');
    const slotsPanel = document.getElementById('slots-panel');
    const scheduledInput = document.getElementById('scheduled_at');
    const submitBtn = document.getElementById('submit-btn');
    const slotErrorEl = document.getElementById('error-scheduled_at-js');

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const messageInput = document.getElementById('message');

    const namePattern = /^[\p{L}\s'\-.]+$/u;
    const phonePattern = /^\+?[0-9][0-9\s\-().]{6,18}[0-9]$/;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    const validators = {
        name(value) {
            const v = value.trim();
            if (!v) return 'Please enter your name.';
            if (v.length < 2) return 'Name must be at least 2 characters.';
            if (!namePattern.test(v)) return 'Name can only contain letters, spaces, hyphens and apostrophes.';
            return '';
        },
        email(value) {
            const v = value.trim();
            if (!v) return 'Please enter your email address.';
            if (!emailPattern.test(v)) return 'Please enter a valid email address.';
            return '';
        },
        phone(value) {
            const v = value.trim();
            if (!v) return 'Please enter a phone number so we can reach you.';
            if (!phonePattern.test(v)) return 'Please enter a valid phone number (e.g. +447123456789).';
            return '';
        },
        message(value) {
            const v = value.trim();
            if (!v) return 'Please tell us what you would like to discuss.';
            if (v.length < 10) return 'Please provide at least 10 characters about what you would like to discuss.';
            return '';
        },
        scheduled_at() {
            if (!scheduledInput.value) return 'Please select a date and time for your consultation.';
            return '';
        },
    };

    function showFieldError(field, message) {
        const wrapper = document.querySelector(`[data-field="${field}"]`);
        const errorEl = wrapper?.querySelector(`[data-error-for="${field}"]`);
        if (!wrapper || !errorEl) return;
        if (message) {
            wrapper.classList.add('is-invalid');
            errorEl.textContent = message;
            errorEl.hidden = false;
        } else {
            wrapper.classList.remove('is-invalid');
            errorEl.textContent = '';
            errorEl.hidden = true;
        }
    }

    function showSlotError(message) {
        if (message) {
            slotsPanel.classList.add('is-invalid');
            slotErrorEl.textContent = message;
            slotErrorEl.hidden = false;
        } else {
            slotsPanel.classList.remove('is-invalid');
            slotErrorEl.textContent = '';
            slotErrorEl.hidden = true;
        }
    }

    function validateField(field) {
        const input = document.getElementById(field);
        if (!input) return true;
        const message = validators[field](input.value);
        showFieldError(field, message);
        return !message;
    }

    function validateSlot() {
        const message = validators.scheduled_at();
        showSlotError(message);
        return !message;
    }

    function formIsValid() {
        return ['name', 'email', 'phone', 'message'].every(validateField) && validateSlot();
    }

    function updateSubmitState() {
        submitBtn.disabled = !formIsValid();
    }

    ['name', 'email', 'phone', 'message'].forEach(field => {
        const input = document.getElementById(field);
        input.addEventListener('input', () => {
            if (input.closest('.is-invalid') || input.value.trim()) {
                validateField(field);
            }
            updateSubmitState();
        });
        input.addEventListener('blur', () => {
            validateField(field);
            updateSubmitState();
        });
    });

    form.addEventListener('submit', (e) => {
        const valid = formIsValid();
        if (!valid) {
            e.preventDefault();
            ['name', 'email', 'phone', 'message'].forEach(validateField);
            validateSlot();
            const firstInvalid = form.querySelector('.is-invalid input, .is-invalid textarea') || slotsPanel;
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    const dows = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    dowsEl.innerHTML = dows.map(d => `<span class="cal-dow">${d}</span>`).join('');

    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const maxDate = new Date(today);
    maxDate.setDate(maxDate.getDate() + maxDays);

    let viewYear = today.getFullYear();
    let viewMonth = today.getMonth();
    let selectedDate = null;
    let selectedSlot = scheduledInput.value || null;

    document.getElementById('cal-prev').addEventListener('click', () => {
        viewMonth--;
        if (viewMonth < 0) { viewMonth = 11; viewYear--; }
        renderCalendar();
    });
    document.getElementById('cal-next').addEventListener('click', () => {
        viewMonth++;
        if (viewMonth > 11) { viewMonth = 0; viewYear++; }
        renderCalendar();
    });

    function fmtDate(d) {
        return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
    }

    function isBookable(d) {
        const dow = d.getDay();
        const iso = dow === 0 ? 7 : dow;
        if (!workDays.includes(iso)) return false;
        if (d < today || d > maxDate) return false;
        return true;
    }

    function renderCalendar() {
        const first = new Date(viewYear, viewMonth, 1);
        const last = new Date(viewYear, viewMonth + 1, 0);
        monthEl.textContent = first.toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });

        let startPad = first.getDay() - 1;
        if (startPad < 0) startPad = 6;

        let html = '';
        for (let i = 0; i < startPad; i++) html += '<span class="cal-day empty"></span>';

        for (let day = 1; day <= last.getDate(); day++) {
            const d = new Date(viewYear, viewMonth, day);
            const dateStr = fmtDate(d);
            const bookable = isBookable(d);
            const selected = selectedDate === dateStr;
            html += `<button type="button" class="cal-day${selected ? ' selected' : ''}" data-date="${dateStr}" ${bookable ? '' : 'disabled'}>${day}</button>`;
        }
        daysEl.innerHTML = html;

        daysEl.querySelectorAll('.cal-day[data-date]').forEach(btn => {
            btn.addEventListener('click', () => selectDate(btn.dataset.date));
        });
    }

    async function selectDate(dateStr) {
        selectedDate = dateStr;
        selectedSlot = null;
        scheduledInput.value = '';
        showSlotError('');
        updateSubmitState();
        renderCalendar();
        slotsEl.innerHTML = '<span class="slots-empty">Loading…</span>';

        try {
            const res = await fetch(`${slotsUrl}?date=${dateStr}`);
            const data = await res.json();
            if (!data.bookable || !data.slots.length) {
                slotsEl.innerHTML = '<span class="slots-empty">No times available on this date</span>';
                return;
            }
            slotsEl.innerHTML = data.slots.map(s =>
                `<button type="button" class="slot-btn" data-slot="${s.datetime}">${s.label}</button>`
            ).join('');
            slotsEl.querySelectorAll('.slot-btn').forEach(btn => {
                btn.addEventListener('click', () => selectSlot(btn.dataset.slot));
            });
            if (selectedSlot) selectSlot(selectedSlot);
        } catch {
            slotsEl.innerHTML = '<span class="slots-empty">Could not load times. Please try again.</span>';
        }
    }

    function selectSlot(iso) {
        selectedSlot = iso;
        scheduledInput.value = iso;
        showSlotError('');
        slotsEl.querySelectorAll('.slot-btn').forEach(btn => {
            btn.classList.toggle('selected', btn.dataset.slot === iso);
        });
        updateSubmitState();
    }

    renderCalendar();
    if (scheduledInput.value) {
        const d = new Date(scheduledInput.value);
        selectedDate = fmtDate(d);
        viewYear = d.getFullYear();
        viewMonth = d.getMonth();
        renderCalendar();
        selectDate(selectedDate).then(() => selectSlot(scheduledInput.value));
    }

    updateSubmitState();
})();
</script>
@endpush
