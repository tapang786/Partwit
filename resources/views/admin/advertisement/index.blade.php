@extends('layouts.admin')
@section('content')
@can('advertisement_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.advertisement.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.advertisement.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('cruds.advertisement.title_singular') }} {{ trans('global.list') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-advertisement">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.advertisement.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.advertisement.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.advertisement.fields.banner_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.advertisement.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.advertisement.fields.start_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.advertisement.fields.end_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($advertisements as $key => $advertisement)
                        <tr data-entry-id="{{ $advertisement->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $advertisement->id ?? '' }}
                            </td>
                            <td>
                                {{ $advertisement->title ?? '' }}
                            </td>
                            <td>
                                <img src="{{ asset('images/banners/'.$advertisement->banner_image)}}" style="width:180px;" >
                            </td>
                            <td>
                                {{ $advertisement->status ? 'Acitve' : 'In active' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($advertisement->start_at)->format('d/m/Y')}}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($advertisement->end_at)->format('d/m/Y')}}
                            </td>
                            <td>
                                

                                @can('advertisement_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.advertisement.edit', $advertisement->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('advertisement_delete')
                                    <form action="{{ route('admin.advertisement.destroy', $advertisement->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('advertisement_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.advertisement.massDestroy') }}",
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
  $('.datatable-advertisement:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
