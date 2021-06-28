@extends('template')

@section('content')
<main>
    <main class="content">
        <h2 class="title">Formulário de actualização</h2>
        <form class="register" action="{{ route('etips.update.store', encrypt($tip->id)) }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <select name="type" id="">
                    <option value="#" disabled>Selecionar tipo</option>
                    @foreach( $type_global as $type )
                        @if($type->id ==  $tip->type_id )
                            <option selected value="{{ $type->id }}">{{ $type->name }}</option>
                        @else
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="brand">Marca <span class="required">*</span></label>
                <input type="text" required name="brand" id="brand" value="{{ $tip->brand }}">
            </div>
            <div class="form-group">
                <label for="model">Modelo <span class="required">*</span></label>
                <input type="text" required name="model" id="model" value="{{ $tip->model }}">
            </div>
            <div class="form-group">
                <label for="version">Versão</label>
                <input type="text" name="version" id="version" @if($tip_version_global->where('tip_id', $tip->id
                )->first())
                 value="{{ $version_global->where('id', $tip_version_global->where('tip_id',  $tip->id )->first()->version_id)->first()->name  }}"
                @else

                @endif>
            </div>
            <div class="form-btn">
                <button class="btn" type="submit">Actualizar</button>
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
