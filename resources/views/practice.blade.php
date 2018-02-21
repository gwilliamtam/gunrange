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
                                    <div class="practice-element" data-img="/loc_images/{{ $practice->location->photo }}" data-name="{{ $practice->location->name }}" data-id="{{ $practice->id }}" data-type="location">
                                        <img src="/loc_images/{{ $practice->location->photo }}">
                                    </div>
                                @endif
                                @if($practice->gear)
                                    <div class="practice-element" data-img="/gear_images/{{ $practice->gear->photo }}" data-name="{{ $practice->gear->name }}" data-id="{{ $practice->id }}" data-type="gear">
                                        <img src="/gear_images/{{ $practice->gear->photo }}">
                                    </div>
                                @endif
                                @if($practice->ammo)
                                    <div class="practice-element" data-img="/ammo_images/{{ $practice->ammo->photo }}" data-name="{{ $practice->ammo->name }}" data-id="{{ $practice->id }}" data-type="ammo">
                                        <img src="/ammo_images/{{ $practice->ammo->photo }}">
                                    </div>
                                @endif

                                @foreach($practice->targets as $target)
                                    <div class="target-element" style="background-image: url('/target_images/{{ $target->photo }}');" data-img="{{ $target->photo }}" data-value="{{ $target->value }}" data-rounds="{{ $target->rounds }}" data-id="{{ $target->id }}">
                                        @if(!empty($target->value))
                                            <div class="target-value">
                                                {{ $target->value }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
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

            {{-- FORM TO ADD PRACTICE --}}
            <div class="modal" tabindex="-1" role="dialog" id="add-practice-modal">
                <form action="{{ route('practice.save') }}" method="post" id="practice-form">
                    <input type="hidden" name="practiceId" value="">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Practice</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                @include("partials.date-picker", [
                                    "dateField" => "date-time"
                                ])

                                {{-- Practice Date Time --}}
                                <div class="form-group">
                                    <input type="text" class="form-control" name="date_time" id="date-time" aria-describedby="dateTimeHelp" placeholder="Enter date and time" value="{{ date("l, Y-m-d H:i") }}">
                                    <small id="dateTimeHelp" class="form-text text-muted">You must enter date and time of practice (require)</small>
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
                                    <input type="text" class="form-control" name="value" id="value" aria-describedby="valueHelp" placeholder="Enter target value">
                                    <small id="valueHelp" class="form-text text-muted">You may enter the target value(optional)</small>
                                </div>

                                {{-- Rounds --}}
                                <div class="form-group">
                                    <input type="text" class="form-control" name="rounds" id="value" aria-describedby="roundsHelp" placeholder="Enter number or rounds">
                                    <small id="valueHelp" class="form-text text-muted">You may enter the number of rounds used(optional)</small>
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

            <div class="modal" tabindex="-1" role="dialog" id="view-modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="hidden" id="view-id" value="">
                        <input type="hidden" id="view-type" value="">
                        <div class="modal-body view-modal-img-container">
                            <img id="view-target-image">
                            {{-- Target Value --}}
                            <div class="form-group" id="edit-target-value">
                                <input type="text" class="form-control" name="value" id="targetValue" aria-describedby="valueHelp" placeholder="Enter target value">
                                <small id="valueHelp" class="form-text text-muted">You may enter the target value (optional)</small>
                            </div>
                            {{-- Target Value --}}
                            <div class="form-group" id="edit-target-rounds">
                                <input type="text" class="form-control" name="value" id="targetRounds" aria-describedby="roundsHelp" placeholder="Enter number of rounds">
                                <small id="roundsHelp" class="form-text text-muted">You may enter the number of rounds used (optional)</small>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark">Save</button>
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Remove</button>
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>
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
                setSliders(this.parentElement.attributes['data-json'].value)
                $(".modal-title").html("Edit Practice")

                $("#practice-form input[name=practiceId]").val(practice.id)
                $("#practice-form input[name=date_time]").val(practice.date_time)
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
                var name =  this.attributes['data-name'].value
                var id =  this.attributes['data-id'].value
                var type =  this.attributes['data-type'].value
                $("#view-id").val(id)
                $("#view-type").val(type)
                $("#view-target-image").attr("src", image)
                $("#edit-target-value").hide()
                $("#edit-target-rounds").hide()
                $("#view-modal .modal-title").html(name)
                $("#view-modal").modal("show")
            })

            $(".target-element").on("click", function(){
                var image = this.attributes['data-img'].value
                var targetValue = this.attributes['data-value'].value
                var targetRounds = this.attributes['data-rounds'].value
                var id =  this.attributes['data-id'].value
                $("#view-id").val(id)
                console.log(image, targetValue, image.length, targetValue.length)
                if(image.length>0){
                    $("#view-target-image").attr("src", "/target_images/" +  image)
                    $("#view-target-image").show()
                }else{
                    $("#view-target-image").hide()
                }

                    $("#targetValue").val(targetValue)
                    $("#edit-target-value").show()


                    $("#targetRounds").val(targetRounds)
                    $("#edit-target-rounds").show()


                $("#view-modal .modal-title").html('Target')
                $("#view-modal").modal("show")
            })
        })
    </script>

@endsection

