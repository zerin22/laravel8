@extends('admin.admin_master')

@section('admin')

<div class="col-lg-12">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2>Update Slider</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('slider/update/'. $sliders->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="old_image" value="{{ $sliders->image }}">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Slider Title</label>
                    <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="Slider Title" value="{{ $sliders->title }}">

                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Slider Description</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"><?php echo ($sliders->description); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Slider Image</label>
                    <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" value="{{ $sliders->image }}">
                </div>

                <div class="form-group">
                    <img src="{{ asset( $sliders->image) }}" style="height: 300px; width:500px">
                </div>

                <div class="form-footer pt-4 pt-5 mt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-default">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection
