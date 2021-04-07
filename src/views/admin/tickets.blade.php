@extends(config('laraticket.admin_layout'))
@section(config('laraticket.admin_layout_section'))
<div class="container min-h-screen p-8 border-t">
    <div class="items-end w-full">
        <div class="flex items-center mb-3">
            <div class="w-full">
                <h2 class="text-3xl font-semibold" style="line-height: 1em">@lang("Support Tickets")</h2>
            </div>
        </div>
        <p class="mb-4 text-sm font-light leading-5 text-gray-600">@lang("This page contains the support tickets from our users.")</p>
        <div class="p-8 bg-white rounded">
            <ul class="flex flex-wrap w-full mb-4 text-sm">
                <li>
                    <a href="{{ url('/admin/tickets/open') }}" class="px-3 py-1 mr-2 text-black bg-gray-200 rounded {{ Request::segment(3) == "open" || Request::segment(3) == "" ? 'bg-yellow-300' : ''}}">
                        @lang("Open Tickets") <span class="ml-2 font-semibold">{{ $open_count }}</span>
                    </a></li>
                <li>
                    <a href="{{ url('/admin/tickets/closed') }}" class="px-3 py-1 text-black bg-gray-200 rounded {{ Request::segment(3) == "closed" ? 'bg-yellow-300' : ''}}">
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
                                <td class="px-3 py-2"><a href="{{ url('/admin/tickets/show/'.$ticket->slug) }}">{{ $ticket->title }}</a></td>
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
