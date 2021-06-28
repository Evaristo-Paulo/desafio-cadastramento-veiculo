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
                <label for="brand">Marca <span class="required">*</span></label>
                <input type="text" required name="brand" id="brand">
            </div>
            <div class="form-group">
                <label for="model">Modelo <span class="required">*</span></label>
                <input type="text" required name="model" id="model">
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