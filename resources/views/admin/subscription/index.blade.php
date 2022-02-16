@extends('layouts.admin')
@section('content')
@can('subscription_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.subscription.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.subscription.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('cruds.subscription.title_singular') }} {{ trans('global.list') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-subscription">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.subscription.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscription.fields.title') }}
                        </th>
                        <th>
                            Product Limit
                        </th>
                        <th>
                            {{ trans('cruds.subscription.fields.price') }}
                        </th>
                        <!-- <th>
                            {{ trans('cruds.subscription.fields.end_at') }}
                        </th> -->
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $key => $subscription)
                        <tr data-entry-id="{{ $subscription->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $subscription->id ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->title ?? '' }}
                            </td>
                            <td>
                                {{ $subscription->product_limit ?$subscription->product_limit : '-' }}
                            </td>
                            <td>
                                {{ $subscription->price }}
                            </td>
                           <!--  <td>
                                {{ \Carbon\Carbon::parse($subscription->end_at)->format('d/m/Y')}}
                            </td> -->
                            <td>
                                

                                @can('subscription_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.subscription.edit', $subscription->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('subscription_delete')
                                    <form action="{{ route('admin.subscription.destroy', $subscription->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('subscription_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.subscription.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-subscription:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>


@endsection
