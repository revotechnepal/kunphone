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
            <h2 class="mb-3">Exchange Confirmed Orders</h2>
            <div class="panel">
                <div class="panel-body table-responsive">
                    <table class="table table-bordered yajra-datatable table-responsive text-center" style="overflow-x: auto">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Product to Exchange</th>
                                <th class="text-center">Exchange With</th>
                                <th class="text-center">Exchange Code</th>
                                <th class="text-center">Price Difference(Rs.)</th>
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
          ajax: "{{ route('admin.exchangeconfirm.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'customer_name', name: 'customer_name'},
              {data: 'exchanging_product', name: 'exchanging_product'},
              {data: 'exchanged_product', name: 'exchanged_product'},
              {data: 'exchangecode', name: 'exchangecode'},
              {data: 'pricediff', name:'pricediff'},
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
