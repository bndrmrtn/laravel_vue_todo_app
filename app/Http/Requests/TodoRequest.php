<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'group_id' => ['required', 'max:50','exists:groups,id'],
            'current_status_id' => ['required', 'max:50','exists:statuses,id'],
            'task' => ['required', 'min:4','max:250'],
            'priority' => ['required', 'numeric', 'min:0', 'max:9'],
        ];
    }
}
