@extends('layouts.app')

@section('content')

    @include('partials.tabs', [
        'blade' => 'ammo'
    ])

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <label id="add-ammo-button" class="btn btn-dark my-2" style="width: 100%">Add Ammo</label>
                </div>
            </div>
        </div>
    </section>

    <div class="album bg-light">
        <div class="container">

            <div class="row">
                @foreach($ammos as $ammo)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">

                        @if(empty($ammo->photo))
                            <div class="card-ammo-image">
                                <h1 class="text-center">{{ $ammo->name }}</h1>
                            </div>
                        @else
                            <div class="card-ammo-image" style="background-image: url('/ammo_images/{{ $ammo->photo }}');">
                            </div>
                        @endif

                        <div class="card-body">
                            <h4 class="card-text">{{ $ammo->name }}</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group" data-id="{{ $ammo->id }}" data-json="{{ json_encode($ammo) }}">
                                    <button type="button" class="btn btn btn-dark target-action">
                                        <i class="fas fa-bullseye"></i>
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

    <div class="modal" tabindex="-1" role="dialog" id="add-ammo-modal">
        <form action="{{ route('ammo.save') }}" method="post" enctype="multipart/form-data" id="ammo-form">
            <input type="hidden" id="ammo-id" name="ammoId" value="">
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

                        {{-- Ammo Name --}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Enter ammo name">
                            <small id="nameHelp" class="form-text text-muted">You may enter the name or any alias for your ammo(required)</small>
                        </div>


                        {{-- Photo Upload --}}
                        <div class="form-group">
                            <label for="photo" class="btn btn-outline-dark">Select Photo</label>
                            <input type="file" accept="image/*" style="visibility:hidden;" name="photo" id="photo">
                            <img id="photo-preview">
                            <small id="photoHelp" class="form-text text-muted">Select a photo from your device for this ammo (optional)</small>
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
                $(".ammo-options input").val('')
                var preview = document.getElementById('photo-preview');
                preview.src = '';
            }

            $("#add-ammo-button").on("click", function(){
                $(".ammo-options").hide()
                blankForm()
                $(".modal-title").html("Add Ammo")
                $("#add-ammo-modal").modal("show")
            })

            $(".ammo-options-group .btn").on("click", function(){
                var fieldTag = "#field-" + this.id
                $(fieldTag).show()
            })

            $(".close-field").on('click', function(){
                var fieldTag = '#'+this.parentElement.id
                $(fieldTag+ " input").val('')
                $(fieldTag).hide()
                $(".ammo-options-group label").removeClass('active')
            })

            $("#photo").on("change", function(){
                loadFile(event)
                $("#photo-changed").val(1)
            })

            var loadFile = function(event) {
                var preview = document.getElementById('photo-preview');
                preview.src = URL.createObjectURL(event.target.files[0]);
            }

            $(".del-action").on("click", function(){
                if(confirm('You select to remove a ammo. Continue?')){
                    var dataId = this.parentElement.attributes['data-id'].value
                    document.location = '/ammo/delete/' + dataId
                }
            })

            $(".edit-action").on("click", function(){
                var ammo = JSON.parse(this.parentElement.attributes['data-json'].value)
                $(".ammo-options").hide()
                blankForm()
                $(".modal-title").html("Edit Ammo")

                $("#ammo-form input[name=name]").val(ammo.name)
                $("#ammo-id").val(ammo.id)

                var preview = document.getElementById('photo-preview');
                preview.src = '/ammo_images/'+ammo.photo;

                $("#add-ammo-modal").modal("show")
            })

            $(".target-action").on("click", function(){
                var ammo = JSON.parse(this.parentElement.attributes['data-json'].value)
                setCookie("ammo", ammo.id);
            })
        })
    </script>

@endsection

