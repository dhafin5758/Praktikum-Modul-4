<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRoleRequest;
use App\Models\User;
use App\Services\RoleManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('admin.users', [
            'users' => User::orderBy('id_user')->get(['id_user', 'nama_lengkap', 'username', 'role']),
        ]);
    }

    public function update(
        ChangeRoleRequest $request,
        User $user,
        RoleManagementService $service
    ): RedirectResponse {
        $data = $request->validated();

        $service->changeRole($request->user(), $user, $data['role']);

        return back()->with('pesan', 'Role diperbarui.');
    }
}