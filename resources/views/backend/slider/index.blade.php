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
            <h2 class="mb-3">View Sliders <a href="{{route('admin.slider.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Slider</a></h2>
            <table class="table table-bordered yajra-datatable table-responsive" style="overflow-x: auto; width: 100%;;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hash Title</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
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
          ajax: "{{ route('admin.slider.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'hashtitle', name: 'hashtitle'},
              {data: 'images', name: 'images'},
              {data: 'title', name: 'title'},
              {data: 'description', name: 'description'},
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
