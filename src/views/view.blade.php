@extends(config('laraticket.layout'))
@push('styles')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editable {
        background-color: white;
    }

    .note-toolbar,
    .note-statusbar {
        background: transparent !important;
    }

    .note-editor {
        border: 0px !important;
    }

    .note-modal {
        z-index: 1000001;
    }

    .note-modal-backdrop {
        z-index: 1000000;
    }

    .note-modal-footer {
        height: 50px;
    }

    .note-btn-primary {
        background: #42389d !important;
        color: white !important;
        border: 1px solid #42389d !important;
    }

</style>
@endpush
@section(config('laraticket.layout_section'))
<div class="p-4 text-sm md:p-12">
    <div class="flex flex-col">
        <div class="flex items-center justify-between w-full mb-8">
            <a href="{{ url('tickets') }}" class="px-3 py-1 mr-3 font-semibold text-white bg-blue-600 rounded hover:text-white hover:bg-blue-700"><i class="fa fa-chevron-left"></i></a>
            <h1 class="text-3xl font-bold leading-4 text-gray-700">@lang("Support Tickets")</h1>
            <div class="flex-1 text-right">
            <a href="{{ url('tickets/create') }}" class="px-3 py-2 font-semibold text-white bg-blue-600 rounded hover:text-white hover:bg-blue-700">
                <i class="mr-2 fa fa-plus"></i>@lang("Create Support Ticket")
            </a>
        </div>
        </div>
        <div class="p-0 rounded">
            <div class="flex-auto mb-2">
                <div class="flex flex-wrap p-0 mb-8 overflow-hidden rounded-lg">
                    <div class="flex-1 p-8 pb-6 bg-cool-gray-50">
                        <div class="relative flex flex-col min-w-0 break-words bg-white text-cool-gray-800">
                            <div class="flex-auto mb-8 text-sm leading-5">
                                <div class="mb-4 text-2xl font-semibold text-indigo-700">{{ $ticket->title }}</div>
                                {!! $ticket->body !!}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col p-4 whitespace-no-wrap text-cool-gray-800 sm:w-auto bg-cool-gray-200">
                        <div class="flex flex-col flex-1">
                            <div class="flex flex-col">
                                <div class='w-20 font-bold'>Ticket by:</div>
                                <div class="font-light">{{ $ticket->user_name }}</div>
                            </div>
                            <div class="flex flex-col">
                                <div class='w-20 font-bold'>Status:</div>
                                <div class="font-light">{{ $ticket->status }}</div>
                            </div>
                            <div class="flex flex-col">
                                <div class='w-20 font-bold'>Category:</div>
                                <div class="font-light">{{ $ticket->category }}</div>
                            </div>
                            <div class="flex flex-col">
                                <div class='w-20 font-bold'>Priority:</div>
                                <div class="font-light">{{ $ticket->priority }}</div>
                            </div>
                            <div class="flex flex-col">
                                <div class='w-20 font-bold'>Opened:</div>
                                <div class="font-light">{{ $ticket->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="flex items-end justify-end flex-1">
                                <form action="{{ url('tickets/'.$ticket->id) }}" method="POST">
                                    {{ method_field('DELETE')}}
                                    {{ csrf_field() }}
                                    <button class="inline-block px-4 py-1 text-base font-normal leading-normal text-white bg-red-700 rounded shadow">@lang("Delete Ticket")</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-auto py-2 mb-4">
                <div class="flex items-center px-4 mb-3 text-xl font-bold leading-4 text-cool-gray-800">
                    <i class="mr-2 fa fa-comment"></i> @lang("Comments")
                </div>
                <div class="flex flex-wrap mb-4 rounded">
                    @forelse($ticket->comments as $comment)
                    <div class="relative block w-full p-6 mb-4 bg-white rounded-lg">
                        <span class="font-bold @if(Auth::id() == $comment->user->id) text-green-600 @endif">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        <p class="text-sm">
                            {!! $comment->body !!}
                        </p>
                    </div>
                    @empty
                    <div class="relative block w-full p-6 mb-4 bg-white rounded-lg">
                    No comments yet.
                    </div>
                    @endforelse

                    <form method="POST" class="w-full p-4 rounded-lg bg-cool-gray-200" action="{{ url('tickets/comments/store/'.$ticket->id) }}">
                        {{ csrf_field() }}
                        <textarea id="editor" class="block w-full px-2 py-1 text-base leading-normal text-gray-700 bg-white border border-gray-100 rounded appearance-none" name="content" placeholder="Enter your comment here"></textarea>
                        <div class="mt-4 text-right">
                            @if ($ticket->isOpen())
                            <a class="inline-block px-4 py-1 text-base font-normal leading-normal text-white bg-red-700 rounded" href="{{ url('tickets/'.$ticket->id.'/update?action=close') }}"><i class="fa fa-close"></i> @lang("Close Ticket")</a>
                            @elseif ($ticket->isClosed())
                            <a class="inline-block px-4 py-1 text-base font-normal leading-normal text-white bg-green-700 rounded" href="{{ url('tickets/'.$ticket->id.'/update?action=open') }}"><i class="fa fa-open"></i> @lang("Reopen Ticket")</a>
                            @endif
                            <button class="inline-block px-4 py-1 text-base font-normal leading-normal text-white bg-indigo-700 rounded" type="submit">@lang("Submit")</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $("#editor").summernote({
            placeholder: "@lang('Enter article content here')"
            , tabsize: 2
            , height: 150
        });
    })

</script>
@endpush
