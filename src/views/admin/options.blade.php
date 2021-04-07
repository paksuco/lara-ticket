@extends(config('laraticket.admin_layout'))
@section(config('laraticket.admin_layout_section'))

    <div class="flex flex-wrap max-w-5xl">
        <form class="w-full px-4 pt-2" method="POST">
			@csrf
            <div class="flex flex-wrap mb-6 -mx-3">
                <h2 class="px-4 pt-3 pb-2 text-lg text-gray-800">@lang("Ticket Settings")</h2>
                <div class="w-full px-3 mt-2 mb-2 md:w-full">
                    <textarea class="w-full h-20 px-3 py-2 font-medium leading-normal placeholder-gray-700 bg-gray-100 border border-gray-400 rounded resize-none focus:outline-none focus:bg-white" name="body" placeholder='Type Your Comment' required></textarea>
                </div>
                <div class="flex items-start w-full px-3 md:w-full">
                    <div class="flex items-start w-1/2 px-2 mr-auto text-gray-700">
                        <svg fill="none" class="w-5 h-5 mr-1 text-gray-600" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="pt-px text-xs md:text-sm">Some HTML is okay.</p>
                    </div>
                    <div class="-mr-1">
                        <input type='submit' class="px-4 py-1 mr-1 font-medium tracking-wide text-gray-700 bg-white border border-gray-400 rounded-lg hover:bg-gray-100" value='Post Comment'>
                    </div>
                </div>
			</div>
        </form>
    </div>

@endsection
