<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('update', $this->route('employee')); }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('employees')->where('user_id', $this->user()->id)->ignore($this->route('employee'))],
            'phone' => ['required', 'string', 'max:30'],
            'salary' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'joining_date' => ['required', 'date', 'before_or_equal:today'],
            'department_id' => ['required', Rule::exists('departments', 'id')->where('user_id', $this->user()->id)->whereNull('deleted_at')],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
