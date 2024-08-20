@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-2 lg:p-12">
        <form action="{{ route('ticket.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Grid Container -->
            <div class="grid grid-cols-1 my-6 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Trace ID Field -->
                <div class="my-6">
                    <label for="trace_id" class="block text-sm font-semibold text-gray-700">Trace ID Number</label>
                    <input type="text" id="trace_id" name="trace_id"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required>
                </div>

                <!-- Provider Name Field -->
                <div class="my-6">
                    <label for="provider_name" class="block text-sm font-semibold text-gray-700">Provider Name</label>
                    <input type="text" id="provider_name" name="provider_name"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required>
                </div>

                <!-- Issue Category Field -->
                <div class="mb-6">
                    <label for="issue_category" class="block text-sm font-semibold text-gray-700">Issue Category</label>
                    <select id="issue_category" name="issue_category"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required onchange="toggleNewCategoryField()">
                        <option value="" disabled selected>Select an issue category</option>
                        <option value="مشكلة فواتير">مشكلة فواتير</option>
                        <option value="مشكله خدمات اتصالات">مشكله خدمات اتصالات</option>
                        <option value="شاشه سوداء">شاشه سوداء</option>
                        <option value="مشكلة الحساب/تسجيل الدخول">مشكلة الحساب/تسجيل الدخول</option>
                        <option value="مشكلة كروت كهرباء">مشكلة كروت كهرباء</option>
                        <option value="خدمه غير موجوده بالسيستم">خدمه غير موجوده بالسيستم</option>
                        <option value="مشكلة اقساط و قروض">مشكلة اقساط و قروض</option>
                        <option value="مشكله في خدمات التبرعات">مشكله في خدمات التبرعات</option>
                        <option value="مشكله ب خدمات الحج و العمره">مشكله ب خدمات الحج و العمره</option>
                        <option value="others">Other</option>
                    </select>
                    <input type="text" id="new_category" name="new_category"
                        class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 hidden"
                        placeholder="Enter new category">
                </div>

                <!-- Issue Description Field -->
                <div class="mb-6">
                    <label for="issue_description" class="block text-sm font-semibold text-gray-700">Issue Description</label>
                    <textarea id="issue_description" name="issue_description" rows="4"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required></textarea>
                </div>

                <!-- Assign To Field -->
                <div class="mb-6">
                    <label for="assigned_to" class="block text-sm font-semibold text-gray-700">Assign To</label>
                    <select id="assigned_to" name="assigned_to"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required>
                        <option value="" disabled selected>Select a team</option>
                        <option value="Dev Team">Dev Team</option>
                        <option value="Wakty Team">Wakty Team</option>
                    </select>
                </div>

                <!-- Priority Field -->
                <div class="mb-6">
                    <label for="priority" class="block text-sm font-semibold text-gray-700">Priority</label>
                    <select id="priority" name="priority"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2"
                        required>
                        <option value="" disabled selected>Select priority</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>

                <!-- Attachments Field -->
                <div class="mb-6">
                    <label for="attachments" class="block text-sm font-semibold text-gray-700">Attachments</label>
                    <input type="file" id="attachments" name="attachments[]" multiple
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="submit-button">
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

            <!-- JavaScript to Toggle New Category Field -->
            <script>
                function toggleNewCategoryField() {
                    const issueCategory = document.getElementById('issue_category').value;
                    const newCategoryField = document.getElementById('new_category');
                    newCategoryField.classList.toggle('hidden', issueCategory !== 'others');
                }
            </script>
        </form>
    </div>
@endsection
