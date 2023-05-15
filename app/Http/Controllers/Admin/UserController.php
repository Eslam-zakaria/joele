<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UsersRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private $usersRepository;

    /**
     * UserController constructor.
     *
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (! Gate::allows('list admins'))
            abort(403);

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (! Gate::allows('create admin'))
            abort(403);

        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        # check if repository not create user return alert.
        if( !$this->usersRepository->create( $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.response.field_process'))->withInput();

        return redirect()->route('admin.users.index')->with('success', __('messages.response.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(int $id)
    {
        //
    }


    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     *
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        if (! Gate::allows('edit admin'))
            abort(403);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        # check if repository not update user return alert.
        if( !$this->usersRepository->update( $user, $request->validated() ) )
            return redirect()->back()->with('failed', __('messages.field_process'));

        return redirect()->route('admin.users.index')->with('success', __('messages.response.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id)
    {

    }
}

