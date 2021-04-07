@if ($errors->any())
    <div class="relative px-4 py-4 mx-2 mb-4 text-sm text-red-800 bg-red-200 border border-red-700 rounded">
        <p class="pl-1 pr-5 mb-2">@lang("Oops, there was a problem, please check your input and submit the form again.")</p>
        <ul class="ml-3">
            @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
