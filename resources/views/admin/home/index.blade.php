@extends('admin.admin_master')

@section('admin')

    <div class="py-12">
        <div class="container-fluid">
            <div class="row">
                <h4>Home About</h4>
                <a href="{{ route('add.about') }}" class="btn btn-info ml-auto" >Add About</a>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">All About Data</div>

                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col" width="5%">SL</th>
                                <th scope="col" width="5%">Home Title</th>
                                <th scope="col" width="5%">Short Description</th>
                                <th style="text-decoration: justify" scope="col" width="5%">Long Description</th>
                                <th scope="col" width="5%">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach ( $homeabout as $about)
                                <tr>
                                    <th scope="row">{{ $i++}}</th>
                                    <td>{{ $about->title }}</td>
                                    <td>{{ $about->short_dis }}</td>
                                    <td>{{ $about->long_dis }}</td>
                                    <td>
                                        <a href=" {{ url('about/edit/'.$about->id) }}" class="btn btn-info">Edit</a>
                                        <a href="{{ url('about/delete/'.$about->id) }} " onclick="return confirm('Are you sure to delete?')" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
