@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6 lg:p-12">
        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Submission -->
        <form action="{{ route('ticket.store') }}" method="POST" enctype="multipart/form-data" id="ticketForm">
            @csrf
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Trace ID Field -->
                <div>
                    <label for="trace_id" class="block text-sm font-semibold text-gray-700">Trace ID Number</label>
                    <input type="text" id="trace_id" name="trace_id"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required>
                </div>

                <!-- Provider Name Field -->
                <div>
                    <label for="provider_name" class="block text-sm font-semibold text-gray-700">Provider Name</label>
                    <select id="provider_name" name="provider_name"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 overflow-auto"
                        required>
                        <option value="" disabled selected>Select a provider</option>
                        @foreach ($providers as $provider)
                            <option value="{{ $provider->name }}">{{ $provider->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                

                <!-- Issue Category Field -->
                <div>
                    <label for="issue_category" class="block text-sm font-semibold text-gray-700">Issue Category</label>
                    <select id="issue_category" name="issue_category"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                    required onchange="toggleNewCategoryField()">
                <option value="" disabled selected>Select an issue category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
                <option value="others">Other</option>
            </select>
                    <input type="text" id="new_category" name="new_category"
                        class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 hidden"
                        placeholder="Enter new category">
                </div>

                <!-- Issue Description Field -->
                <div class="col-span-1 md:col-span-2">
                    <label for="issue_description" class="block text-sm font-semibold text-gray-700">Issue Description</label>
                    <textarea id="issue_description" name="issue_description" rows="4"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required></textarea>
                </div>

                <!-- Assign To Field -->
                @php
                    $user = auth()->user();
                @endphp
                
                @if($user && ($user->role == 'admin' || $user->role == 'moderator'))
                <div>
                    <label for="assigned_to" class="block text-sm font-semibold text-gray-700">Assign To</label>
                    <select id="assigned_to" name="assigned_to"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required>
                        <option value="" disabled selected>Select a team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->name }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Priority Field -->
                {{-- <div>
                    <label for="priority" class="block text-sm font-semibold text-gray-700">Priority</label>
                    <select id="priority" name="priority"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required>
                        <option value="" disabled selected>Select priority</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>  --}}

                <div>
                    <label for="environment" class="block text-sm font-semibold text-gray-700">Environment</label>
                    <select id="environment" name="environment"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required>
                        <option value="" selected>Select environment</option>
                        <option value="Staging">Staging</option>
                        <option value="Pre-production">Pre-production</option>
                        <option value="Production">Production</option>
                    </select>
                </div>
                

                <!-- Attachments Field -->
                <div class="col-span-1 md:col-span-2">
                    <label for="attachments" class="block text-sm font-semibold text-gray-700">Attachments</label>
                    <input type="file" id="attachments" name="attachments[]" multiple
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Add Ticket
                </button>
            </div>

            <!-- SweetAlert2 for Success Messages -->
            @if(session('success'))
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            <!-- JavaScript for Logging and Debugging -->
            <script>
                function toggleNewCategoryField() {
    const categorySelect = document.getElementById('issue_category');
    const newCategoryInput = document.getElementById('new_category');

    if (categorySelect.value === 'others') {
        newCategoryInput.classList.remove('hidden');
    } else {
        newCategoryInput.classList.add('hidden');
        newCategoryInput.value = ''; // Clear the input if not using
    }
}

                function logFormSubmission() {
                    console.log("Form submitted");
                    console.log("Trace ID: " + document.getElementById('trace_id').value);
                    console.log("Provider Name: " + document.getElementById('provider_name').value);
                    console.log("Issue Category: " + document.getElementById('issue_category').value);
                    console.log("Issue Description: " + document.getElementById('issue_description').value);
                    console.log("Assigned To: " + document.getElementById('assigned_to').value);
                    console.log("Priority: " + document.getElementById('priority').value);
                }

                document.getElementById('ticketForm').addEventListener('submit', function (event) {
                    console.log("Form is being submitted...");
                });
            </script>
        </form>
    </div>
@endsection
