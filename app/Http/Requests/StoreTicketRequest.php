<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust this if you have authorization logic
    }

    public function rules()
    {
        return [
            'trace_id' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'provider_name' => 'required|string|max:255',
            'date_time' => 'required|date',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ];
    }
}

