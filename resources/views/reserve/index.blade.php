@extends('layouts.backend')
@section('title', 'Reservation List')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $page_title }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered" style="text-align: center">
                        <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>People</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reservations as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->time }}</td>
                                <td>{{ $item->people }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td><span
                                        class="badge {{ $item->status == 0 ? 'badge-warning' : ($item->status == 1 ? 'badge-success' : 'badge-danger') }}">{{ $item->status == 0 ? 'pending' : ($item->status == 1 ? 'reserved' : 'canceled') }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-primary"
                                       href="{{ route('admin.reserve.confirmation', ['accept', $item->id]) }}">Accept</a>
                                    <a class="btn btn-warning"
                                       href="{{ route('admin.reserve.confirmation', ['decline', $item->id]) }}">Decline</a>
                                    <button id="{{ $item->id }}" class="btn btn-danger delete" type="button"
                                            data-toggle="modal"
                                            data-target="#exampleModal">Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="deleteModal" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-body">
                        Are you sure want to delete this item?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.delete').on('click', function () {
            const id = this.id;
            $('#deleteModal').attr('action', "{{ route('admin.reserve.delete', '') }}" + '/' + id);
        });
    </script>
@endsection
