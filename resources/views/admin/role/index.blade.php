@extends('layouts.manager')
@section('title')
    Manager Roles
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Roles</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Roles</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive"><table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                    </td>
                                    <td>
                                        {{ count($role->permissions) }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                   class="btn btn-sm btn-warning">Edit</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection