<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number,' . $this->id,
            'total_seats' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ];
    }
}
