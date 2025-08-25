@extends('backend.layouts.app')

@section('title')
{{ $attribute->name }} - Attribute
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">#</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($attribute->values as $value)
                    <tr>
                        <td>
                            {{ $loop->index + 1 }}
                        </td>
                        <td>
                            <h6 class="mb-0 text-xs">{{ $value->value }}</h6>
                        </td>
                        <td>
                            <div class="d-flex">
                                @can('attribute_value_edit')
                                <a href="{{ route('attribute.value.edit',$value->id) }}" class="text-success mr-2"><i
                                        class="fa fa-pen"></i>
                                </a>
                                @endcan
                                @can('attribute_value_delete')
                                <a href="{{ route('attribute.value.delete',$value->id) }}" class="text-danger"
                                    onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i>
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <td colspan="4" class="text-center">No Data Found!</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @can('attribute_value_add')
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Add New Attribute</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('attribute.value.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" placeholder="Name" id="name" value="{{ $attribute->name }}"
                            class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">Value</label>
                        <input type="text" placeholder="Attribute Value.." id="value" name="value"
                            value="{{ old('value') }}" class="form-control @error('value') is-invalid @enderror">
                        @error('value')
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
