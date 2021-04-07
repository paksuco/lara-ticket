@extends(config('laraticket.admin_layout'))
@section(config('laraticket.admin_layout_section'))
<div class="container mx-auto">
	<section>
		<div class="relative flex flex-col min-w-0 break-words bg-white border rounded border-1 border-grey-light">
			<div class="px-6 py-3 mb-0 bg-grey-lighter border-b-1 border-grey-light text-grey-darkest">
				{{-- <span class="h4">{{ $ticket->title }}</span> --}}
				<div class="text-right">
					<a href="{{ url('/admin/tickets/create') }}" class="inline-block px-4 py-2 text-base font-normal leading-normal text-center no-underline whitespace-no-wrap align-middle border rounded select-none text-blue-lightest bg-blue hover:bg-blue-light">Create new ticket</a>
				</div>
			</div>
			<div class="flex-auto p-6">
				<div class="h3">
					<i class="fa fa-sticky-note"></i> {{ $ticket->title }}
				</div>
				<br>
				<div class="flex flex-wrap">
					<div class="pl-4 pr-4 sm:w-1/4">
						<strong>Ticket by: <span class="text-red">{{ $ticket->user_name }}</span></strong>
						<br>
						<strong>Status: <span class="text-red">{{ $ticket->status }}</span></strong>
						<br>
						<strong>Category: <span class="text-red">{{ $ticket->category }}</span></strong>
						<br>
						<strong>Priority: <span class="text-red">{{ $ticket->priority }}</span></strong>
						<br>
						<strong>Opened: <span class="text-red">{{ $ticket->created_at->diffForHumans() }}</span></strong>
					</div>
					<div class="pl-4 pr-4 sm:w-3/4">
						<div class="relative flex flex-col min-w-0 break-words bg-white border rounded border-1 border-grey-light">
							<div class="flex-auto p-6">
								<p><strong>Description</strong></p>
								{!! $ticket->body !!}
							</div>
						</div>
					</div>
				</div>
				<div style="margin-top: 15px; margin-bottom: 15px;">
					<p class="h4"><strong>Comments</strong></p>
					<div class="flex flex-col pl-0 mb-0 border rounded border-grey-light">
						@forelse($ticket->comments as $comment)
							<li class="relative block px-6 py-3 -mb-px no-underline border border-l-0 border-r-0 border-grey-light">{{ $comment->body }}
								<span class="pull-right">{{ $comment->created_at->diffForHumans() }}</span>
								<br>
								<span class="pull-right">
									<span class="text-green">{{ $comment->user->name }}</span>
								</span>
							</li>
						@empty
						@endforelse
					</div>
				</div>
				<div class="float-right">
					@if ($ticket->isOpen())
						<a class="inline-block px-4 py-2 text-base font-normal leading-normal text-center no-underline whitespace-no-wrap align-middle border rounded select-none text-teal-lightest bg-teal hover:bg-teal-light" href="{{ url('/admin/tickets/'.$ticket->id.'/update?action=absolute pin-t pin-b pin-r px-4 py-3') }}"><i class="fa fa-close"></i> Close</a>
						<button class="inline-block px-4 py-2 text-base font-normal leading-normal text-center no-underline whitespace-no-wrap align-middle border rounded select-none text-blue-lightest bg-blue hover:bg-blue-light" data-target="#reply-modal" data-toggle="modal">Reply</button>
					@elseif ($ticket->isClosed())
						<a class="inline-block px-4 py-2 text-base font-normal leading-normal text-center no-underline whitespace-no-wrap align-middle border rounded select-none text-yellow-lightest bg-yellow hover:bg-yellow-light" href="{{ url('/admin/tickets/'.$ticket->id.'/update?action=open') }}"><i class="fa fa-open"></i> Reopen</a>
					@endif
				</div>
			</div>
			<div class="px-6 py-3 bg-grey-lighter border-t-1 border-grey-light">
				<form action="{{ url('/admin/tickets/'.$ticket->id) }}" method="POST">
					{{ method_field('DELETE')}}
					{{ csrf_field() }}
					<button class="inline-block px-4 py-2 text-base font-normal leading-normal text-center no-underline whitespace-no-wrap align-middle border rounded select-none text-red-lightest bg-red hover:bg-red-light"><i class="fa fa-trash"></i> Delete</button>
				</form>
			</div>
		</div>
	</section>
</div>
<div id="reply-modal" class="opacity-0 modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Reply ticket
			</div>
			<div class="modal-body">
				<form method="POST" action="{{ url('/admin/tickets/comments/store/'.$ticket->id) }}">
					{{ csrf_field() }}
					<div class="mb-4">
						<textarea class="block w-full px-2 py-1 mb-1 text-base leading-normal bg-white border rounded appearance-none text-grey-darker border-grey" name="content" placeholder="Enter your comment here"></textarea>
					</div>
					<div class="mb-4">
						<button class="inline-block px-4 py-2 text-base font-normal leading-normal text-center no-underline whitespace-no-wrap align-middle border rounded select-none text-yellow-lightest bg-yellow hover:bg-yellow-light">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
