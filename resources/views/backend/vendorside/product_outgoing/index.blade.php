@extends('backend.layouts.vendor')
@push('styles')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
<!-- MAIN -->
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h2 class="mb-3">View Outgoing Products (New Phones)<a href="{{route('vendor.productoutgoing.create')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> Create Outgoing Product</a></h2>
            <div class="panel">
                <div class="panel-body table-responsive">
                    <table class="table table-bordered yajra-datatable text-center">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Model Image</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">RAM</th>
                                <th class="text-center">ROM</th>
                                <th class="text-center">Featured</th>
                                <th class="text-center">In stock</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {

      var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('vendor.productoutgoing.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'modelimage', name: 'modelimage'},
              {data: 'name', name: 'name'},
              {data: 'ram', name: 'ram'},
              {data: 'rom', name: 'rom'},
              {data: 'featured', name: 'featured'},
              {data: 'quantity', name: 'quantity'},
              {
                  data: 'action',
                  name: 'action',
                  orderable: true,
                  searchable: true
              },
          ]
      });

    });
  </script>
@endpush
