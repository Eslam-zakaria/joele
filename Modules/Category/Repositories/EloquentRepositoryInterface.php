<?php


namespace Modules\Category\Repositories;


use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Collection;

interface EloquentRepositoryInterface
{
    /**
     * Get all records.
     *
     * @return Collection
     */
    public function get();

    /**
     * Find model by key
     *
     * @param int $key
     *
     * @return Model
     */
    public function find(int $key) : Model;

    /**
     * Create new model.
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data) : bool;

    /**
     * Update model.
     *
     * @param Model $model
     * @param array $data
     *
     * @return bool
     */
    public function update(Model $model, array $data) : bool;

    /**
     * Delete Model.
     *
     * @param Model $model
     *
     * @return bool
     */
    public function delete(Model $model) : bool;
}
