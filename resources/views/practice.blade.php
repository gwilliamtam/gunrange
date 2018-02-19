@extends('layouts.app')

@section('content')
    @include('partials.tabs', [
        'blade' => 'practice'
    ])

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <label id="add-practice-button" class="btn btn-dark my-2" style="width: 100%">Add Practice</label>
                </div>
            </div>
        </div>
    </section>

    <div class="album bg-light">
        <div class="container">

            <div class="row">
                @foreach($practices as $practice)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow card-practice-container">

                        <div class="card-practice-images">
                            @if($practice->location)
                                <div class="practice-element" data-img="/loc_images/{{ $practice->location->photo }}">
                                    <img src="/loc_images/{{ $practice->location->photo }}">
                                </div>
                            @endif
                            @if($practice->gear)
                                <div class="practice-element" data-img="/gear_images/{{ $practice->gear->photo }}">
                                    <img src="/gear_images/{{ $practice->gear->photo }}">
                                </div>
                            @endif
                            @if($practice->ammo)
                                <div class="practice-element" data-img="/ammo_images/{{ $practice->ammo->photo }}">
                                    <img src="/ammo_images/{{ $practice->ammo->photo }}">
                                </div>
                            @endif

                            @foreach($practice->targets as $target)
                                @if(empty($target->photo))
                                    <div class="practice-element">
                                @else
                                    <div class="practice-element" style="background-image: url('/target_images/{{ $target->photo }}');">
                                @endif
                                @if(!empty($target->value))
                                    <div class="target-value">
                                        {{ $target->value }}
                                    </div>
                                @endif
                                    </div>
                            @endforeach
                            {{--@for($i=1;$i<=20;$i++)--}}
                                    {{--<div class="practice-element">--}}
                                        {{--<img src="/images/targetTest.jpg">--}}
                                    {{--</div>--}}
                            {{--@endfor--}}
                        </div>


                        <div class="card-body">
                            <h4 class="card-text">{{ $practice->date_time }}</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group" data-id="{{ $practice->id }}" data-json="{{ json_encode($practice) }}">
                                    <button type="button" class="btn btn btn-dark target-action">
                                        <i class="fas fa-bullseye"></i>
                                    </button>
                                    <button type="button" class="btn btn btn-dark add-action">
                                        <i class="fas fa-plus"></i>
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

    {{-- FORM TO ADD TARGETS --}}
    <div class="modal" tabindex="-1" role="dialog" id="target-modal">
        <form action="{{ route('practice.addTarget') }}" method="post" enctype="multipart/form-data" id="target-form">
            <input type="hidden" name="practiceId" value="">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Target</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {{-- Target Value --}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="value" id="value" aria-describedby="value" placeholder="Enter target value">
                            <small id="valueHelp" class="form-text text-muted">You may enter the target value(optional)</small>
                        </div>

                        {{-- Photo Upload --}}
                        <div class="form-group">
                            <label for="photo" class="btn btn-outline-dark">Select Photo</label>
                            <input type="file" accept="image/*" style="visibility:hidden;" name="photo" id="photo">
                            <img id="photo-preview">
                            <small id="photoHelp" class="form-text text-muted">Add a photo of your target(optional)</small>
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

        {{-- FORM TO ADD TARGETS --}}
        <div class="modal" tabindex="-1" role="dialog" id="target-modal">
            <form action="{{ route('practice.addTarget') }}" method="post" enctype="multipart/form-data" id="target-form">
                <input type="hidden" name="practiceId" value="">
                <input type="hidden" value="{{ csrf_token() }}" name="_token">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Target</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            {{-- Target Value --}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="value" id="value" aria-describedby="value" placeholder="Enter target value">
                                <small id="valueHelp" class="form-text text-muted">You may enter the target value(optional)</small>
                            </div>

                            {{-- Photo Upload --}}
                            <div class="form-group">
                                <label for="photo" class="btn btn-outline-dark">Select Photo</label>
                                <input type="file" accept="image/*" style="visibility:hidden;" name="photo" id="photo">
                                <img id="photo-preview">
                                <small id="photoHelp" class="form-text text-muted">Add a photo of your target(optional)</small>
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
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="view-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){

            function blankForm()
            {
                $("#date-time").val('');
            }

            $("#add-practice-button").on("click", function(){
                $(".modal-title").html("Add Practice")
                $("#practice-form input[name=dateTime]").val()
                $("#add-practice-modal").modal("show")
            })

            $(".del-action").on("click", function(){
                if(confirm('You selected to remove a practice. Continue?')){
                    var dataId = this.parentElement.attributes['data-id'].value
                    document.location = '/practice/delete/' + dataId
                }
            })

            $(".edit-action").on("click", function(){
                var practice = JSON.parse(this.parentElement.attributes['data-json'].value)
                blankForm()
                $(".modal-title").html("Edit Practice")

                $("#practice-form input[name=dateTime]").val(practice.date_time)
                $("#practice-id").val(practice.id)

                $("#add-practice-modal").modal("show")
            })

            $(".add-action").on("click", function(){
                var practice = JSON.parse(this.parentElement.attributes['data-json'].value)
                document.location = "/practice/add/" + practice.id
            })

            $(".target-action").on("click", function(){
                var practice = JSON.parse(this.parentElement.attributes['data-json'].value)
                $("#target-form input[name=practiceId]").val(practice.id)
                $("#target-modal").modal("show")
            })

            $("#photo").on("change", function(){
                loadFile(event)
                $("#photo-changed").val(1)
            })

            var loadFile = function(event) {
                var preview = document.getElementById('photo-preview');
                preview.src = URL.createObjectURL(event.target.files[0]);
            }

            $(".practice-element").on("click", function(){
                var image = this.attributes['data-img'].value
                console.log(image)
                $("#view-modal .modal-body").html("<img class='view-model-img' src='" + image + "'>")
                $("#view-modal").modal("show")
            })
        })
    </script>

@endsection

