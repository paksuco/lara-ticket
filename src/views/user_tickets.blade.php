@extends(config('laraticket.layout'))
@section(config('laraticket.layout_section'))
<div class="p-4 text-sm md:p-8">
    <div class="flex flex-col">
        <div class="flex items-baseline justify-between w-full">
			<h1 class="mb-8 text-3xl font-bold text-gray-700">@lang("Support Tickets")</h1>
			<a href="{{ url('tickets/create') }}" class="inline-block px-4 py-2 text-base font-normal leading-normal text-center text-blue-100 no-underline whitespace-no-wrap align-middle bg-blue-500 border border-blue-600 rounded select-none hover:bg-blue-600 hover:text-white"><i class="mr-2 fa fa-plus"></i>Create new ticket</a>
		</div>

        <ul class="flex flex-wrap w-full mb-4">
            <li role="presentation" class="-mb-px {{ is_null(Request::segment(2)) || Request::segment(2) == "open" ? 'active' : ''}}">
				<a href="{{ url('tickets/open') }}" class="flex items-center px-3 py-1 mr-2 text-white bg-indigo-600 border border-indigo-700 rounded-lg">
					Open <span class="ml-2 font-semibold">{{ $open_count }}</span>
				</a></li>
            <li role="presentation" class="-mb-px{{ Request::segment(2) == "closed" ? 'active' : ''}}">
				<a href="{{ url('tickets/closed') }}" class="flex items-center px-3 py-1 text-white bg-indigo-600 border border-indigo-700 rounded-lg">
					Closed <span class="ml-2 font-semibold">{{ $closed_count }}</span>
				</a>
			</li>
        </ul>
        <section>
            <div class="relative flex flex-col min-w-0 break-words bg-white border rounded border-1 border-grey-light">
                <div class="px-6 py-3 mb-0 bg-grey-lighter border-b-1 border-grey-light text-grey-darkest"><span class="h4">Tickets</span>

                </div>
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
                                    <td><a href="{{ url('tickets/show/'.$ticket->slug) }}">{{ $ticket->title }}</a></td>
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
</div>
@endsection
