@extends('backend.layouts.app')
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
            <h2 class="mb-3">Incoming Products (Approved)</h2>
            <div class="panel">
                <div class="panel-body table-responsive">
                    <table class="table table-bordered yajra-datatable text-center">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Model Name</th>
                                <th class="text-center">Owner</th>
                                <th class="text-center">Contact no.</th>
                                <th class="text-center">Exchange Code</th>
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
          ajax: "{{ route('admin.productincoming.approved') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'product', name: 'product'},
              {data: 'fullname', name: 'fullname'},
              {data: 'phone', name: 'phone'},
              {data: 'exchangecode', name: 'exchangecode'},
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
