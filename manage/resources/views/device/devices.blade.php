@extends('layout.loggedin')

@section('loggedin_content')

	<div class="container">
		@include('common.messages')

		<div class="right">
			<a class="waves-effect btn blue" href="{{ route('device.create') }}">
				<i class="material-icons left">add</i>Device
			</a>
		</div>

		<h2>All Devices</h2>
		
		@if (count($devices) > 0)

			@foreach($devices as $device)
				<div class="row">
					<div class="col s12">
						<div class="card-panel hoverable">
							<div class="row">
								<span style="font-size: 1.64rem">{{ $device->deviceType->name }}: <b>{{ $device->name }}</b></span>

								<div class="right">
									{!!Form::open(['action' => ['DeviceController@destroy', $device->device_id], 'method' => 'POST'])!!}
										<a class="waves-effect btn blue" href="{{ route('device.edit', $device->device_id) }}"><i class="material-icons">edit</i></a>
										{{Form::hidden('_method', 'DELETE')}}
										{{Form::button('<i class="material-icons">delete</i>', ['type' => 'submit', 'class' => 'waves-effect btn blue'], false)}}
									{!!Form::close()!!}
								</div>
							</div>

							<div class="row">
								<div class="col s12">
									<b>Features and MQTT-Topics:</b>
								</div>
								@foreach($device->traits as $trait)
								<div class="col s12 m12 l2 valign-wrapper">
									<div>{{ $trait->name }}</div>
								</div>
								<div class="col s12 m6 l5">
									<input type="text" readonly value="{{ 'gBridge/u' . Auth::user()->user_id . '/d' . $device->device_id . '/' . strtolower($trait->shortname) }}">
								</div>
								<div class="col s12 m6 l5">
									<input type="text" readonly value="{{ 'gBridge/u' . Auth::user()->user_id . '/d' . $device->device_id . '/' . strtolower($trait->shortname) . '/set' }}">
								</div>
								@endforeach
							</div>
							
						</div>
					</div>
				</div>
			@endforeach
		@else
			{{-- See https://github.com/Dogfalo/materialize/issues/2340 for dialogs --}}
			<div class="card-panel green white-text">
				No devices created yet.<br>
				Let's add one by pressing the Button above!
			</div>
		@endif
	</div>

@endsection