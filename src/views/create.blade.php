@extends(config('laraticket.layout'))
@push('styles')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
	.note-editable {
		background-color: white;
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
<div class="p-4 text-sm md:p-8">
	<div class="flex flex-col">
		<h1 class="mb-8 text-3xl font-bold text-gray-700">@lang("Submit a Ticket")</h1>
		<div class="mb-8">
			@lang("Please enter the details of your request and we will respond as soon as possible. If you are reporting a bug or other in-site problem, please be sure to include all the steps leading up to the issue.")
		</div>
		<div>
			@include('laraticket::errors.form_error')
			<form role="form" action="{{ url('tickets/store') }}" method="POST">
				{{ csrf_field() }}
				<div class="mb-4">
					<div class="flex flex-wrap">
						<div class="md:w-1/2 md:pr-2">
							<label>@lang("Category")</label>
							<select class="block w-full form-select" name="category">
								<option value="">@lang("- Select a Category -")</option>
								@forelse($categories as $category)
								@if(trim($category) != "")
								<option>{{ $category }}</option>
								@endif
								@empty
								@endforelse
							</select>
						</div>
						<div class="md:w-1/2 md:pl-2">
							<label>@lang("Priority")</label>
							<select class="block w-full form-select" name="priority">
								<option value="">@lang("- Select a Priority -")</option>
								@forelse($priorities as $priority)
								@if(trim($priority) != "")
								<option>{{ $priority }}</option>
								@endif
								@empty
								@endforelse
							</select>
						</div>
					</div>
				</div>
				<div class="mb-4">
					<label>@lang("Enter a subject for your ticket")</label>
					<input type="text" name="title" class="block w-full form-input" max="255" value="{{ old('title') }}" placeholder="@lang("Subject of your Ticket")">
				</div>
				<div class="mb-4">
					<label>@lang("Description")</label>
					<textarea name="body" class="block w-full bg-white" placeholder="@lang("Describe your complaint in detail")" id="editor"></textarea>
				</div>
				<div class="mb-4">
					<button class="inline-block px-4 py-2 text-base font-normal leading-normal text-center no-underline whitespace-no-wrap align-middle bg-green-500 border rounded select-none text-green-50 hover:bg-green-400 pull-right" type="submit">@lang("Submit Ticket")</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
	$(document).ready(function(){
		$("#editor").summernote({
			placeholder: "Enter article content here",
			tabsize: 2,
			height: 300
		});
	})
</script>
@endpush
