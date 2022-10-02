@extends('admin.admin_master')

@section('admin')
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2>User Profile Update</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('update.user.profile') }}" method="POST" class="form-pill" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="exampleFormControlInput3">User Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput3">User Email</label>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <img class="rounded" src="{{ (!empty($user->profile_image))? url('image/profile/'.$user->profile_image): url('image/profile/default_img.jpg') }}" width="100px" >
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput3">User Image</label>
                    <input type="file" name="profile_image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary btn-default">Update </button>
            </form>
        </div>
    </div>
@endsection
