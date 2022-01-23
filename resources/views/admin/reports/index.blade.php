@extends('layouts.admin')
@section('content')

{{-- @can('page_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.reports.create") }}">
            Add New
        </a>
    </div>
</div>
@endcan --}}

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Reports
        </h4>
    </div>

    <!-- Page tabs -->
<div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-subscription">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th>Product ID / Prdouct Name</th>
                        <th>Seller</th>
                        <th>Reason</th>
                        <th>Description</th>
                        <th> Status </th>
                        <th>{{ __('Created At') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $key => $report)
                        <tr data-entry-id="{{ $report->id }}">
                            <td>{{ $report->id ?? '' }}</td>
                            <td>{{ $report->extra_data->product ?? '' }}</td>
                            <td>{{ ucwords($report->extra_data->seller_name) }}</td>
                            <td>{{ ucwords($report->reason) }}</td>
                            <td>{{ ucwords($report->description) }}</td>
                            <td>{{ ucwords($report->status) }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y')}}</td>
                            <td>
                                {{-- @can('report_view')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.reports.show', $report->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                                @endcan --}}
                                
                                @can('report_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.reports.edit', $report->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                                @endcan


                                @can('report_delete')
                                    <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
<!-- /page tabs -->
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.reports.massDestroy') }}",
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


  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  $('.datatable-reports:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
