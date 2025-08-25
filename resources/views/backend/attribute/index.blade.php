@extends('backend.layouts.app')

@section('title')
Attributes
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">#</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Values
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($attributes as $attribute)
                        <tr>
                            <td>
                                {{ $attributes->firstItem() + $loop->index }}
                            </td>
                            <td>
                                <h6 class="mb-0 text-xs">{{ $attribute->name }}</h6>
                            </td>
                            <td style="display: table-cell">
                                {{-- <ul>
                                    @foreach ($attribute->values as $value)
                                    <li>{{ $value->value }}</li>
                                    @endforeach
                                </ul> --}}

                                @foreach ($attribute->values as $value)
                                <span class="badge badge-inline badge-md bg-success">{{ $value->value }}</span>
                                @endforeach

                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown"
                                        id="actionLink{{ $attribute->id }}">
                                        <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="actionLink{{ $attribute->id }}">
                                        @can('attribute_value_view')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('attribute.show',$attribute->id) }}"
                                                title="Attribute values"> <i class="fa fa-eye"></i> Values</a>
                                        </li>
                                        @endcan
                                        @can('attributes_edit')
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('attribute.edit',$attribute->id) }}"> <i
                                                    class="fa fa-pen"></i> Edit</a>
                                        </li>
                                        @endcan
                                        @can('attributes_delete')
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('attribute.destroy',$attribute->id) }}"
                                                onclick="return confirm('Are you sure?')"> <i
                                                    class="fa fa-trash text-danger"></i> Delete</a>
                                        </li>
                                        @endcan
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <td colspan="3">No Data Found!</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $attributes->links() }}
        </div>
    </div>
    @can('attributes_add')
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Add New Attribute</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('attribute.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" placeholder="Name" id="name" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
