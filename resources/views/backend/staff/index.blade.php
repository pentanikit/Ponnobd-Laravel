@extends('backend.layouts.app')

@section('title')
Staff
@endsection
@section('content')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('staff.create')  }}" class="btn btn-icon btn-outline-white">
            Add Staff
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header ">
        <h5 class="mb-md-0 h6">Staff</h5>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        #
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($staffs as $staff)
                <tr>
                    <td>
                        {{ $staffs->firstItem() + $loop->index }}
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $staff->getRoleNames()->first() }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $staff->name }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $staff->email }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $staff->phone }}</h6>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('staff.edit',$staff->id) }}" class="mr-2">
                                <div class="bg-success badge"><i class="fa fa-pen"></i></div>
                            </a>
                            <a href="{{ route('staff.destroy',$staff->id) }}"
                                onclick="return confirm('Are you sure?')">
                                <div class="bg-danger badge"><i class="fa fa-trash"></i></div>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="6" class="text-center">No Data Found!</td>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $staffs->links() }}
</div>
@endsection
