@extends('admin.admin_master')

@section('admin')

<div class="col-lg-12">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2>Create HomeService</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('store.service') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Service Title</label>
                    <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="Service Title">

                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Service Description</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Service Icon</label>
                    <input type="text" name="icon" class="form-control" id="exampleFormControlInput1" placeholder="Service Icon">
                </div>

                <div class="form-footer pt-4 pt-5 mt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-default">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
