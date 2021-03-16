<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'month' => 'required',
            'goods_ready_for_sale' => 'required',
            'finished_products' => 'required',
            'semi_finished_products' => 'required',
            'work_in_process' => 'required',
            'raw_materials' => 'required',
            'spare_parts_and_others' => 'required',
            'inventory_provision' => 'required',
        ];
    }
}
