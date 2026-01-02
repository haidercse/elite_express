<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'phone' => 'nullable|digits:11',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nid_document' => 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
            'contract_document' => 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'phone.digits' => 'Phone number must be exactly 11 digits.',
            'profile_photo.image' => 'Profile photo must be an image.',
            'profile_photo.max' => 'Profile photo must be less than 2MB.',
            'nid_document.max' => 'NID document must be less than 4MB.',
        ];
    }
}
