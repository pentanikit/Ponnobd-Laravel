@extends('backend.layouts.app')

@section('title')
Display Section
@endsection
@section('content')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('settings.home.section.create')  }}" class="btn btn-icon btn-outline-white" >
            Add Section
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header ">
        <h5 class="mb-md-0 h6">Display Section</h5>
    </div>

    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th>
                        <p class="text-xs font-weight-bold ms-2 mb-0">#</p>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Short Description</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Products count</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($sections as $section)
                <tr>
                    <td>
                        <p class="text-xs font-weight-bold ms-2 mb-0">{{ $sections->firstItem() + $loop->index }}</p>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $section->name }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $section->short_description }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $section->order }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $section->products_count }}</h6>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('settings.home.section.edit',$section->id) }}" class="mr-2">
                                <div class="bg-success badge"><i class="fa fa-pen"></i></div>
                            </a>
                            <a href="{{ route('settings.home.section.destroy',$section->id) }}"
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
    {{ $sections->links() }}
</div>
@endsection
