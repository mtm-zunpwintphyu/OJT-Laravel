@extends('layouts.frame')
@section('content')
<style>
.table .thead-light th {
    color: white;
    background-color: #28739E;
    box-sizing: border-box;
    font-size: 18;
    font-family: 'Times New Roman', Times, serif;
}

td {
    font-size: 15;
    font-family: 'Times New Roman', Times, serif;
}

th {
    font-size: 15;
    font-family: 'Times New Roman', Times, serif;
}

.button {
    -moz-box-shadow: inset 0px 1px 0px 0px #3985B1;
    -webkit-box-shadow: inset 0px 1px 0px 0px #3985B1;
    box-shadow: inset 0px 1px 0px 0px #3985B1;
    background-color: #ffffff;
    border: 1px solid #17445E;
    display: inline-block;
    cursor: pointer;
    color: black;
    padding: 8px 18px;
    text-decoration: none;
    font: 12px Arial, Helvetica, sans-serif;
}

.switch {
    position: relative;
    display: inline-block;
    width: 45px;
    height: 22px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: 1px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 20px;
}

.slider.round:before {
    border-radius: 50%;
}

body {
    font-family: Arial, Helvetica, sans-serif;
}

/* The Modal (background) */
.modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    height: 60%;
    margin-left: 30%;
}

/* The Close Button */
.close {
    color: #990000;
    margin-left: 95%;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
<div class="container">
    <div align="center" style="text-shadow: 2px 2px 5px #FAB10C;">
        <!-- <h4>Laravel OJT Project Post</h4> -->
    </div>
    <?php 
        $title= isset($_GET['title'])?$_GET['title']:'';
    ?>
    <br>
    <form action="{{ url('post') }}" method="GET">
        <div class="row">
            <div class="col-md-2">
                <input type="search" name="title" class="form-control-sm" placeholder="Serach By Word..." value="">
            </div>
            <div class="col-md-1">
                <input type="submit" class="btn btn-primary btn-sm" value="Search">
            </div>
            <div class="col-md-7"></div>
            <div class="col-md-2">
                <div style="float:right">
                    <a class="btn btn-success btn-sm" href="{{ url('post/create') }}"><span
                            class="glyphicon glyphicon-plus"></span>Add Post</a>
                </div>
            </div>
        </div>
    </form>
    <br>
    <div style="overflow-x:auto;">
        @if(count($data)>0)
        <table class="table table-hover" style="text-shadow: 2px 2px 5px rgb(90, 216, 233);">
            <thead>
                <tr class="info">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created Time</th>
                    <th>Created User</th>
                    <th>Updated User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="td">
                @foreach ($data as $post)
                <tr>
                    <td>{{++$i}}</td>
                    <!-- <td>{{ $post->title}}</td> -->
                    <td>
                        <div id="myBtn"><a href="#">{{$post->title}}</a></div>
                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <p>Title:{{$post->title}}</p>
                                <p>Description:{{$post->description}}</p>
                                <p>Created User:{{$post->created_user_id}}</p>
                                <p>Updated User:{{$post->updated_user_id}}</p>
                                <p>Hello this is come herer</p>
                                <p></p>
                            </div>
                        </div>
                    </td>
                    <td>{{$post->description}}</td>
                    <!-- <td> <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                </td> -->
                    <td>
                        <input data-id="{{$post->id}}" class="toggle-class" type="checkbox" data-onstyle="success"
                            data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"
                            {{ $post->status ? 'checked' : '' }}>
                    </td>
                    <td>{{$post->created_at}}</td>
                    <td>{{$post->created_user_id}}</td>
                    <td>{{$post->updated_user_id}}</td>
                    <td>
                        <form action="{{ route('post_destroy',$post->id)}}" method="post"
                            onsubmit="return confirm('Do you want to delete?');">
                            @csrf @method('DELETE')
                            <a class="btn btn-sm btn-primary" href="{{ route('post_edit',$post->id)}}">
                                <i class="fas fa-edit" title="Edit"></i></a>
                            </a>
                            <button class="btn btn-sm btn-danger btn-sm" type="submit">
                                <i class="fa fa-fw fa-trash" title="Delete"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-center">
        <!-- {!! $data->appends(request()->input())->links() !!} -->
        </div>
        @else
        <h4 class="h4 pt-5 pb-3 text-info">Posts Not Found!....</h4>
        @endif
        <div class="col-md-2" style="float:left">
            <p style="font-size:15px"> Count:: {{$count}}</p>
        </div>
        <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var user_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/changeStatus',
                    data: {
                        'status': status,
                        'user_id': user_id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            })
        })
        </script>

        <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        </script>
        @endsection