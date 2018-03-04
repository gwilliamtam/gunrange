@extends('layouts.app')

@section('content')
    @include('partials.tabs', [
        'blade' => 'gear'
    ])

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <label id="add-gear-button" class="btn btn-dark my-2" style="width: 100%">Add Firearm</label>
                </div>
            </div>
        </div>
    </section>

    <div class="album bg-light">
        <div class="container">

            <div class="row">
                @foreach($gears as $gear)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">

                        @if(empty($gear->photo))
                            <div class="card-gear-image">
                                <h1 class="text-center">{{ $gear->name }}</h1>
                            </div>
                        @else
                            <div class="card-gear-image" style="background-image: url('/gear_images/{{ $gear->photo }}');">
                            </div>
                        @endif

                        <div class="card-body">
                            <h4 class="card-text">{{ $gear->name }}</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group" data-id="{{ $gear->id }}" data-json="{{ json_encode($gear) }}">
                                    @if($pin == $gear->id)
                                    <button type="button" class="btn btn btn-success target-action">
                                    @else
                                    <button type="button" class="btn btn btn-dark target-action">
                                    @endif
                                        <i class="fas fa-thumbtack"></i>
                                    </button>
                                    <button type="button" class="btn btn btn-dark edit-action">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn btn-dark del-action" >
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="add-gear-modal">
        <form action="{{ route('gear.save') }}" method="post" enctype="multipart/form-data" id="gear-form">
            <input type="hidden" id="gear-id" name="gearId" value="">
            <input type="hidden" id="photo-changed" name="photoChanged" value=0>
            <input type="hidden" value="{{ csrf_token() }}" name="_token">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {{-- Gear Name --}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Enter firearm name">
                            <small id="nameHelp" class="form-text text-muted">You may enter the name or any alias for your firearm (optional)</small>
                        </div>


                        {{-- Photo Upload --}}
                        <div class="form-group">
                            <label for="photo" class="btn btn-outline-dark">Select Photo</label>
                            <input type="file" accept="image/*" style="visibility:hidden;" name="photo" id="photo">
                            <img id="photo-preview">
                            <small id="photoHelp" class="form-text text-muted">Select a photo from your device for this firearm (optional)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Save</button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){

            function blankForm()
            {
                $("#name").val('');
                $(".gear-options input").val('')
                var preview = document.getElementById('photo-preview');
                preview.src = '';
            }

            $("#add-gear-button").on("click", function(){
                $(".gear-options").hide()
                blankForm()
                $(".modal-title").html("Add Firearm")
                $("#add-gear-modal").modal("show")
            })

            $(".gear-options-group .btn").on("click", function(){
                var fieldTag = "#field-" + this.id
                $(fieldTag).show()
            })

            $(".close-field").on('click', function(){
                var fieldTag = '#'+this.parentElement.id
                $(fieldTag+ " input").val('')
                $(fieldTag).hide()
                $(".gear-options-group label").removeClass('active')
            })

            $("#photo").on("change", function(){
                loadFile(event)
                $("#photo-changed").val(1)
            })

            var loadFile = function(event) {
                var preview = document.getElementById('photo-preview');
                if(event.target.files[0] != undefined) {
                    preview.src = URL.createObjectURL(event.target.files[0]);
                }else{
                    preview.src = ''
                }
            }

            $(".del-action").on("click", function(){
                if(confirm('You select to remove a firearm. Continue?')){
                    var dataId = this.parentElement.attributes['data-id'].value
                    document.location = '/gear/delete/' + dataId
                }
            })

            $(".edit-action").on("click", function(){
                var gear = JSON.parse(this.parentElement.attributes['data-json'].value)
                $(".gear-options").hide()
                blankForm()
                $(".modal-title").html("Edit Firearm")

                $("#gear-form input[name=name]").val(gear.name)
                $("#gear-id").val(gear.id)

                var preview = document.getElementById('photo-preview');
                preview.src = '/gear_images/'+gear.photo;

                $("#add-gear-modal").modal("show")
            })

            $(".target-action").on("click", function(){
                console.log('target action')
                var gear = JSON.parse(this.parentElement.attributes['data-json'].value)
                $(".target-action").removeClass("btn-success");
                $(".target-action").addClass("btn-dark");
                $(this).removeClass("btn-dark")
                $(this).addClass("btn-success")
                setCookie("gear", gear.id);
            })
        })
    </script>

@endsection

