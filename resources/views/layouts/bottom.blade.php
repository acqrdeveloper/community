@if(env("APP_ENV") == 'local')
    <script src="{{ asset('node_modules/requirejs/require.js') }}" data-main="{{ asset('main.js') }}"></script>
@else
    <script src="{{ asset('js/app.min.js').'?cache'.str_limit(time(),6,'') }}"></script>
@endif
<script src="{{ asset('js/app.js').'?cache'.str_limit(time(),6,'') }}"></script>