@extends('layout.landlord')


@section('content')

    <div class="row detail_property_wrapper">
        <div class="col-md-12">
            <h3>@lang('landlord.definition')</h3>
            <div class="row ">
                <div class="col-md-8">


                    {!! Form::open(['url' => 'definition_property', 'id' => 'definition_property']) !!}

                    {!! Form::hidden('ID', session('ID')) !!}
                    <h3>Pieces</h3>

                    {{ Form::select('pieces' ,$piecesList, null, ['class' => 'form-control', 'id' => 'pieces']) }}

                    @foreach($pieces as $piece)
                        <div id="div-{{$piece->idTypeRoom}}" style="display: none;">
                            <div class="form-group form-inline" style="margin-left: 15px; margin-top:15px">
                                <div class="col-md-3">
                                    {{ Form::label('number'.'['.$piece->idTypeRoom.']', trans('landlord.number'). ' :',
                                                                          ['class'=> 'control-label' ]) }}
                                </div>
                                <div class="input-group col-md-4">
                                    <div class="input-group-addon" id="decrement-number-{{$piece->idTypeRoom}}"
                                         style="cursor: pointer;font-size:1.2em;background-color: #9982bb;color:#ecf0f1">
                                        -
                                    </div>
                                    {!! Form::number('number'.'['.$piece->idTypeRoom.']', 0,
                                           ['class'=>'form-control', 'id'=>'number'.'-'.$piece->idTypeRoom.'', 'required'=> 'required']) !!}
                                    <div class="input-group-addon" id="increment-number-{{$piece->idTypeRoom}}"
                                         style="cursor: pointer;font-size: 1.2em;background-color: #9982bb;color:#ecf0f1">
                                        +
                                    </div>
                                </div>

                            </div>
                            <div id="sizeList{{$piece->idTypeRoom}}">
                                <div class="form-group form-inline sizefield-{{$piece->idTypeRoom}}1"
                                     style="margin-left: 15px; display:none">
                                    <div class="col-md-3" id="labelSize">
                                        {{ Form::label('size'.'['.$piece->idTypeRoom.']', trans('landlord.size'). ' n°1 :',
                                                                              ['class'=> 'control-label' ]) }}
                                    </div>
                                    <div class="input-group col-md-4">

                                        {!! Form::number('size'.'['.$piece->idTypeRoom.'][1]', 0,
                                               ['class'=>'form-control', 'id'=>'size'.'-'.$piece->idTypeRoom.'_1', 'required'=> 'required']) !!}
                                        <div class="input-group-addon"
                                             style="font-size: 1.2em;background-color: #9982bb;color:#ecf0f1">
                                            m²
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{--<div class="form-group col-md-12">--}}
                                {{--<div class="col-md-3">--}}
                                    {{--{{ Form::label('furnished-'.$piece->idTypeRoom.'', trans('landlord.furnished'). ' :',--}}
                                    {{--['class'=> 'control-label' ]) }}--}}
                                {{--</div>--}}

                                {{--<div class="col-md-4">--}}
                                    {{--{{ Form::select('furnished-'.$piece->idTypeRoom.'', ['1' => trans('landlord.yes'), '0' => trans('landlord.no')], 1,--}}
                                                        {{--['class' => 'form-control']) }}--}}

                                {{--</div>--}}

                            {{--</div>--}}
                            <div class="col-md-3 col-lg-push-2">
                                <button type="button" class="btn btn-viaflats" style="width:100%"
                                        onclick="addRecap({{$piece}})">Add
                                </button>
                                <br/>
                                <br/>
                            </div>


                        </div>

                    @endforeach
                    {{ Form::submit('Continue', ['class' => 'btn btn-default hover_viaflats form-control disabled' , 'id' => 'submit']) }}
                    {!! Form::close() !!}
                </div>{{--Fin col md 8--}}


                <div class="col-md-3" id="recap_details">

                    <div class="needHelp">
                        <h3>@lang('landlord.needhelp')</h3>
                        <p>@lang('landlord.needHelpText')</p>
                        <span style="display:block;width: 100%; color: #9982bb">06 12 52 32 52</span>
                        <a href="#"> <span style="display:block;width: 100%; ">viaflats@hotmail.com</span></a>
                    </div>
                    <div id="recap">
                        @foreach($pieces as $piece)
                            <div id="recapFurnished-{{$piece->idTypeRoom}}" style="display: none">
                                <span>@lang('landlord.furnished')</span>
                            </div>
                            <div id="recapUnfurnished-{{$piece->idTypeRoom}}" style="display: none">
                                <span>@lang('landlord.unfurnished')</span>
                            </div>
                        @endforeach
                    </div>
                </div> {{--Fin col md 3--}}


            </div>


        </div> {{--Fin class Row--}}

    </div> {{--Fin col md 12--}}
    </div> {{--Fin class Row--}}



    <script>

        var value = 0, label;
        $(".input-group-addon[id^='decrement-']").on("click", function () {
            label = this.id.split('-');
            decrement(label);
        });

        $(".input-group-addon[id^='increment-']").on("click", function () {
            label = this.id.split('-');
            increment(label);
        });

        function decrement(label) {
            value = $('#' + label[1] + '-' + label[2]).val();

            if (Math.floor(value) == value && $.isNumeric(value) && value > 0) {
                value = parseInt(value) - 1;
                if(value >= 0 ){
                    deleteSizeField(label[2]);
                }

            }
            else {
                value = 0;
            }
            $('#' + label[1] + '-' + label[2]).val(value);

        }

        function increment(label) {
            value = $('#' + label[1] + '-' + label[2]).val();

            if (Math.floor(value) == value && $.isNumeric(value)) {
                value = parseInt(value) + 1;
            }
            else {
                value = 0;
            }

            $('#' + label[1] + '-' + label[2]).val(value);

            if (value >= 1) {
                addSizeField(label[2]);
            }


        }


        $("#pieces").change(function () {
            var value = $(this).find(":selected").val();
            $("[id^='div-']").hide();
            $('#div-' + value).show();
        });

        function addRecap(piece) {
            $('#submit').removeClass('disabled');
            $.ajax({
                url: 'get_translation',
                data: 'index=' + piece.label,
                dataType: 'json',
                success: function (json) {
                    var contentLabel = json;
                    var contentVal = "";
                    var content = $('#recap').html() + "<h4>" + contentLabel + "</h4>";
                    content = content + "<span id='spanRecap-" + piece.idTypeRoom + "'>";


                    var numberVal = $('#number-' + piece.idTypeRoom).val();
                    contentVal = contentVal + contentLabel + " x " + numberVal + '<br/>';

                    for (var i = 1; i <= parseInt(numberVal); i++) {
                        var sizeVal = $('#size-' + piece.idTypeRoom + '_' + i).val();
                        contentVal = contentVal + 'n°' + i + ' ' + sizeVal + ' m²' + '<br/>';
                    }

                    var furnished = $('#furnished-' + piece.idTypeRoom).val();

                    if (furnished == 1) {
                        contentVal = contentVal + " " + $('#recapFurnished-' + piece.idTypeRoom).text() + '<br/>';
                    }
                    else {
                        contentVal = contentVal + " " + $('#recapUnfurnished-' + piece.idTypeRoom).text() + '<br/>';
                    }
                    content = content + contentVal + "</span><br/>";

                    if (!$('#spanRecap-' + piece.idTypeRoom).text() != "") {
                        $('#recap').html(content);
                    }
                    else {
                        html = $.parseHTML(contentVal);

                        $('#spanRecap-' + piece.idTypeRoom).html(html);

                    }
                }
            });

        }


        function update() {

            var pieces = [<?php echo json_encode($pieces)?>];
            $.each(pieces, function (index, value) {
               $.each(value, function (index, valueObj) {
                   var valNumb = $('#number-' + valueObj.idTypeRoom).val();
                   var valSize = $('#size-' + valueObj.idTypeRoom).val();
                    if (valNumb != 0 && valSize != 0){
                        addRecap(valueObj);
                    }
               })
            })
        }

        function addSizeField(id) {

                var numbVal = $('#number-' + id).val();
            if (numbVal != 1) {
                var copie = $('.sizefield-' + id + '1').clone();
                var label = copie.find('#labelSize').html();
                var idValue = copie.find('#size-' + id + '_1').attr('id');
                var name = copie.find('#size-' + id + '_1').attr('name');
                console.log(name);
                copie.removeClass('sizefield-' + id + '1');
                copie.addClass('sizefield-' + id + numbVal);

                label = label.replace('1', parseInt(numbVal));
                copie.find('#labelSize').html(label);

                name = name.replace('['+id+'][1]', '['+id+'][' + parseInt(numbVal) + ']');
                copie.find('#size-' + id + '_1').attr('name', name);

                idValue = idValue.replace('_1', '_' + parseInt(numbVal));
                copie.find('#size-' + id + '_1').attr('id', idValue);




                copie.css('display', 'block');

                copie.appendTo('#sizeList' + id);
            }
            else {
                $('.sizefield-' + id + '1').show();
            }


        }

        function deleteSizeField(id) {

            var numbVal = $('#number-' + id).val();
            if(numbVal == 1 ){
                $('.sizefield-' + id + '1').hide();
            }else{
                $('.sizefield-' + id + numbVal).remove();
            }
        }
    </script>

@endsection