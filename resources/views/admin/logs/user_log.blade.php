@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Logs') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Logs') }}
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
                            <div class="card card-info ">
                                <div class="card-header" style="background-color: #5c5c5c">
                                    <h3 class="card-title">Search By</h3>
                                </div>

                                <div class="card-body row"  style="padding:10px; margin-left:1px; margin-right:1px; background-color:rgb(219, 219, 219)" >
                                <form action="{{ route('search.log') }}" id="form" method="GET"style="padding-left:20px;">
                                    @csrf

                                        <div class="form-group  row">
                                            <label for="date"  class="col-form-label text-center">Date</label>
                                            <div class="col-sm-10">
                                                @php
                                                $now = \Carbon\Carbon::now()->format('Y-m-d');
                                            @endphp
                                            <input type="date" name="date" id="date" placeholder="search by date"
                                                @if ($date) value="{{ $date }}"
                                                    @else value="{{ $now }}" @endif
                                                class="form-control col-sm-12">
                                            </div>
                                        </div>
                                </form>
                                <div class="form-group row" style="padding-left:20px;">
                                    <label for="action" class=" col-form-label text-center">Action</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control "name="action" onkeyup='tableSearch()'
                                        id="action" placeholder="Search by Action">
                                    </div>
                                </div>
                                <div class="form-group row"  style="padding-left:20px;">
                                    <label for="level" class=" col-form-label text-center">Level</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control col-sm-10"name="level"
                                        onkeyup='tableSearch()'id="level" placeholder="Search by Level">
                                    </div>
                                </div>
                            </div>
                            </div>





                            <div class="card-body">
                                <div class="row mb-3">

                                </div>
                                <div class="box ">
                                    <div class="box-body table-responsive">
                                        <table id="logtable" class="table  table-striped compact">

                                            <thead style="background-color: #5c5c5c;">
                                                <tr style="color: #f7f7f7">
                                                    <th >Date</th>
                                                    <th>Time</th>
                                                    <th>Level</th>
                                                    <th>Action</th>
                                                    <th>Message</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($logdata as $log)
                                                    <tr>
                                                        <td>{{ $log['date'] }}</td>
                                                        <td>{{ $log['time'] }}</td>
                                                        <td>{{ $log['level'] }}</td>
                                                        <td>{{ $log['action'] }}</td>
                                                        <td>
                                                            @if (!empty($printMessage))
                                                                @foreach ($printMessage as $key => $value)
                                                                    {{ $key . ': ' . $value }} <br>
                                                                @endforeach
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

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
        <script>
            const inputField = document.getElementById('date');
            const form = document.getElementById('form');

            // Add a click event listener to the input field
            inputField.addEventListener('change', () => {
                // Submit the form
                form.submit();

            });


            //Search by Action
            function tableSearch() {
                let inputAction, filterAction, inputLevel, filterLevel, tdAction, tdLevel, txtValueAction, txtValueLevel;
                //Intialising Variables
                let date = document.getElementById("date").value;

                inputAction = document.getElementById("action");
                filterAction = inputAction.value.toUpperCase();
                inputLevel = document.getElementById("level");
                filterLevel = inputLevel.value.toUpperCase();
                table = document.getElementById("logtable");
                tr = table.getElementsByTagName("tr");


                for (let i = 0; i < tr.length; i++) {
                    tdAction = tr[i].getElementsByTagName("td")[3];

                    tdLevel = tr[i].getElementsByTagName("td")[2];
                    if (tdAction && tdLevel) {
                        txtValueAction = tdAction.textContent || tdAction.innerText;
                        txtValueLevel = tdLevel.textContent || tdLevel.innerText;
                        if (txtValueAction.toUpperCase().indexOf(filterAction) > -1 && txtValueLevel.toUpperCase().indexOf(
                                filterLevel) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }



            }
        </script>
@endsection
