@extends('layouts.admin')
@section('content')
{{-- @can('product_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.products.create") }}">
                {{ trans('global.add') }}
            </a>
        </div>
    </div>
@endcan --}}
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ $title }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-product">
                <thead>
                    <tr>
                        <th width="10">

                        </th> 
                        <th> ID </th> 
                        <th>Product Name</th> 
                        <th>Product Image</th> 
                        <th>Seller</th> 
                        <th>Status</th>
                        <th>Publish Date</th> 
                        <th>Expire Date</th> 
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                        <tr data-entry-id="{{ $product->id }}">
                            <td>
                            </td>
                            <td>{{$product->id}}</td>
                            <td>
                                {{ $product->name ?? '' }}
                            </td>
                            <td>
                                @if($product->featured_image != '')
                                    <img src="{{url($product->featured_image)}}" width="125"> 
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{ $product->seller ?? ''}}
                            </td>
                            <td>
                                {{ $product->status ? 'Acitve' : 'In active' }}
                            </td>
                             <td>
                                {{ $product->listed_on ? \Carbon\Carbon::parse($product->listed_on)->format('d/m/Y') : '' }}
                            </td>
                            <td>
                                {{ $product->expires_on ? \Carbon\Carbon::parse($product->expires_on)->format('d/m/Y') : '' }}
                            </td>
                            <td>
                                @can('product_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.products.edit', $product->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('product_delete')
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('product_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.products.massDestroy') }}",
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
  // dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  $('.datatable-product:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
