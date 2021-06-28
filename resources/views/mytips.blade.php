@extends('template')

@section('content')
<main class="content">
    <h2 class="title">Listagem - Minhas dicas</h2>
    <table class="data-table table hover multiple-select-row nowrap">
        <thead>
            <tr>
                <th class="table-plus datatable-nosort">Nome</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Versão</th>
                <th>Acção</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $tips as $tip)
            <tr>
                <td class="table-plus">{{  $tip->type }}</td>
                <td>{{  $tip->brand }}</td>
                <td>{{  $tip->model }}</td>
                <td>
                    @if($tip_version_global->where('tip_id',  $tip->id )->first())
                        {{ $version_global->where('id', $tip_version_global->where('tip_id',  $tip->id )->first()->version_id)->first()->name }}
                    @else
                        
                    @endif
                </td>
                <td class="table-actions">
                    <a href="{{ route('etips.update', encrypt($tip->id)) }}"><i class="lni lni-pencil-alt"></i></a>
                    <form action="{{ route('etips.remove', encrypt($tip->id)) }}" method="POST">
                        {{ csrf_field() }}
                        @method('DELETE')
                        <button type="submit"><i class="lni lni-trash-can"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </section>
</main>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">

    <style>
        .content {
            margin: 0 !important;
        }

    </style>
@endpush

@push('js')
<script src="{{ asset('vendors/scripts/core.js') }}"></script>
	<script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
	<script src="{{ asset('vendors/scripts/process.js') }}"></script>
	<script src="{{ asset('vendors/scripts/layout-settings.js') }}set}}"></script>
	<script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
	<!-- Datatable Setting js -->
	<script src="{{ asset('vendors/scripts/datatable-setting.js') }}"></script></body>
@endpush
