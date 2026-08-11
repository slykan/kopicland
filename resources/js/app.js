import './bootstrap';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/l10n/hr.js';
import 'flatpickr/dist/l10n/de.js';

document.addEventListener('alpine:init', () => {
    Alpine.data('datePicker', (options = {}) => ({
        init() {
            flatpickr(this.$refs.input, {
                dateFormat: 'd.m.Y',
                allowInput: true,
                minDate: options.minDate ?? null,
                onChange: () => {
                    this.$refs.input.dispatchEvent(new Event('input', { bubbles: true }));
                },
            });
        },
    }));

    Alpine.data('availabilityCalendar', (options = {}) => ({
        init() {
            const turnoverDates = new Set(options.turnoverDates ?? []);

            flatpickr(this.$refs.calendar, {
                inline: true,
                minDate: 'today',
                disable: options.disabledRanges ?? [],
                locale: ['hr', 'de'].includes(options.locale) ? options.locale : 'default',
                showMonths: 1,
                onDayCreate: (dObj, dStr, fp, dayElem) => {
                    const iso = fp.formatDate(dayElem.dateObj, 'Y-m-d');

                    if (turnoverDates.has(iso)) {
                        dayElem.classList.add('flatpickr-day-turnover');
                        dayElem.title = options.turnoverLabel ?? '';
                    }
                },
            });
        },
    }));
});
