<?php

namespace Modules\Permission\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Permission\Repositories\PermissionsRepository;

class PermissionsController extends Controller
{
    protected $permission;
    private $viewsPath = 'Permission.Resources.views.';

    /**
     * PermissionsController constructor.
     *
     * @param PermissionsRepository $permissionsRepository
     */
    public function __construct(PermissionsRepository $permissionsRepository)
    {
        $this->permission = $permissionsRepository;
    }

    /**
     * Get control user permissions page.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        if (! Gate::allows('admin permissions'))
            abort(403);

        # get collection of permissions chunk by permission group name.
        $permissions = $this->permission->chunkPermissions();

        # get user permissions id.
        $user_permissions = $user->getAllPermissions()->pluck('id')->toArray();

        return view($this->viewsPath . 'index', compact('permissions','user', 'user_permissions'));
    }

    /**
     * Update user permissions.
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if( !$this->permission->assignPermissions($user, $request->only('permissions')) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.permissions.index', $user->id)->with('success', __('system.updated'));
    }
}

