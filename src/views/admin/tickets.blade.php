@extends(config('laraticket.admin_layout'))
@section(config('laraticket.admin_layout_section'))
<div class="container mx-auto">
    <ul class="flex flex-wrap pl-0 mb-0 border border-t-0 border-l-0 border-r-0 list-reset border-b-1 border-grey-light">
        <li role="presentation" class="-mb-px {{ is_null(Request::segment(2)) || Request::segment(2) == "open" ? 'active' : ''}}">
            <a href="{{ url('admin/tickets/open') }}" class="inline-block px-4 py-2 mx-1 no-underline border border-b-0 rounded rounded-t">
                Open <span class="inline-block p-1 text-sm font-semibold leading-none text-center align-baseline rounded text-grey-darker bg-grey-light">{{ $open_count }}</span>
            </a>
        </li>
        <li role="presentation" class="-mb-px{{ Request::segment(2) == "closed" ? 'active' : ''}}">
			<a href="{{ url('admin/tickets/closed') }}" class="inline-block px-4 py-2 mx-1 no-underline border border-b-0 rounded rounded-t">
				Closed <span class="inline-block p-1 text-sm font-semibold leading-none text-center align-baseline rounded text-grey-darker bg-grey-light">{{ $closed_count }}</span>
			</a>
		</li>
    </ul>
    <section>
        <div class="relative flex flex-col min-w-0 break-words bg-white border rounded border-1 border-grey-light">
            <div class="px-6 py-3 mb-0 bg-grey-lighter border-b-1 border-grey-light text-grey-darkest"><span class="h4">Tickets</span></div>
            <div class="flex-auto p-6">
                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent table-striped">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Last updated</th>
                                <th>Priority</th>
                                <th>Owner</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                            <tr>
                                <td><a href="{{ url('admin/tickets/show/'.$ticket->slug) }}">{{ $ticket->title }}</a></td>
                                <td>{{ $ticket->status }}</td>
                                <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                <td>{{ $ticket->priority }}</td>
                                <td>{{ $ticket->user_name }}</td>
                                <td>{{ $ticket->category }}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $tickets->links() }}
            </div>
        </div>
    </section>
</div>
@endsection
