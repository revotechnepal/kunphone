@extends('backend.layouts.app')
@push('styles')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
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
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h2 class="mb-3">View Orders</h2>
            <table class="table table-bordered yajra-datatable table-responsive text-center" style="overflow-x: auto">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Order Status</th>
                        <th class="text-center">Delievery Address</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Added Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
          ajax: "{{ route('admin.order.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'customer_name', name: 'customer_name'},
              {data: 'order_status', name: 'order_status'},
              {data: 'delievery_address', name: 'delievery_address'},
              {data: 'total_price', name:'total_price'},
              {data: 'added_date', name: 'added_date'},
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
