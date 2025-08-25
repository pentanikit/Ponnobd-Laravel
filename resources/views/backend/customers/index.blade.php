@extends('backend.layouts.app')

@section('title')
Customers
@endsection
@section('content')
<div class="card">
    <div class="card-header ">
        <h5 class="mb-md-0 h6">Customers</h5>
    </div>
    <form>
        <div class="row">
            @can('customers_bulk_delete')
            <div class="col-md-2 ">
                <div class="dropdown pl-2">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Bulk Action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item" href="{{ route('customers.bulk.delete') }}" id="deleteSelected">Delete
                                selection</a>
                        </li>
                    </ul>
                </div>
            </div>
            @endcan
            <div class="col-lg-5">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"
                        placeholder="Type email or name or username or phone & Enter" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        <div class="d-flex align-items-center">
                            @can('customers_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allSelected">
                            </div>
                            @endcan

                            <p class="text-xs font-weight-bold ms-2 mb-0">#</p>
                        </div>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">UserName</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($customers as $customer)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @can('customers_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bulkDelete"
                                    value="{{ $customer->id }}">
                            </div>
                            @endcan
                            <p class="text-xs font-weight-bold ms-2 mb-0">{{ $customers->firstItem() + $loop->index }}
                            </p>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $customer->username }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $customer->name }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $customer->email }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $customer->phone ?? 'N/A' }}</h6>
                    </td>
                    <td>
                        <div class="d-flex">
                            @can('customers_delete')
                            <a href="{{ route('customers.destroy',$customer->id) }}"
                                onclick="return confirm('Are you sure?')">
                                <div class="bg-danger badge"><i class="fa fa-trash"></i></div>
                            </a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="3">No Data Found!</td>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $customers->links() }}
</div>
@endsection
