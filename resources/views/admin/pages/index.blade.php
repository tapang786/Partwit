@extends('layouts.admin')
@section('content')

@can('page_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.pages.create") }}">
            Add New
        </a>
    </div>
</div>
@endcan

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Pages
        </h4>
    </div>

    <!-- Page tabs -->
<div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-subscription">
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
                        <!-- <th>
                            {{ trans('cruds.advertisement.fields.banner_image') }}
                        </th> -->
                        <th>
                            {{ trans('cruds.advertisement.fields.status') }}
                        </th>
                        <th>
                            {{ __('Created At') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $key => $page)
                        <tr data-entry-id="{{ $page->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $page->id ?? '' }}
                            </td>
                            <td>
                                {{ ucwords($page->title ?? '') }}
                            </td>
                            
                            <td>
                                {{ ucwords($page->status) }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($page->created_at)->format('d/m/Y')}}
                            </td>
                            <td>
                                @can('page_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.pages.edit', $page->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                @endcan

                                @can('page_delete')
                                    @if($page->id > 3)
                                    
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                    @endif
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
    url: "{{ route('admin.pages.massDestroy') }}",
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
  $('.datatable-pages:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
