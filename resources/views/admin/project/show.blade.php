@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Project Details') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="mr-2">
                                <a title="Go Back" href="{{ route('admin.project.index') }}"
                                    class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                        aria-hidden="true"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.project.index') }}">{{ __('Projects') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Project Details') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->
        <section class="content gray px-3">
            <div class="container-fluid">
                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3 d-flex">
                                    <div class="col-md-4">Title</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $project->title }}</div>
                                </div>
                                <div class="col-md-6 mb-3 d-flex">
                                    <div class="col-md-4">Slug</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ ucwords($project->slug) }}</div>
                                </div>
                                <div class="col-md-6 mb-3 d-flex">
                                    <div class="col-md-4">Project Type</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $project->projectType->name ?? '' }}</div>
                                </div>
                                <div class="col-md-6 mb-3 d-flex">
                                    <div class="col-md-4">Sector</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $project->page->name ?? '' }}</div>
                                </div>
                                <div class="col-md-6 mb-3 d-flex">
                                    <div class="col-md-4">Stage</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $project->stage == 'completed' ? 'Completed' : 'Ongoing' }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 d-flex">
                                    <div class="col-md-4">Short Description</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $project->short_description }}</div>
                                </div>
                                <div class="col-md-6 mb-3 d-flex">
                                    <div class="col-md-4">Description</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{!! $project->description !!}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <p>Main Image</p>
                                    @foreach ($project->images->filter(function ($image) {
            return !is_null($image->main_image);
        }) as $image)
                                        <a href="{{ asset('storage/uploads/project/main_image/' . $image->main_image) }}"
                                            data-toggle="lightbox" data-gallery="multiimages" data-title=""
                                            class=" img-responsive">
                                            <picture>
                                                <source media="(min-width:3840px)"
                                                    srcset="{{ asset('storage/uploads/project/main_image/thumbnail/admin_' . $image->main_image) }}" />

                                                <img src="{{ asset('storage/uploads/project/main_image/thumbnail/admin_' . $image->main_image) }}"
                                                    alt="main Image" />
                                            </picture>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <p>Mobile Image</p>
                                    @foreach ($project->images->filter(function ($image) {
            return !is_null($image->mobile_image);
        }) as $image)
                                        <a href="{{ asset('storage/uploads/project/mobile_image/' . $image->mobile_image) }}"
                                            data-toggle="lightbox" data-gallery="multiimages" data-title=""
                                            class=" img-responsive">
                                            <picture>
                                                <source media="(min-width:3840px)"
                                                    srcset="{{ asset('storage/uploads/project/mobile_image/thumbnail/admin_' . $image->mobile_image) }}" />

                                                <img src="{{ asset('storage/uploads/project/mobile_image/thumbnail/admin_' . $image->mobile_image) }}"
                                                    alt="main Image" />
                                            </picture>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

    </div>
    <!-- /.container-fluid -->
    </section>
    </div>
@endsection

@section('scripts')
@endsection
