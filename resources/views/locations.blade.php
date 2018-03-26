@extends('layouts.app')

@section('content')

    @include('partials.tabs', [
        'blade' => 'locations'
    ])

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <label id="add-location-button" class="btn btn-dark my-2" style="width: 100%">Add a Location</label>
                </div>
                <div class="col-md-8">
                    <label class="my-3">Your <i class="fas fa-thumbtack fa-sm"></i> selection will be used by <i class="fas fa-magic fa-sm"></i> in Practice</label>
                </div>
            </div>
        </div>
    </section>

    <div class="album bg-light">
        <div class="container">

            <div class="row">
                @foreach($locations as $location)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">

                        @if(empty($location->photo))
                            <div class="card-location-image">
                                <h1 class="text-center">{{ $location->name }}</h1>
                            </div>
                        @else
                            <div class="card-location-image" style="background-image: url('/loc_images/{{ $location->photo }}');">
                            </div>
                        @endif

                        <div class="card-body">
                            <h4 class="card-text">{{ $location->name }}</h4>
                            @if(false and !empty($location->address))
                                <small class="text-muted">{{ $location->address }}</small>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group" data-id="{{ $location->id }}" data-json="{{ json_encode($location) }}">
                                    @if($pin == $location->id)
                                    <button type="button" class="btn btn btn-success target-action">
                                    @else
                                    <button type="button" class="btn btn btn-dark target-action">
                                    @endif
                                        <i class="fas fa-thumbtack"></i>
                                    </button>
                                    @php
                                    #<button type="button" class="btn btn btn-dark map-action">
                                    #    <i class="fas fa-map"></i>
                                    #</button>
                                    @endphp
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

    <div class="modal" tabindex="-1" role="dialog" id="add-location-modal">
        <form action="{{ route('locations.save') }}" method="post" enctype="multipart/form-data" id="location-form">
            <input type="hidden" id="location-id" name="locationId" value="">
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

                        {{-- Location Name --}}
                        <div class="form-group">
                            {{--<label for="name">Location Name</label>--}}
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Enter location name">
                            <small id="nameHelp" class="form-text text-muted">You may enter the name or any alias for your gun range location(required)</small>
                        </div>


                        {{-- Photo Upload --}}
                        <div class="form-group">
                            <label for="photo" class="btn btn-outline-dark">Select Photo</label>
                            <input type="file" accept="image/*" style="visibility:hidden;" name="photo" id="photo">
                            <img id="photo-preview">
                            <small id="photoHelp" class="form-text text-muted">Select a photo from your device for this location (optional)</small>
                        </div>

                        @php
                        #include("partials.locations-additional-fields")
                        @endphp

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
                $(".location-options input").val('')
                var preview = document.getElementById('photo-preview');
                preview.src = '';
            }

            $("#add-location-button").on("click", function(){
                $(".location-options").hide()
                blankForm()
                $(".modal-title").html("Add Location")
                $("#add-location-modal").modal("show")
            })

            $(".location-options-group .btn").on("click", function(){
                var fieldTag = "#field-" + this.id
                $(fieldTag).show()
            })

            $(".close-field").on('click', function(){
                var fieldTag = '#'+this.parentElement.id
                $(fieldTag+ " input").val('')
                $(fieldTag).hide()
                $(".location-options-group label").removeClass('active')
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
                if(confirm('You select to remove a location. Continue?')){
                    var dataId = this.parentElement.attributes['data-id'].value
                    document.location = '/locations/delete/' + dataId
                }
            })

            $(".edit-action").on("click", function(){
                var location = JSON.parse(this.parentElement.attributes['data-json'].value)
                $(".location-options").hide()
                blankForm()
                $(".modal-title").html("Edit Location")
console.log(location)
                $("#location-form input[name=name]").val(location.name)
                $("#location-id").val(location.id)
                if(location.address != null){
                    $("#address").val(location.address)
                    $("#field-address-input").show()
                }
                if(location.coordinates != null){
                    $("#coordinates").val(location.coordinates)
                    $("#field-coordinates-input").show()
                }
                if(location.map != null) {
                    $("#map").val(location.map)
                    $("#field-map-input").show()
                }

                var preview = document.getElementById('photo-preview');
                preview.src = '/loc_images/'+location.photo;

                $("#add-location-modal").modal("show")
            })

            $(".target-action").on("click", function(){
                var location = JSON.parse(this.parentElement.attributes['data-json'].value)
                $(".target-action").removeClass("btn-success");
                $(".target-action").addClass("btn-dark");
                $(this).removeClass("btn-dark")
                $(this).addClass("btn-success")
                setCookie("location", location.id);
            })
        })
    </script>

@endsection

