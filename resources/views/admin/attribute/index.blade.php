@extends('layouts.admin')
@section('content')
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.attributes.create", ['cat' => isset($_GET['cat'])?$_GET['cat']:$attr->cat_id]) }}">
              Add Attribute
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">{{$title ?? ''}}</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>id</th>
                        <th>Attribute Name</th>
                        <th>Category</th>
                        <th>Values</th>
                        {{-- <th>Add Values</th> --}}
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($Attributes as $key => $attr)
                        <tr data-entry-id="{{ $attr->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $attr->id ?? '' }}
                            </td>
                            <td>
                                {{ ucfirst($attr->title) ?? '' }}
                            </td>
                            <td>
                            {{ ucfirst($attr->name) ?? '' }}
                            </td>
                            <td>
                                <?php  $attrs =[]; ?>
                                @if(count($attr->atrVal)>0)
                                    @foreach($attr->atrVal as $val)
                                        <?php $attrs[] = "<spna>".ucfirst($val->title)."</sapn>"; ?>
                                    @endforeach

                                    <?php echo implode(", ",$attrs); ?>

                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @can('cat_add')

                                    <a class="btn btn-xs btn-success" href="{{ route('admin.attribute-value.index', ['attr' => $attr->id, 'cat' => isset($_GET['cat'])?$_GET['cat']:$attr->cat_id]) }}">
                                       Values
                                    </a>
                                @endcan
                                {{-- @can('user_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.attributes.show',$attr->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan --}}

                                @can('user_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.attributes.edit', [$attr->id, 'cat' => isset($_GET['cat'])?$_GET['cat']:$attr->cat_id]) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_delete')
                                    <form action="{{ route('admin.attributes.destroy', [$attr->id, 'cat' => isset($_GET['cat'])?$_GET['cat']:$attr->cat_id]) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
<style>
    table.dataTable tbody td.select-checkbox:before, table.dataTable tbody th.select-checkbox:before {
    content: ' ';
    margin-top: -6px;
    margin-left: -6px;
    border: 1px solid black;
    border-radius: 3px;
}
table.dataTable tbody td.select-checkbox:before {
    display:none

}
</style>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
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
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
