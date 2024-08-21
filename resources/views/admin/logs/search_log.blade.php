{{-- @extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->

        <div class="container">
        <table id="logtable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Level</th>
                    <th>Action</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>




                    <tr>
                        <td>2078/8/8</td>
                        <td>5:23</td>
                        <td>info</td>
                        <td>log</td>
                        <td>
                        faw:FAWfa
                        FAWF:FAFW
                        AWFA:FAWF
                        AFA:FSGDHD
                        THDT:eugkw
                        JT:JT
                        </td>
                    </tr>


            </tbody>
        </table>
    </div>


{{-- @endsection --}}

@section('scripts')
<script>

    let table = new DataTable('#logtable');
</script>
@endsection 
