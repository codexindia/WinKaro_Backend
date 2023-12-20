@extends('admin.Layouts.Main')
@section('title')
    {{ 'Banners' }}
@endsection
@section('main-container')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row new-card">
                @foreach ($getall as $item)
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body myCard">
                                <a href="{{ route('banners.delete', ['id' => $item->id]) }}"
                                    onclick="return confirm('Are you sure?')"><img
                                        src="{{ url('AdminAssets/assets/img/trash-solid.svg') }}" class="icon"></a>
                                <img src="{{ $item->source_link }}" class="mainImage" alt="{{ $item->name }}">
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body myCardFile">
                            <label for="inputTag">
                                Click Here To Add Banners
                                <input id="inputTag" type="button" class="btn btn-primary inf" data-bs-toggle="modal"
                                    data-bs-target="#backDropModal" />
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"
                integrity="sha512-hJsxoiLoVRkwHNvA5alz/GVA+eWtVxdQ48iy4sFRQLpDrBPn6BFZeUcW4R4kU+Rj2ljM9wHwekwVtsb0RY/46Q=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <!-- Modal -->
            <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('banners.upload') }}" method="POST" enctype="multipart/form-data"
                        class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="backDropModalTitle">Add New Banner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="emailBackdrop" class="form-label">Name</label>
                                    <input type="text" name="name" id="emailBackdrop" class="form-control"
                                        placeholder="Xyz Banner" required />
                                </div>
                                <div class="col mb-0">
                                    <label for="dobBackdrop" class="form-label">Action</label>
                                    <input type="text" name="action" id="dobBackdrop" value="#"
                                        class="form-control" placeholder="Lrem Ispum" required />
                                </div>
                            </div>
                            <div class="card mt-2">

                                <input type="file" name="banner" class="dropify form-control" required />

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                $('.dropify').dropify({
                    messages: {
                        'default': 'Click To Upload',
                        'replace': 'Drag and drop or click to replace',
                        'remove': 'Remove',
                        'error': 'Ooops, something wrong happended.'
                    }
                });
            </script>

        </div>
    @endsection
