<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:admin,moderator,operator',
        'admin_password' => ['required', function ($attribute, $value, $fail) {
            Log::info('Admin Password Check: ', ['value' => $value]);
            // Check if the provided password matches the admin password
            if (!Hash::check($value, Auth::user()->password)) {
                $fail('The admin password is incorrect.');
            }
        }],
    ];
}

    public function messages()
    {
        return [
            'admin_password.required' => 'Admin password is required.',
        ];
    }
}

