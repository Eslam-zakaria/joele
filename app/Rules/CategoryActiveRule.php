<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Category\Repositories\CategoriesRepository;

class CategoryActiveRule implements Rule
{
    private $model;

    /**
     * Create a new rule instance.
     *
     * @param string $model
     *
     * @return void
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if( !app(CategoriesRepository::class)->find_active($value, $this->model) )
            return false;

         return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid.';
    }
}
