@extends('layouts.app')

@section('title', trans('subscription.subscriptions'))

@section('content')
<h1 class="page-header">
    {!! link_to_route('subscriptions.create', trans('subscription.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    {{ trans('subscription.subscriptions') }} <small>{{ $subscriptions->total() }} {{ trans('subscription.found') }}</small>
</h1>
<div class="well well-sm">
    {!! Form::open(['method'=>'get','class'=>'form-inline']) !!}
    {!! Form::text('q', Request::get('q'), ['class'=>'form-control index-search-field','placeholder'=>trans('subscription.search'),'style' => 'width:350px']) !!}
    {!! Form::submit(trans('subscription.search'), ['class' => 'btn btn-info btn-sm']) !!}
    {!! link_to_route('subscriptions.index','Reset',[],['class' => 'btn btn-default btn-sm']) !!}
    {!! Form::close() !!}
</div>

<table class="table table-condensed">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th>{{ trans('subscription.domain_name') }}</th>
        <th class="text-center">{{ trans('subscription.hosting_capacity') }}</th>
        <th>{{ trans('subscription.start_date') }}</th>
        <th>{{ trans('subscription.due_date') }}</th>
        <th class="text-right">{{ trans('subscription.extension_price') }}</th>
        <th class="text-center">{{ trans('app.status') }}</th>
        <th>{{ trans('app.action') }}</th>
    </thead>
    <tbody>
        @forelse($subscriptions as $key => $subscription)
        <tr {{ Carbon::parse($subscription->due_date)->diffInDays(Carbon::now()) < 60 ? 'class=bg-danger' : '' }}>
            <td>{{ $subscriptions->firstItem() + $key }}</td>
            <td>{{ $subscription->domain_name }}</td>
            <td class="text-center">{{ $subscription->hosting_capacity }}</td>
            <td>{{ dateId($subscription->start_date) }}</td>
            <td>{{ dateId($subscription->due_date) }}</td>
            <td class="text-right">{{ formatRp($subscription->domain_price + $subscription->hosting_price) }}</td>
            <td class="text-center">{{ $subscription->status() }}</td>
            <td>
                {!! link_to_route('subscriptions.show',trans('app.show'),[$subscription->id],['class'=>'btn btn-info btn-xs']) !!}
                {!! link_to_route('subscriptions.edit',trans('app.edit'),[$subscription->id],['class'=>'btn btn-warning btn-xs']) !!}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">{{ trans('subscription.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
    {!! str_replace('/?', '?', $subscriptions->appends(Request::except('page'))->render()) !!}
@endsection
