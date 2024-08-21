@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Category')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}">{{__('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{__('Category')}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <a href="{{route('category.add')}}" class="btn btn-primary" style=""> + Add</a>
                                </div>
                            </div>
                            <div class="box box-primary">
                                <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                     <tr>
                                         <th class=" text-uppercase">#</th>
                                         <th class="">Category</th>
                                         {{-- <th class="">Parent Category</th> --}}
                                         {{-- <th class="">Image</th> --}}
                                         <th class="" style="width: 150px;">Actions</th>
                                     </tr>
 
                                </thead>
 
                                <tbody>
                                        @foreach ($category as $key => $categories)
                                            <tr>
                                                <td>{{ $key + 1}}</td>
                                                <td >
                                                    {{ $categories->name }}
                                                </td>
                                                {{-- <td>
                                                    <b>{{ @$categories->parentCategory->name }}</b>
                                                </td> --}}

                                                {{-- <td>
                                                @if(isset($categories->category_image))
                                                    <div class="col-md-12" >
                                                        <div class="image-trap" >
                                                            <a href="{{asset('storage/uploads/category_image/'.$categories->category_image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                                <img class="img-thumbnail image_list" style="width:100%; height:150px;"  src="{{asset('storage/uploads/category_image/'.$categories->category_image)}}" alt="image">
                                                            </a>
                                                        </div>
                                                    </div>
                                                @elseif(isset($categories->parentCategory->category_image))
                                                    <div class="col-md-12" >
                                                        <div class="image-trap" >
                                                            <a href="{{asset('storage/uploads/category_image/'.$categories->category_image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                                <img class="img-thumbnail image_list" style="width:100%; "  src="{{asset('storage/uploads/category_image/'.$categories->category_image)}}" alt="image">
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                                </td> --}}

                                                <td class="d-flex">
                                                    <a href="{{route('category.edit',$categories->id)}}"
                                                    button class="btn btn-primary btn-sm" type="submit"></button>
                                                        <i class="fas fa-edit"></i></a>
                                                        &nbsp;
                                                    {{-- <a href="{{ route('category.delete', $categories->id) }}" button class="btn btn-danger" type="submit">Delete</button>
                                                        <i class="fa fa-trash"></i></a> --}}
                                                        <form method="POST" action="{{ route('category.delete', $categories->id) }}">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete'><i class="fa fa-trash"></i></button>
                                                        </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                             </table>
                             <div class="justify-content-center">
                                <ul class="pagination pagination-sm">
                                    {!! $category->render() !!}
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
@endsection