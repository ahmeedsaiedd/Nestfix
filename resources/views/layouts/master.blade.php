@include('layouts.head')

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>EBE</title>
    <link rel="icon" href="{{ asset('assets/favicon.png') }}" type="image/png" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="{{ asset('assets/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('assets/js/charts-pie.js') }}" defer></script>
</head>
<style>
    .move-up {
        margin-top: -11px;
        /* Adjust the value as needed */
        margin-left: 50px;
    }
</style>
<style>
    /* form-styles.css */

    /* Ensure full width and minimal margins for body and html */
    html,
    body {
        width: 100%;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Center the form container and set background color */
    .min-h-screen {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f7f7f7;
    }

    /* Style the form container */
    .form-container {
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 2rem;
        max-width: 100%;
        width: 100%;
        max-width: 28rem;
        /* Adjust based on desired width */
        margin: 1rem;
    }

    /* Heading style */
    .form-container h2 {
        font-size: 1.875rem;
        /* 3xl */
        font-weight: 700;
        color: #333333;
        margin-bottom: 1.5rem;
    }

    /* Style for input fields */
    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="password"],
    .form-container select {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        width: 100%;
        box-sizing: border-box;
        font-size: 0.875rem;
        /* sm:text-sm */
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-container input[type="text"]:focus,
    .form-container input[type="email"]:focus,
    .form-container input[type="password"]:focus,
    .form-container select:focus {
        border-color: #6366f1;
        /* indigo-500 */
        box-shadow: 0 0 0 1px #6366f1;
        /* indigo-500 */
        outline: none;
    }

    /* Label styling */
    .form-container label {
        display: block;
        font-size: 0.875rem;
        /* sm:text-sm */
        color: #4b5563;
        /* gray-700 */
        margin-bottom: 0.5rem;
    }

    /* Error message styling */
    .form-container .text-gray-500 {
        color: #6b7280;
        /* gray-500 */
    }

    /* Button styling */
    .form-container .x-button {
        background-color: #4f46e5;
        /* indigo-600 */
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        font-size: 0.875rem;
        /* sm:text-sm */
        cursor: pointer;
        transition: background-color 0.2s, transform 0.2s;
    }

    .form-container .x-button:hover {
        background-color: #4338ca;
        /* indigo-700 */
        transform: translateY(-1px);
    }

    .form-container .x-button:focus {
        outline: 2px solid #4f46e5;
        /* indigo-600 */
        outline-offset: 2px;
    }

    /* Link styling */
    .form-container a {
        color: #4f46e5;
        /* indigo-600 */
        text-decoration: none;
        font-weight: 600;
    }

    .form-container a:hover {
        color: #4338ca;
        /* indigo-700 */
    }
</style>
<style>
    .my-6 {
        padding-left: 10px;
        padding-right: 10px;
    }

    .form-container {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-field {
        margin-bottom: 1.5rem;
    }

    .form-field label {
        font-size: 0.875rem;
        color: #4a5568;
        font-weight: 600;
    }

    .form-field input,
    .form-field select,
    .form-field textarea {
        border-radius: 0.375rem;
        border: 1px solid #d2d6dc;
        padding: 0.75rem;
        width: 100%;
        font-size: 0.875rem;
    }

    .form-field input:focus,
    .form-field select:focus,
    .form-field textarea:focus {
        border-color: #3182ce;
        box-shadow: 0 0 0 1px #3182ce;
    }

    .form-container {
        position: relative;
        /* Ensures the button is positioned relative to this container */
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .submit-button {
        background-color: #4CAF50;
        /* Green background */
        border: none;
        /* Remove borders */
        color: white;
        /* White text */
        padding: 10px 20px;
        /* Smaller padding */
        text-align: center;
        /* Center the text */
        text-decoration: none;
        /* Remove underline */
        display: inline-block;
        /* Make the button fit the content */
        font-size: 14px;
        /* Smaller font size */
        margin: 2px 1px;
        /* Smaller margin */
        cursor: pointer;
        /* Change cursor on hover */
        border-radius: 6px;
        /* Slightly smaller rounded corners */
        transition: background-color 0.3s, transform 0.3s;
        /* Smooth transition */
    }

    .submit-button:hover {
        background-color: #45a049;
        /* Darker green on hover */
        transform: scale(1.05);
        /* Slightly enlarge the button on hover */
    }

    .submit-button:active {
        background-color: #39843c;
        /* Even darker green when button is pressed */
        transform: scale(0.98);
        /* Slightly shrink the button on click */
    }
</style>
<style>
    /* Loader container styling */
    .loader-container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    /* Spinner loader styling */
    .spinner {
        width: 80px;
        height: 80px;
        border: 8px solid #e5e7eb;
        /* Light border color */
        border-top: 8px solid #6366f1;
        /* Indigo top border */
        border-radius: 50%;
        animation: spin 1.5s linear infinite;
    }

    /* Spinning animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<style>
    .wrap-text {
    word-wrap: break-word; /* Older browsers */
    overflow-wrap: break-word; /* Modern browsers */
}

</style>


<div class="loader-container" id="spinner-loader">
    <div class="spinner"></div>
</div>


<body>
    <div class="flex h-screen bg-gray-50" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('layouts.sidebar')
        <div class="flex flex-col flex-1 w-full">
            @include('layouts.header')
            <main class="h-full overflow-y-auto"  style="margin-top: 40px !important ">
                <div class="container px-6 mx-auto grid">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @include('layouts.script')
</body>

</html>
