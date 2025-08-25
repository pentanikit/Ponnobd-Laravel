@extends('backend.layouts.app')

@section('title')
Pages
@endsection
@section('content')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('pages.create')  }}" class="btn btn-icon btn-outline-white" >
            Add Page
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header ">
        <h5 class="mb-md-0 h6">Pages</h5>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        <div class="d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allSelected">
                            </div>
                            <p class="text-xs font-weight-bold ms-2 mb-0">#</p>
                        </div>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Link</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($pages as $page)
                <tr>
                    <td>
                        <p class="text-xs font-weight-bold ms-2 mb-0">{{ $pages->firstItem() + $loop->index }}
                        </p>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $page->name }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ route('page',$page->slug) }}</h6>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('page',$page->slug) }}" class="mr-2" target="_blank" title="Visit Page">
                                <div class="bg-dark badge"><i class="fa fa-eye"></i></div>
                            </a>
                            <a href="{{ route('pages.edit',$page->id) }}" class="mr-2">
                                <div class="bg-success badge"><i class="fa fa-pen"></i></div>
                            </a>
                            @if($page->type == 'custom')
                            <a href="{{ route('pages.destroy',$page->id) }}"
                                onclick="return confirm('Are you sure?')">
                                <div class="bg-danger badge"><i class="fa fa-trash"></i></div>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="3" class="text-center">No Pages Found!</td>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $pages->links() }}
</div>
@endsection
