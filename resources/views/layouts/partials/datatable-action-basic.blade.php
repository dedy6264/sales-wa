@if ( auth()->user()->level != 9 )

    @if ($createAccess)
        @section('datatable-action-create')
            <div class="header-elements">
                <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
            </div>
        @endsection
    @endif

    @if ($updateAccess || $deleteAccess)
        @section('datatable-action-head')
            <th class="text-center">Actions</th>
        @endsection
    @endif

    @if ($updateAccess || $deleteAccess)
        @section('datatable-action-body')
            <td style="width: 16px;">
                <div class="btn-group">
                    @if ($updateAccess)
                        {{-- <button :disabled="item.deleted_at ? true : false" type="button" class="btn btn-outline bg-info-600 text-info-600 btn-icon btn-sm rounded-round ml-2" --}}
                        <button type="button" class="btn btn-outline bg-info-600 text-info-600 btn-icon btn-sm rounded-round ml-2"
                            data-popup="tooltip" title="" data-placement="left" data-original-title="Edit" @click="editModal(item)">
                            <i class="fas fa-pencil-alt"></i></button>
                    @endif
                    @if ($deleteAccess)
                        <button type="button" class="btn btn-outline bg-danger-600 text-danger-600 btn-icon btn-sm rounded-round ml-2"
                            data-popup="tooltip" title="" data-placement="left" data-original-title="Delete" @click="deleteData(item.id)">
                            <i class="far fa-trash-alt"></i></button>
                    @endif
                </div>
            </td>
        @endsection
    @endif

@endif

@if ( auth()->user()->level == 9 )

    @section('datatable-action-create')
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
    @endsection
    
    @section('datatable-action-head')
        <th class="text-center">Actions</th>
    @endsection
    
    @section('datatable-action-body')
        <td style="width: 16px;">
            <div class="btn-group">
                {{-- <button :disabled="item.deleted_at ? true : false" type="button" class="btn btn-outline bg-info-600 text-info-600 btn-icon btn-sm rounded-round ml-2" --}}
                <button type="button" class="btn btn-outline bg-info-600 text-info-600 btn-icon btn-sm rounded-round ml-2"
                    data-popup="tooltip" title="" data-placement="left" data-original-title="Edit" @click="editModal(item)">
                    <i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn btn-outline bg-danger-600 text-danger-600 btn-icon btn-sm rounded-round ml-2"
                    data-popup="tooltip" title="" data-placement="left" data-original-title="Delete" @click="deleteData(item.id)">
                    <i class="far fa-trash-alt"></i></button>
            </div>
        </td>
    @endsection

@endif