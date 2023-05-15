<?php

namespace Modules\Permission\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionsRepository
{
    protected $model;

    /**
     * PermissionsServices constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * Chunk permissions by group name.
     *
     * @param array $permissions
     * @return array
     */
    public function chunkPermissions(array $permissions = []): array
    {
        $allPermissions = $this->list();

        foreach ($this->permissionsGroup() as $permission){
            $permissions[$permission] = $allPermissions->where('group_name', $permission);
        }

        return $permissions;
    }

    /**
     * List all permissions.
     *
     * @return mixed
     */
    public function list()
    {
        return $this->model->select('id', 'name', 'display_name', 'group_name')->get();
    }

    /**
     * Get permission group.
     *
     * @return array
     */
    public function permissionsGroup(): array
    {
        return array_unique($this->list()->pluck('group_name')->toArray());
    }

    /**
     * Assign permissions to model.
     *
     * @param $model
     * @param $permissions
     * @return bool
     */
    public function assignPermissions($model, $permissions): bool
    {
        try {

            $model->syncPermissions($permissions);

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
