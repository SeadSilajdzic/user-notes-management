@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p>{{ __('Dashboard') }}</p>

                        <div class="infos">
                            <a href="#" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#myInfoModal">My info</a>
                            <a href="#" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#myCategoriesModal">My categories</a>

                            <!-- Modal for authenticated users info display -->
                            <div class="modal fade" id="myInfoModal" tabindex="-1" aria-labelledby="myInfoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">My info</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for authenticated users categories display -->
                            <div class="modal fade" id="myCategoriesModal" tabindex="-1" aria-labelledby="myCategoriesModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">My categories</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($categories as $category)
                                                        <tr>
                                                            <td>{{ $category->id }}</td>
                                                            <td>{{ $category->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-triggers">
                            <a href="#" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#addNewCategoryModal">Add new category</a>
                            <a href="#" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#addNewNoteModal">Add new note</a>

                            <!-- Modal for new category form -->
                            <div class="modal fade" id="addNewCategoryModal" tabindex="-1" aria-labelledby="addNewCategoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New category form</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('category.store') }}" method="post">
                                                @csrf

                                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                <div class="form-group">
                                                    <label for="name">Category</label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success" name="btn-add-new-category">Add new category</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for new note form -->
                            <div class="modal fade" id="addNewNoteModal" tabindex="-1" aria-labelledby="addNewNoteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New note form</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('note.store') }}" method="post">
                                                @csrf

                                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="content">Content</label>
                                                    <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ old('content') }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="tags">Select categories</label>
                                                    @foreach($categories as $category)
                                                        <div class="form-check">
                                                            <input type="checkbox" name="categories[]" class="form-check-input" id="categories" value="{{ $category->id }}">
                                                            <label class="form-check-label" for="categories">{{ $category->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success" name="btn-add-new-note">Add new note</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /modal-triggers -->
                    </div>

                    <div class="card-body">
                        @include('partials.errors')

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @forelse($notes as $note)
                            <ul>
                                <li class="d-flex justify-content-between">
                                    <a href="#" data-toggle="modal" data-target="#showNoteInfoModal{{ $note->id }}">{{ $note->title }}</a>


                                    <div class="actions d-flex">
                                        <a href="#" class="btn btn-sm btn-info mr-2" style="color: white;" data-toggle="modal" data-target="#editNoteInfoModal{{ $note->id }}">Edit</a>

                                        <form action="{{ route('note.destroy', $note) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" name="btn-delete-note" class="btn btn-sm btn-danger">Delete</button>
                                        </form>


                                        <!-- Modal for edit notes info form -->
                                        <div class="modal fade" id="editNoteInfoModal{{ $note->id }}" tabindex="-1" aria-labelledby="editNoteInfoModal{{ $note->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit {{ $note->title }} note</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('note.update', $note) }}" method="post">
                                                            @csrf
                                                            @method('PUT')

                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                            <div class="form-group">
                                                                <label for="title">Title</label>
                                                                <input type="text" name="title" class="form-control" value="{{ $note->title }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="content">Content</label>
                                                                <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $note->content }}</textarea>
                                                            </div>

                                                            @foreach($categories as $category)
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="categories[]" class="form-check-input" id="categories" value="{{ $category->id }}"
                                                                           @foreach($note->categories as $c)
                                                                               @if($category->id == $c->id)
                                                                                   checked
                                                                                @endif
                                                                            @endforeach>
                                                                    <label class="form-check-label" for="categories">{{ $category->name }}</label>
                                                                </div>
                                                            @endforeach

                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-success" name="btn-update-note">Update note</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <!-- Modal for every note info display from authenticated user -->
                                <div class="modal fade" id="showNoteInfoModal{{ $note->id }}" tabindex="-1" aria-labelledby="showNoteInfoModal{{ $note->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Notes info</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>{{ $note->title }}</h4>
                                                <p>{{ $note->content }}</p>
                                                <hr>
                                                <p class="muted">Categories:
                                                    <ul>
                                                        @foreach($note->categories as $category)
                                                            <li>{{ $category->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        @empty
                            <p>You don't have any notes yet!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
