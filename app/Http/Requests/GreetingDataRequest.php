<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GreetingDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'descriptions' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:20480',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ];
    }
}
