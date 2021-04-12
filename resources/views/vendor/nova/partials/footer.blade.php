<p class="mt-8 text-center text-xs text-80">
    {{ config('app.name') }} v{{ config('app.version') }}
    <span class="px-1">&middot;</span>
    &copy; {{ date('Y') }} by <a href="https://webmapp.it" class="text-primary dim no-underline">WEBMAPP</a>
    <span class="px-1">&middot;</span>
    Nova v{{ Nova::version() }}
</p>
