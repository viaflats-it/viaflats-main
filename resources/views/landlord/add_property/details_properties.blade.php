@extends('layout.landlord')

@section('contenu')

    <div class="row profile">
        <div class="col-md-12">
            <h3>@lang('landlord.details')</h3>
            <div class="row ">
                <div class="col-md-8">
                    {!! Form::open(['url' => 'detail_property', 'id' => 'detail_property']) !!}
                    <h4>@lang('landlord.type')</h4>
                    <input type='radio' name='type' value='home' id="radio_home"/><label for="radio_home"></label>
                    <input type='radio' name='type' value='apartment' id="radio_apartment"/><label for="radio_apartment"></label>
                    <input type='radio' name='type' value='studio' id="radio_studio"/><label for="radio_studio"></label>
                    <div id="typeChoice"></div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#detail_property input').on('change', function() {
            var value = $('input[name=type]:checked', '#detail_property').val();
            switch (value)
            {
                case 'home':
                    var successContent = '<div class="alert alert-info"><span>{{trans('landlord.home')}}</span></div>';
                    $('#typeChoice').html(successContent);
                    break;
                case 'apartment' :
                    var successContent = '<div class="alert alert-info"><span>{{trans('landlord.apartment')}}</span></div>';
                    $('#typeChoice').html(successContent);
                        break;
                case 'studio':
                    var successContent = '<div class="alert alert-info"><span>{{trans('landlord.studio')}}</span></div>';
                    $('#typeChoice').html(successContent);
                    break;
                default:
                    break;
            }

        });
    </script>
@endsection