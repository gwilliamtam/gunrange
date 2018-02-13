@extends('layouts.app')

@section('content')

    <section class="locations-header jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Gun Range Locations</h1>
            <p class="lead text-muted">Use this seccion to store your gun range locations. You must use the name of the location, an you have the option to include a photo of the place or a Google Maps url.</p>
            <p>
                <button id="add-location-button" class="btn btn-primary my-2">Add a Location</button>
                {{--<a href="#" class="btn btn-secondary my-2">Open Google Maps</a>--}}
            </p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="images/eagle_gun_range.jpg" data-holder-rendered="true">
                        <div class="card-body">
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="add-location-modal">
        <form>
            <input type="hidden" value="{{ csrf_token() }}" name="_token">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {{-- Location Name --}}
                        <div class="form-group">
                            <label for="name">Location Name</label>
                            <input type="text" class="form-control" id="name" aria-describedby="name" placeholder="Enter location name">
                            <small id="nameHelp" class="form-text text-muted">You may enter the name of your gun range location (required)</small>
                        </div>


                        {{-- Photo Upload --}}
                        <div class="form-group">
                            <label for="photo" class="btn btn-primary">Select Photo</label>
                            <input type="file" accept="image/*" style="visibility:hidden;" name="photo" id="photo">
                            <img id="photo-preview">
                            <small id="photoHelp" class="form-text text-muted">Select a photo from your device for this location (optional)</small>
                        </div>

                        <div class="btn-group btn-group-toggle location-options-group" data-toggle="buttons" id="add-location-options">
                            <label class="btn btn-primary" id="address-input">
                                <input type="radio" autocomplete="off" checked> Address
                            </label>
                            <label class="btn btn-primary" id="map-input">
                                <input type="radio" autocomplete="off"> Map
                            </label>
                            <label class="btn btn-primary" id="coordinates-input">
                                <input type="radio" autocomplete="off"> Coordinates
                            </label>
                        </div>

                        {{-- Additional Fields Buttons--}}
                        <div class="form-group location-options" id="field-address-input">
                            <label for="address">Location Address</label>
                            <button type="button" class="close close-field">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <input type="text" class="form-control" id="address" aria-describedby="address" placeholder="Enter location address">
                            <small id="addressHelp" class="form-text text-muted">Type or paste here the full address of the location (optional)</small>
                        </div>

                        {{-- Additional Fields Inputs --}}
                        <div class="form-group location-options" id="field-map-input">
                            <label for="map">Map</label>
                            <button type="button" class="close close-field">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <input type="text" class="form-control" id="map" aria-describedby="map" placeholder="Enter Google Maps URL">
                            <small id="mapHelp" class="form-text text-muted">Paste here Google Maps URL for the location map (optional)</small>
                        </div>

                        <div class="form-group location-options" id="field-coordinates-input">
                            <label for="coordinates">Coordinates</label>
                            <button type="button" class="close close-field">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <input type="text" class="form-control" id="coordinates" aria-describedby="coordinates" placeholder="Enter s coordinates here">
                            <small id="coordinatesHelp" class="form-text text-muted">Paste here the coordinates of the location (optional)</small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){

            $("#add-location-button").on("click", function(){
                $(".location-options").hide()
                $(".location-options input").val('')
                $("#add-location-modal").modal("show")
            })

            $(".location-options-group .btn").on("click", function(){
                $(".location-options").hide()
                $(".location-options input").val('')
                var fieldTag = "#field-" + this.id
                $(fieldTag).toggle()
            })

            $(".close-field").on('click', function(){
                var fieldTag = '#'+this.parentElement.id
                $(fieldTag+ " input").val('')
                $(fieldTag).hide()
                $(".location-options-group label").removeClass('active')
            })

            $("#photo").on("change", function(){
                loadFile(event)
                console.log('photo changes')
            })

            var loadFile = function(event) {
                var preview = document.getElementById('photo-preview');
                preview.src = URL.createObjectURL(event.target.files[0]);
            };

        })
    </script>

@endsection

