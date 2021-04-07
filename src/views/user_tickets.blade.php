@extends(config('laraticket.layout'))
@section(config('laraticket.layout_section'))
<div class="p-4 text-sm md:p-8">
    <div class="flex flex-col">
        <div class="flex items-center justify-between w-full mb-8">
            <h1 class="text-3xl font-bold leading-4 text-gray-700">@lang("Support Tickets")</h1>
            <a href="{{ url('tickets/create') }}" class="px-3 py-2 font-semibold text-white bg-blue-600 rounded hover:text-white hover:bg-blue-700">
                <i class="mr-2 fa fa-plus"></i>@lang("Create Support Ticket")
            </a>
        </div>
        <div class="p-8 bg-white rounded">
            <ul class="flex flex-wrap w-full mb-4 text-sm">
                <li>
                    <a href="{{ url('tickets/open') }}" class="px-3 py-1 mr-2 text-black bg-gray-200 rounded {{ Request::segment(2) == "open" || Request::segment(2) == "" ? 'bg-yellow-300' : ''}}">
                        @lang("Open Tickets") <span class="ml-2 font-semibold">{{ $open_count }}</span>
                    </a></li>
                <li>
                    <a href="{{ url('tickets/closed') }}" class="px-3 py-1 text-black bg-gray-200 rounded {{ Request::segment(2) == "closed" ? 'bg-yellow-300' : ''}}">
                        @lang("Closed Tickets") <span class="ml-2 font-semibold">{{ $closed_count }}</span>
                    </a>
                </li>
            </ul>
            <section>
                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="table w-full text-sm">
                        <thead class="hidden md:table-header-group">
                            <tr>
                                <th class="relative top-0 px-3 py-2 text-left bg-cool-gray-200">Subject</th>
                                <th class="relative top-0 px-3 py-2 text-left bg-cool-gray-200">Status</th>
                                <th class="relative top-0 px-3 py-2 text-left bg-cool-gray-200">Created</th>
                                <th class="relative top-0 px-3 py-2 text-left bg-cool-gray-200">Last updated</th>
                                <th class="relative top-0 px-3 py-2 text-left bg-cool-gray-200">Priority</th>
                                <th class="relative top-0 px-3 py-2 text-left bg-cool-gray-200">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                            <tr class="@if($loop->even) bg-cool-gray-100 @else bg-cool-gray-50 @endif">
                                <td class="px-3 py-2"><a href="{{ url('tickets/show/'.$ticket->slug) }}">{{ $ticket->title }}</a></td>
                                <td class="px-3 py-2">{{ $ticket->status }}</td>
                                <td class="px-3 py-2">{{ $ticket->created_at->diffForHumans() }}</td>
                                <td class="px-3 py-2">{{ $ticket->updated_at->diffForHumans() }}</td>
                                <td class="px-3 py-2">{{ $ticket->priority }}</td>
                                <td class="px-3 py-2">{{ $ticket->category }}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $tickets->links() }}
            </section>
        </div>
    </div>
</div>
@endsection
