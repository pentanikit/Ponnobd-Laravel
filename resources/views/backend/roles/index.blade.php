@extends('backend.layouts.app')

@section('title')
Roles
@endsection
@section('content')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('roles.create')  }}" class="btn btn-icon btn-outline-white">
            Add Role
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header ">
        <h5 class="mb-md-0 h6">Roles</h5>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        #
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($roles as $role)
                <tr>
                    <td>
                        {{ $roles->firstItem() + $loop->index }}
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $role->name }}</h6>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('roles.edit',$role->id) }}" class="mr-2">
                                <div class="bg-success badge"><i class="fa fa-pen"></i></div>
                            </a>
                            <a href="{{ route('roles.destroy',$role->id) }}"
                                onclick="return confirm('Are you sure?')">
                                <div class="bg-danger badge"><i class="fa fa-trash"></i></div>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="3">No Data Found!</td>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $roles->links() }}
</div>
@endsection
