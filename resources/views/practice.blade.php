@extends('layouts.app')

@section('content')
    @include('partials.tabs', [
        'blade' => 'practice'
    ])

    @if(empty($pin))
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <label id="add-practice-button" class="btn btn-dark my-2" style="width: 100%">Add Practice</label>
                </div>
            </div>
        </div>
    </section>
    @endif

    <div class="album bg-light">
        <div class="container">

            <div class="row">
                @foreach($practices as $practice)
                    <a name="practice{{ $practice->id }}"></a>
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow card-practice-container" id="card{{$practice->id}}">

                            <div class="card-practice-images">
                                @if($practice->location)
                                    <div class="practice-element" id="loc{{ $practice->id }}" data-json="{{ json_encode($practice->location) }}" data-type="loc">
                                        <img src="/loc_images/{{ $practice->location->photo }}">
                                    </div>
                                @endif
                                @if($practice->gear)
                                    <div class="practice-element" id="gear{{ $practice->id }}" data-json="{{ json_encode($practice->gear) }}" data-type="gear">
                                        <img src="/gear_images/{{ $practice->gear->photo }}">
                                    </div>
                                @endif
                                @if($practice->ammo)
                                    <div class="practice-element" id="ammo{{ $practice->id }}" data-json="{{ json_encode($practice->ammo) }}" data-type="ammo">
                                        <img src="/ammo_images/{{ $practice->ammo->photo }}">
                                    </div>
                                @endif

                                @foreach($practice->targets as $target)
                                    @if(empty($target->photo))
                                    <div class="target-element" id="target{{ $target->id }}" data-json="{{ json_encode($target) }}">
                                    @else
                                    <div class="target-element" id="target{{ $target->id }}" style="background-image: url('/target_images/{{ $target->photo }}');" data-json="{{ json_encode($target) }}">
                                    @endif
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

                                        @if( empty($pinAmmo) && empty($pinGear) && empty($pinLocation))
                                        <button type="button" class="btn btn btn-dark add-action" >
                                        @else
                                        <button type="button" class="btn btn btn-success add-action" style="{{ empty($practice->ammo_id) || empty($practice->gear_id) || empty($practice->location->id) ? null :'display:none' }}">
                                        @endif
                                            <i class="fas fa-magic"></i>
                                        </button>

                                        <button type="button" class="btn btn btn-dark edit-action">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn btn-dark del-action" >
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @if($pin == $practice->id)
                                            <button type="button" class="btn btn btn-success unpin-action" >
                                                <i class="fas fa-unlock"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn btn-dark pin-action" >
                                                <i class="fas fa-lock"></i>
                                        </button>
                                        @endif
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
                            <button type="buton" class="btn btn-dark" id="button-view-save" data-dismiss="modal">Save</button>
                            <button type="button" class="btn btn-outline-dark" id="button-view-remove" data-dismiss="modal">Remove</button>
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
                if(event.target.files[0] != undefined){
                    preview.src = URL.createObjectURL(event.target.files[0]);
                }else{
                    preview.src = ''
                }
            }

            $(".practice-element").on("click", function(){
                var elementId = this.id
                var practiceElement = JSON.parse(this.attributes['data-json'].value)
                var type =  this.attributes['data-type'].value
                $("#view-id").val(elementId)
                $("#view-type").val(type)
                if(practiceElement.photo != null){
                    $("#view-target-image").attr("src", "/"+type+"_images/"+practiceElement.photo)
                    $("#view-target-image").show()
                }else{
                    $("#view-target-image").hide()
                }
                $("#edit-target-value").hide()
                $("#edit-target-rounds").hide()
                $("#button-view-save").hide()

                $("#view-modal .modal-title").html(practiceElement.name)
                $("#view-modal").modal("show")
            })

            $(".target-element").on("click", function(){
                var targetElement = JSON.parse(this.attributes['data-json'].value)
                console.log(targetElement)
                $("#view-id").val(targetElement.id)
                $("#view-type").val("target")
                if(targetElement.photo != null){
                    $("#view-target-image").attr("src", "/target_images/" +  targetElement.photo)
                    $("#view-target-image").show()
                }else{
                    $("#view-target-image").hide()
                }

                $("#targetValue").val(targetElement.value)
                $("#edit-target-value").show()


                $("#targetRounds").val(targetElement.rounds)
                $("#edit-target-rounds").show()


                $("#view-modal .modal-title").html('Target')

                $("#button-view-save").show()
                $("#view-modal").modal("show")
            })

            $("#button-view-save").on("click", function(){
                var type = $("#view-type").val()
                var id = $("#view-id").val()
                var url = "/target/update/" + id
                var rounds = $("#targetRounds").val()
                var value = $("#targetValue").val()
                var data = {
                    "rounds": rounds,
                    "value": value
                }
                $.ajax({
                    url: url,
                    data: data,
                    context: document.body,
                    success: function(returnData){
                        console.log(returnData)
                        $("#target"+id).attr('data-json', JSON.stringify(returnData))
                    }
                }).done(function() {
                    $("#view-modal").modal("hide")
                    $("#target"+id+" .target-value").html(value)
                });

            })

            $("#button-view-remove").on("click", function(){
                var type = $("#view-type").val()
                if(type == "target"){
                    var url = "/target/remove/target/" + $("#view-id").val()
                    $.ajax({
                        url: url,
                        context: document.body
                    }).done(function() {
                        $("#view-modal").modal("hide")
                        var cardId = "#target"+$("#view-id").val()
                        $(cardId).remove()
                    });
                }else{
                    var url = "/target/remove/" + type + "/" + $("#view-id").val()
                    $.ajax({
                        url: url,
                        context: document.body
                    }).done(function() {
                        $("#view-modal").modal("hide")
                        var cardId = "#"+$("#view-id").val()
                        var parentId = $(cardId).parent().parent()[0].id
                        $(cardId).remove()
                        $("#"+parentId+ " .add-action").css('display','block')
                    });
                }
            })

            $(".pin-action").on("click", function(){
                var dataId = this.parentElement.attributes['data-id'].value
                setCookie("pinPractice", dataId);
                document.location = "/practice"
            })

            $(".unpin-action").on("click", function(){
                setCookie("pinPractice", '');
                document.location = "/practice"
            })
        })
    </script>

@endsection

