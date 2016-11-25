

@extends('layout.landlord')

@section('content')


<?php $landlord = \App\Landlord::where('idPerson', '=', \Auth::user()->idPerson)->first();
$data = unserialize($landlord->contact_away);
$first_day = $data['first_day'];
$last_day = $data['last_day']; 

$hours=unserialize($landlord->contact_time);

?>

{{$errors->first('wrong')}}

<div class="row profile" id="changeAvailabilities">

	<div>
		<div class="col-md-12">
			<h3>@lang('landlord.availabilities')</h3>		
			<div class="col-md-6" style="width:100%">
				<div class="col-md-6" style="width:100%">
					<form>
						<input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
						<div>
							<div class="form-group dropdown" style="display:inline-block;">
								<button id="monday" style="display:inline;float: left;" class="dropdown-toggle btn btn-viaflats" data-toggle="dropdown">@lang('landlord.monday')<span 	class="caret"></span></button>
							</div>
							<div class="form-group dropdown" style="display:inline-block;">
								<button id="tuesday" style="display:inline;float: left" class="dropdown-toggle btn btn-viaflats" data-toggle="dropdown">@lang('landlord.tuesday')<span class="caret"></span></button>
							</div>
							<div class="form-group dropdown" style="display:inline-block;">
								<button id="wednesday" style="display:inline;float: left" class="dropdown-toggle btn btn-viaflats" data-toggle="dropdown">@lang('landlord.wednesday')<span class="caret"></span></button>
							</div>
							<div class="form-group dropdown" style="display:inline-block;">
								<button id="thursday" style="display:inline;float: left" class="dropdown-toggle btn btn-viaflats" data-toggle="dropdown">@lang('landlord.thursday')<span class="caret"></span></button>
							</div>
							<div class="form-group dropdown" style="display:inline-block;">
								<button id="friday" style="display:inline;float: left" class="dropdown-toggle btn btn-viaflats" data-toggle="dropdown">@lang('landlord.friday')<span class="caret"></span></button>
							</div>
							<div class="form-group dropdown" style="display:inline-block;">
								<button id="saturday" style="display:inline;float: left" class="dropdown-toggle btn btn-viaflats" data-toggle="dropdown">@lang('landlord.saturday')<span class="caret"></span></button>
							</div>
							<div class="form-group dropdown" style="display:inline-block;">
								<button id="sunday" style="display:inline;float: left" class="dropdown-toggle btn btn-viaflats" data-toggle="dropdown">@lang('landlord.sunday')<span class="caret"></span></button>
							</div>
							<div class="form-group" style="display:inline-block;">
								<a id="showhideall" style="display:inline;float: left" class=" btn btn-viaflats">@lang('landlord.btnshow')</a>
							</div>
						</div>
						<div class="form-group" style="display:inline-block; width:100%;">
							@for($i=0; $i < 7; $i++)
							@if($i==0)
							<?php $day = "monday"; ?>
							@elseif($i==1)
							<?php $day = "tuesday"; ?>
							@elseif($i==2)
							<?php $day = "wednesday"; ?>
							@elseif($i==3)
							<?php $day = "thursday"; ?>
							@elseif($i==4)
							<?php $day = "friday"; ?>
							@elseif($i==5)
							<?php $day = "saturday"; ?>
							@elseif($i==6)
							<?php $day = "sunday"; ?>
							@endif
							<div class="{{$day}} selectable" style="float:left; display:none; width:100%;">
								<i id="{{$day}}_change" class="viaflats-text-day" style="float:left;">
									@lang("landlord.".$day."_availability")
								</i>
								@for ($j=23; $j >= 0; $j--)
								@if($hours[$day."_".$j]==1)
								<div id="{{$day}}_{{$j}}" class="hour {{$day}}hour {{$day}}_{{$j}}" style="background-color: #42f45c" on="1">
									@else
									<div id="{{$day}}_{{$j}}" class="hour {{$day}}hour {{$day}}_{{$j}}">
										@endif
										@if($j < 10)
										0{{$j}}h
										@else
										{{$j}}h
										@endif
									</div>
									@endfor
								</div>
								@endfor
							</div>
							<div class="form-group" style="display:inline-block; width:100%; text-align: center;">
								<a id="fillall" style="display:none; float:left;" class=" btn btn-viaflats">@lang('landlord.fillall')</a>
								<a id="cancelall" style="display:none; float:center;" class="btn btn-viaflats">@lang('landlord.cancelall')</a>
								<a id="cancel" style="display:none; float:center;" class="btn btn-viaflats">@lang('landlord.cancel')</a>
								<a id="clearall" style="display:none; float:right;" class="btn btn-viaflats">@lang('landlord.clearall')</a>
							</div>
							<div>
								<input type="button" id="submithours" value="@lang('landlord.update')" class="btn btn-viaflats">
							</div>
						</form>
					</div>
				</div>

				<h3>@lang('landlord.absence')</h3>

				<form id="updateAbsences" action="update_absences" method="post">

					<div class="col-md-6">
						<div class="col-md-6">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-group @if ($errors->has('absence_begin') || $errors->has('wrong')) has-error @endif">
								<label>@lang('landlord.absence_begin')</label>
								<input id="absence_begin" class="datepicker" type="text" class="form-control" name="absence_begin" value="<?php echo $first_day; ?>">
								@if ($errors->has('absence_begin')){{ $errors->first('absence_begin') }} @endif
							</div>
							<div class="form-group @if ($errors->has('absence_end') || $errors->has('wrong')) has-error @endif">
								<label>@lang('landlord.absence_end')</label>
								<input id="absence_end" class="datepicker" type="text" class="form-control" name="absence_end" value="<?php echo $last_day; ?>">
								@if ($errors->has('absence_end')){{ $errors->first('absence_end') }} @endif
							</div>
							<button type="submit" class="btn btn-viaflats">@lang('landlord.update')</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>


	<script>
		var down = false;
		var monday = false;
		var tuesday = false;
		var wednesday = false;
		var thursday = false;
		var friday = false;
		var saturday = false;
		var sunday = false;
		var showhideall = true;
		var displayedbtns = false;
		var last_entry_exists = false;
		$(document).mousedown(function() {
			down = true;
		}).mouseup(function() {
			$('.hour').attr('selected', null);
			down = false;  
		});
		$('.selectable').disableSelection();
		$('#submithours').click(function(){
			var form = document.createElement("form");
			form.setAttribute("method", "post");
			form.setAttribute("action", "update_availabilities");

			for(i=0;i<7;i++)
			{
				switch(i)
				{
					case 0 : var week_day = "monday"; break;
					case 1 : var week_day = "tuesday"; break;
					case 2 : var week_day = "wednesday"; break;
					case 3 : var week_day = "thursday"; break;
					case 4 : var week_day = "friday"; break;
					case 5 : var week_day = "saturday"; break;
					default : var week_day = "sunday"; break;
				}
				for(j=0;j<24;j++)
				{
					var field=document.createElement("input");
					field.setAttribute("type", "hidden");
					field.setAttribute("name", week_day+"_"+j);
					field.setAttribute("value", $("#"+week_day+"_"+j).attr('on'));
					form.append(field);
				}
			}

			var field = document.createElement("input");
			field.setAttribute("type", "hidden");
			field.setAttribute("name", "_token");
			field.setAttribute("value", "{{ csrf_token() }}");


			form.appendChild(field);

			document.body.appendChild(form);
			form.submit();	
		});
		function showOrHideButtons(){
			var visibleElements = 0;
			var data_days=[monday,tuesday,wednesday,thursday,friday,saturday,sunday];
			data_days.forEach(function(day)
			{
				if(day)
					visibleElements++;
			});

			if((visibleElements==0 && displayedbtns==true) || (visibleElements>0 && displayedbtns==false))
			{
				$('#fillall').fadeToggle("fast", "linear");
				$('#cancel').fadeToggle("fast", "linear");
				$('#cancelall').fadeToggle("fast", "linear");
				$('#clearall').fadeToggle("fast", "linear");
			}
			if(displayedbtns==false && visibleElements>0)
			{
				displayedbtns=true;
			}
			else if (displayedbtns==true && visibleElements==0)
			{
				displayedbtns=false;
			}
		}
		function checkAll(){
			var visibleElements = 0;
			var data_days=[monday,tuesday,wednesday,thursday,friday,saturday,sunday];
			data_days.forEach(function(day)
			{
				if(day)
					visibleElements++;
			});
			if(visibleElements==7)
			{
				showhideall=false;
				$('#showhideall').text("{{trans('landlord.btnhide')}}");
			}
			else
			{
				showhideall=true;
				$('#showhideall').text("{{trans('landlord.btnshow')}}");	
			}
		}
		$('#monday_change').click(function(){
			$('.hour').attr("last_entry", null);
			$('.mondayhour').css('background-color','#42f45c');
			$('.mondayhour').each(function(){
				if($(this).attr('on')!=1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.mondayhour').attr('on', 1);

		});
		$('#tuesday_change').click(function(){
			$('.hour').attr("last_entry", null);
			$('.tuesdayhour').css('background-color','#42f45c');
			$('.tuesdayhour').each(function(){
				if($(this).attr('on')!=1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.tuesdayhour').attr('on', 1);
		});
		$('#wednesday_change').click(function(){
			$('.hour').attr("last_entry", null);
			$('.wednesdayhour').css('background-color','#42f45c');
			$('.wednesdayhour').each(function(){
				if($(this).attr('on')!=1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.wednesdayhour').attr('on', 1);
		});
		$('#thursday_change').click(function(){
			$('.hour').attr("last_entry", null);
			$('.thursdayhour').css('background-color','#42f45c');
			$('.thursdayhour').each(function(){
				if($(this).attr('on')!=1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.thursdayhour').attr('on', 1);
		});
		$('#friday_change').click(function(){
			$('.hour').attr("last_entry", null);
			$('.fridayhour').css('background-color','#42f45c');
			$('.fridayhour').each(function(){
				if($(this).attr('on')!=1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.fridayhour').attr('on', 1);
		});
		$('#saturday_change').click(function(){
			$('.hour').attr("last_entry", null);
			$('.saturdayhour').css('background-color','#42f45c');
			$('.saturdayhour').each(function(){
				if($(this).attr('on')!=1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.saturdayhour').attr('on', 1);
		});
		$('#sunday_change').click(function(){
			$('.hour').attr("last_entry", null);
			$('.sundayhour').css('background-color','#42f45c');
			$('.sundayhour').each(function(){
				if($(this).attr('on')!=1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.sundayhour').attr('on', 1);
		});

		$('#fillall').click(function(){
			$('.hour').attr("last_entry", null);
			$('.hour').css('background-color','#42f45c');
			$('.hour').each(function(){
				if($(this).attr('on')!=1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.hour').attr('on', '1');
		});
		$('#cancel').click(function(){
			$('.hour').each(function(){
				if($(this).attr('last_entry')==1)
				{
					if($(this).attr('on')==1)
					{
						$(this).css('background-color','#fff');
						$(this).attr('on', null);
					}
					else
					{
						$(this).css('background-color','#42f45c');
						$(this).attr('on', 1);
					}
				}
			});
		});
		$('#cancelall').click(function(){
			var day="";
			var hours = <?php echo json_encode($hours); ?>;
			for(var i=0; i<7; i++)
			{
				switch (i) {
					case 0:
					day="monday";
					break;
					case 1:
					day="tuesday";
					break;
					case 2:
					day="wednesday";
					break;
					case 3:
					day="thursday";
					break;
					case 4:
					day="friday";
					break;
					case 5:
					day="saturday";
					break;
					case 6:
					day="sunday";
					break;
				}
				var hour;
				for(var j=0; j<24; j++)
				{
					hour=hours[day+'_'+j];
					if(hour==1)
					{
						$('#'+day+"_"+j).css('background-color','#42f45c');
						if($('#'+day+"_"+j).attr('on')!=1)
							$('#'+day+"_"+j).attr('last_entry', 1);
						$('#'+day+"_"+j).attr('on', 1);
					}
					else
					{
						$('#'+day+"_"+j).css('background-color','#fff');
						if($('#'+day+"_"+j).attr('on')==1)
							$('#'+day+"_"+j).attr('last_entry', 1);
						$('#'+day+"_"+j).attr('on', null);
					}
				}
			}
		});
		$('#clearall').click(function(){
			$('.hour').attr("last_entry", null);
			$('.hour').css('background-color','#fff');
			$('.hour').each(function(){
				if($(this).attr('on')==1)
				{
					$(this).attr('last_entry', 1);
				}
			});
			$('.hour').attr('on', null);
		});
		$('#monday').click(function(){
			$('.selectable.monday').fadeToggle("fast", "linear");
			if(monday)
			{
				$('#monday').attr('class', 'dropdown btn btn-viaflats');
				monday=false;
			}
			else
			{
				$('#monday').attr('class', 'dropup btn btn-viaflats');
				monday=true;
			}
			showOrHideButtons();
			checkAll();
		});
		$('#tuesday').click(function(){
			$('.selectable.tuesday').fadeToggle("fast", "linear");
			if(tuesday)
			{
				$('#tuesday').attr('class', 'dropdown btn btn-viaflats');
				tuesday=false;
			}
			else
			{
				$('#tuesday').attr('class', 'dropup btn btn-viaflats');
				tuesday=true;
			}
			showOrHideButtons();
			checkAll();
		});
		$('#wednesday').click(function(){
			$('.selectable.wednesday').fadeToggle("fast", "linear");
			if(wednesday)
			{
				$('#wednesday').attr('class', 'dropdown btn btn-viaflats');
				wednesday=false;
			}
			else
			{
				$('#wednesday').attr('class', 'dropup btn btn-viaflats');
				wednesday=true;
			}
			showOrHideButtons();
			checkAll();
		});
		$('#thursday').click(function(){
			$('.selectable.thursday').fadeToggle("fast", "linear");
			if(thursday)
			{
				$('#thursday').attr('class', 'dropdown btn btn-viaflats');
				thursday=false;
			}
			else
			{
				$('#thursday').attr('class', 'dropup btn btn-viaflats');
				thursday=true;
			}
			showOrHideButtons();
			checkAll();
		});
		$('#friday').click(function(){
			$('.selectable.friday').fadeToggle("fast", "linear");
			if(friday)
			{
				$('#friday').attr('class', 'dropdown btn btn-viaflats');
				friday=false;
			}
			else
			{
				$('#friday').attr('class', 'dropup btn btn-viaflats');
				friday=true;
			}
			showOrHideButtons();
			checkAll();
		});
		$('#saturday').click(function(){
			$('.selectable.saturday').fadeToggle("fast", "linear");
			if(saturday)
			{
				$('#saturday').attr('class', 'dropdown btn btn-viaflats');
				saturday=false;
			}
			else
			{
				$('#saturday').attr('class', 'dropup btn btn-viaflats');
				saturday=true;
			}
			showOrHideButtons();
			checkAll();
		});
		$('#sunday').click(function(){
			$('.selectable.sunday').fadeToggle("fast", "linear");
			if(sunday)
			{
				$('#sunday').attr('class', 'dropdown btn btn-viaflats');
				sunday=false;
			}
			else
			{
				$('#sunday').attr('class', 'dropup btn btn-viaflats');
				sunday=true;
			}
			showOrHideButtons();
			checkAll();
		});
		$('#showhideall').click(function(){
			if(showhideall)
			{
				$('.selectable').each(function(i){
					if($(this).css('display')=="none")
					{
						$(this).fadeToggle("fast", "linear");
						showhideall=false;
						$('#showhideall').text("{{trans('landlord.btnhide')}}");
					}
					switch(i)
					{
						case 0 :  
						$('#monday').attr('class', 'dropup btn btn-viaflats');
						monday=true;
						break;
						case 1 : 
						$('#tuesday').attr('class', 'dropup btn btn-viaflats');
						tuesday=true;
						break;
						case 2 : 
						$('#wednesday').attr('class', 'dropup btn btn-viaflats');
						wednesday=true;
						break;
						case 3 : 
						$('#thursday').attr('class', 'dropup btn btn-viaflats');
						thursday=true;
						break;
						case 4 : 
						$('#friday').attr('class', 'dropup btn btn-viaflats');
						friday=true;
						break;
						case 5 : 
						$('#saturday').attr('class', 'dropup btn btn-viaflats');
						saturday=true;
						break;
						case 6 : 
						$('#sunday').attr('class', 'dropup btn btn-viaflats');
						sunday=true; 
						break;

					}
				});
			}
			else
			{
				$('.selectable').each(function(i){
					if($(this).css('display')!="none")
					{
						$(this).fadeToggle("fast", "linear");
						showhideall=true;
						$('#showhideall').text("{{trans('landlord.btnshow')}}");
					}
					switch(i)
					{
						case 0 :  
						$('#monday').attr('class', 'dropdown btn btn-viaflats');
						monday=false;
						break;
						case 1 : 
						$('#tuesday').attr('class', 'dropdown btn btn-viaflats');
						tuesday=false;
						break;
						case 2 : 
						$('#wednesday').attr('class', 'dropdown btn btn-viaflats');
						wednesday=false;
						break;
						case 3 : 
						$('#thursday').attr('class', 'dropdown btn btn-viaflats');
						thursday=false;
						break;
						case 4 : 
						$('#friday').attr('class', 'dropdown btn btn-viaflats');
						friday=false;
						break;
						case 5 : 
						$('#saturday').attr('class', 'dropdown btn btn-viaflats');
						saturday=false;
						break;
						case 6 : 
						$('#sunday').attr('class', 'dropdown btn btn-viaflats');
						sunday=false; 
						break;

					}
				});
			}
			showOrHideButtons();
		});
		$('.hour').mousedown(function(){
			$('.hour').attr("last_entry", null);
			$(this).attr('last_entry', 1);
			if($(this).attr('on')==null)
			{
				$(this).css('background-color','#42f45c');
				$(this).attr('selected', 1);
				$(this).attr('on', 1);
			}
			else
			{
				$(this).css('background-color','#fff');
				$(this).attr('selected', 1);
				$(this).attr('on', null);
			}
		});
		$('.hour').hover(function(){

			if(down==true && $(this).attr('selected')==null){
				var selected_items = 0;
				$('.hour').each(function(){
					if($(this).attr('selected'))
					{
						selected_items++;
					}
				})
				if(selected_items==0)
				{
					$('.hour').attr("last_entry", null);
				}
				$(this).attr('last_entry', 1);
				if($(this).attr('on')==null)
				{
					$(this).css('background-color','#42f45c');
					$(this).attr('selected', 1);
					$(this).attr('on', 1);
				}
				else
				{
					$(this).css('background-color','#fff');
					$(this).attr('selected', 1);
					$(this).attr('on', null);
				}
			}
		});
		$(document).ready(function(){
			$(".dropdown-toggle").dropdown();
		});
		$( function() {
			$( ".datepicker" ).datepicker();
		} );
	</script>
	@endsection