import './bootstrap';
import flatpickr from 'flatpickr';

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
});
