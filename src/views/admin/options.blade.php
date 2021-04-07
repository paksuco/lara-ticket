@extends(config('laraticket.admin_layout'))
@section(config('laraticket.admin_layout_section'))

<div class="flex flex-wrap p-8">
    <div class="items-end w-full">
        <h2 class="mb-3 text-3xl font-semibold" style="line-height: 1em">@lang("Support Ticket Settings")</h2>
        <p class="mb-8 text-sm leading-5 text-cool-gray-600">@lang("This page contains the available settings for the support tickets platform, you can add priorities and categories for the support tickets.")</p>
    </div>
    <div class="w-full md:w-2/3">
        <form class="w-full" method="POST">
            @csrf
            <div class="flex flex-col flex-wrap p-6 mb-4 bg-white rounded">
                <h2 class="text-xl font-semibold text-gray-800">@lang("Ticket Categories")</h2>
                <p class="mb-3 text-base">@lang("Write one category per line in the textbox below:")</p>
                <textarea class="w-full px-3 py-2 border rounded placeholder-cool-gray-400 bg-cool-gray-100 border-cool-gray-400 focus:outline-none" name="categories" rows="8" required>{{$categories}}</textarea>
            </div>
            <div class="flex flex-col flex-wrap p-6 bg-white rounded">
                <h2 class="text-xl font-semibold text-cool-gray-800">@lang("Ticket Priorities")</h2>
                <p class="mb-3 text-base">@lang("Write one priority per line in the textbox below (High, Medium, Low, etc.):")</p>
                <textarea class="w-full px-3 py-2 border rounded placeholder-cool-gray-400 bg-cool-gray-100 border-cool-gray-400 focus:outline-none" name="priorities" rows="8" required>{{$priorities}}</textarea>
            </div>
            <div class="py-2 mt-4 text-right">
                <button class="px-4 py-3 font-semibold text-white bg-blue-600 rounded hover:text-white hover:bg-blue-700 pull-right" type="submit">@lang("Save Changes")</button>
            </div>
        </form>
    </div>
</div>
@endsection
