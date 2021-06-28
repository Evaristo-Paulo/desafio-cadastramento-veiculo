@extends('template')

@section('content')
<main>
    <main class="content">
        <h2 class="title">Formulário de registo</h2>
        <form class="register" action="{{ route('etips.register.store') }}" method="POST">
            {{  csrf_field() }}
            <div class="form-group">
                <select name="type" id="">
                    <option value="#" disabled>Selecionar tipo</option>
                    @foreach ( $type_global as $type )
                    @if($type->slug == 'carro' )
                    <option selected value="{{ $type->id }}">{{ $type->name }}</option>
                    @else
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="brand" id="">
                    <option value="#" disabled>Selecionar marca</option>
                    @foreach ( $brand_global as $brand )
                        @if($brand->id == 1 )
                            <option selected value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @else
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endif
                    @endforeach                
                </select>
            </div>
            <div class="form-group">
                <label for="model">Modelo</label>
                <input type="text"  name="model" id="model" value="{{ old('model') }}">
            </div>
            <div class="form-group">
                <label for="version">Versão</label>
                <input type="text"  name="version" id="version">
            </div>
            <div class="form-btn">
            <button class="btn" type="submit">Registar</button>
            </div>
        </form>
        </section>
    </main>
    <!-- END CONTENT-->
</main>
@endsection

@push('css')
<style>
    .content {
        margin: 0 !important;
    }
</style>
@endpush

@push('js')
<script>
    /* Popular brand */
    //$(function () {
    //    $('#province').on('change', function (e) {
    //        var province_id = e.target.value;
    //        $('#municipe').empty();
    //        //Ajax
    //        $.get('/ajax-subcat?province_id=' + province_id, function (data) {
    //            $('#municipe').append(
    //                '<option selected disabled>Selecionar município</option>')
    //            $.each(data, function (index, subcatObj) {
    //                console.log(index)
    //                $('#municipe').append('<option value="' + subcatObj.id +
    //                    '">' + subcatObj.name + '</option>')
    //            });
    //        });
    //    });
    //});
    </script>
@endpush