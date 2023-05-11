@extends('layouts.backend')
@section('title', 'Gallery List')

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
                            <th>Thumbnail</th>
                            <th>Caption</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($galleries as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    @if($item->thumbnail)
                                        <img width="100" src="{{ asset($item->thumbnail) }}" alt="{{ $item->caption }}">
                                    @else
                                        <img width="100" src="{{ asset('/uploads/gallery/no-image.jpg') }}"
                                             alt="No Image">
                                    @endif

                                </td>
                                <td>{{ $item->caption }}</td>
                                <td><span
                                        class="badge {{ $item->type == 1 ? 'badge-primary' : 'badge-warning' }}"> {{ $item->type == 1 ? 'Video' : 'Photo' }} </span>
                                </td>
                                <td>
                                    <a class="btn btn-warning" href="{{ route('gallery.edit', $item->id) }}">Edit</a>
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
            $('#deleteModal').attr('action', "{{ route('gallery.destroy', '') }}" + '/' + id);
        });
    </script>
@endsection
