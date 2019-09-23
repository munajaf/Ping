@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fas fa-tachometer-alt"></i> @lang('navs.frontend.dashboard')
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="form-group">
                        {{ html()->form('POST', route('frontend.user.monitor.store'))->open() }}

                        {{ html()->text('url', '')
                                            ->class('form-control')
                                            ->placeholder('Foken url')
                                            ->attribute('maxlength', 191)
                                            ->required()
                                            ->autofocus() }}

                        <div class="row">
                            <div class="col">
                                <div class="form-group mt-3 clearfix">
                                    {{ form_submit('Set Url!') }}
                                </div>
                            </div>
                        </div>

                        {{ html()->form()->close() }}
                    </div>

                </div> <!-- card-body -->
            </div><!-- card -->

            <div class="card">
                <div class="card-header">
                    <h2>Your foken list Url</h2>
                </div>
                    <div class="card-body">
                        <table  class="table table-dark">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td class="col">Url</td>
{{--                                    <td class="col">Online Since</td>--}}
                                    <td class="col-2">Status</td>
                                    <td colspan="3" class="col-2 text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($monitors as $monitor)
                            <tr>
                                <td>{{$monitor->id}}</td>
                                <td><a href="{{ $monitor->url }}">{{ $monitor->url }}</a></td>
                                <td></td>
                                <td>{{($monitor->uptime_check_enabled) ? "Enabled":"Disabled"}}</td>
                                <td><a href="{{route('frontend.user.monitor.destroy', $monitor->id)}}">Delete</a></td>
                                <td><a href="{{route('frontend.user.monitor.enable', $monitor->id)}}">Enable</a></td>
                                <td><a href="{{route('frontend.user.monitor.disable', $monitor->id)}}">Disable</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div><!-- row -->
    </div><!-- row -->
@endsection
