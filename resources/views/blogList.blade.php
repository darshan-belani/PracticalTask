@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span>{{ __('Dashboard') }}</span>
                    @if(auth()->user()->role != "admin")
                        <button style="float: right;">
                            <a href="{{ route('addBlog') }}" style=" color: black; text-decoration: none">{{ __('Add Blog') }}</a>
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="datatable-crud">
                        <thead>
                        <tr>
                            <th>No</th>
                            @if(auth()->user()->role == "admin")
                                <th>User</th>
                            @endif
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>CreatedAt</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#datatable-crud').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('list') }}",
            columns: [
                { data: 'id', name: 'id' },
                    @if(auth()->user()->role == "admin")
                { data: 'user', name: 'user' },
                @endif
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { "data": "image",
                    "render": function(data, type, row) {
                        console.log(data);
                        return "<img src=\"" + data + "\" height=\"50\"/>";
                    }
                },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false },
            ],
            order: [[0, 'desc']]
        });

        setTimeout(function() {
            $('.alert-success').fadeOut('fast');
        }, 10000);
    });
</script>
@endsection
