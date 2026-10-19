@php($popup = \App\Models\PopupSetting::visible())
@if ($popup)
    {{-- Shown once per browser session for each image (a new image shows again). --}}
    <div
        x-data="{
            open: false,
            key: 'popup-{{ md5($popup->image_path) }}',
            init() {
                let seen = false;
                try { seen = !!sessionStorage.getItem(this.key) } catch (e) {}
                if (!seen) setTimeout(() => this.open = true, 800);
            },
            close() {
                this.open = false;
                try { sessionStorage.setItem(this.key, '1') } catch (e) {}
            },
        }"
        x-show="open"
        x-transition.opacity.duration.300ms
        x-on:keydown.escape.window="close()"
        x-on:click.self="close()"
        x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/75 p-4"
        role="dialog" aria-modal="true" aria-label="{{ $popup->alt_text ?: config('site.name') }}"
    >
        <div class="relative" x-show="open" x-transition.scale.90.duration.300ms>
            <button type="button" x-on:click="close()"
                class="absolute -right-3 -top-3 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white text-2xl leading-none text-brand-950 shadow-lg ring-1 ring-black/10 transition hover:scale-110"
                aria-label="{{ __('Close') }}">&times;</button>
            @if ($popup->link_url)
                <a href="{{ $popup->link_url }}" x-on:click="close()">
            @endif
            <img src="{{ $popup->imageUrl() }}" alt="{{ $popup->alt_text }}"
                class="block max-h-[88vh] w-auto max-w-[92vw] rounded-lg shadow-2xl">
            @if ($popup->link_url)
                </a>
            @endif
        </div>
    </div>
@endif
