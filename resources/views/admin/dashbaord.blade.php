@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header px-3">
    <div class="container-fluid">
      <div class="row mb-2 mx-1">
        <div class="col-sm-6">
          @role('admin')
          <h3>Admin Dashboard</h3>
          @endrole
          @role('writer')
          <h3>Writer Dashboard</h3>
          @endrole
          {{-- <h1 class="m-0">{{__('Dashboard')}}</h1> --}}
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Dashboard')}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content px-3">
    <div class="container-fluid">
      <div class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <a href="#">

                <div class="small-box bg-info">
                  <div class="inner">
                    {{-- <h3>{{$total_new_cases}}</h3> --}}
                    <h3>{{count($team)}}<sup style="font-size: 20px"></sup></h3>

                    <p>{{__('Teams')}}</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
              </a>
            </div>
            <!-- ./col -->

            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <a href="#">

                <div class="small-box bg-warning">
                  <div class="inner">
                    {{-- <h3>{{$total_user_registred}}</h3> --}}
                    <h3>{{count($news)}}<sup style="font-size: 20px"></sup></h3>

                    <p>{{__('News')}}</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-newspaper"></i>
                  </div>
                  {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
              </a>
            </div>

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <a href="#">
                <div class="small-box bg-secondary">
                  <div class="inner">
                    {{-- <h3>{{$total_user_registred}}</h3> --}}
                    <h3>{{count($news)}}<sup style="font-size: 20px"></sup></h3>

                    <p>{{__('Services')}}</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-concierge-bell"></i>
                  </div>
                  {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
              </a>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
            </div>
            <!-- ./col -->
          </div>
        </div>
      </div>

      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
      </div>
      <!-- /.card-tools -->
    </div>
    <div class="card-body">
      <div id="world-map" style="height: 250px; width: 100%;"></div>
    </div>
    <!-- /.card-body-->
    <div class="card-footer bg-transparent">
      <div class="row">
      </div>
      <!-- /.row -->
    </div>
</div>
<!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@endsection

@section('footer-scripts')
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
<script src="{{asset('assets/dist/js/pages/dashboard.js')}}"></script>
@endsection