     
<div class="modalFilter modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="title">Filtro <span class="inner">(efeito scroll)</span></h2>
        </div>
        <section class="modal-body">
            <article class="filter-item">
                <h2 class="title">Tipo</h2>
                <div class="form-group">
                    <a href="{{ route('etips.index') }}" class="custom-control custom-checkbox">
                        @if ( $filterType == 'todas')
                        <input checked type="radio" name="category" value="todas"
                        class="custom-control-input">
                        @else
                        <input type="radio" name="category" value="todas"
                        class="custom-control-input">
                        @endif
                        <label for="" class="custom-control-indicator">Todas</label>
                    </a>
                </div>
                @foreach($type_global as $item )
                    <div class="form-group">
                        <a href="{{ route('etips.filter.type', $item->slug) }}" class="custom-control custom-checkbox">
                            @if ($item->slug == $filterType)
                            <input type="radio" checked name="type" value="{{ $item->name }}"
                            class="custom-control-input">
                            @else
                            <input type="radio" name="type" value="{{ $item->name }}"
                            class="custom-control-input">
                            @endif
                            <label for="" class="custom-control-indicator">{{ $item->name }}</label>
                        </a>
                    </div>
                @endforeach
            </article>
            <article class="filter-item">
                <h2 class="title">Marca</h2>
                <div class="form-group">
                    <a href="{{ route('etips.index') }}" class="custom-control custom-checkbox">
                        @if ( $filterBrand == 'todas')
                        <input checked type="radio" name="brand" value="todas"
                        class="custom-control-input">
                        @else
                        <input type="radio" name="brand" value="todas"
                        class="custom-control-input">
                        @endif
                        <label for="" class="custom-control-indicator">Todas</label>
                    </a>
                </div>
                @foreach($brand_global as $item )
                    <div class="form-group">
                        <a href="{{ route('etips.filter.brand', $item->slug ) }}" class="custom-control custom-checkbox">
                            @if ($item->slug == $filterBrand)
                            <input type="radio" checked name="brand" value="{{ $item->name }}"
                            class="custom-control-input">
                            @else
                            <input type="radio" name="brand" value="{{ $item->name }}"
                            class="custom-control-input">
                            @endif
                            <label for="" class="custom-control-indicator">{{ $item->name }}</label>
                        </a>
                    </div>
                @endforeach
            </article>
            <article class="filter-item">
                <h2 class="title">Modelo</h2>
                <div class="form-group">
                    <a href="{{ route('etips.index') }}" class="custom-control custom-checkbox">
                        @if ( $filterModel == 'todas')
                        <input checked type="radio" name="model" value="todas"
                        class="custom-control-input">
                        @else
                        <input type="radio" name="model" value="todas"
                        class="custom-control-input">
                        @endif
                        <label for="" class="custom-control-indicator">Todas</label>
                    </a>
                </div>
                @foreach($model_global as $item )
                    <div class="form-group">
                        <a href="{{ route('etips.filter.model', $item->slug) }}" class="custom-control custom-checkbox">
                            @if ($item->slug == $filterModel)
                            <input type="radio" checked name="model" value="{{ $item->name }}"
                            class="custom-control-input">
                            @else
                            <input type="radio" name="model" value="{{ $item->name }}"
                            class="custom-control-input">
                            @endif
                            <label for="" class="custom-control-indicator">{{ $item->name }}</label>
                        </a>
                    </div>
                @endforeach
            </article>
            <article class="filter-item">
                <h2 class="title">Versão</h2>
                <div class="form-group">
                    <a href="{{ route('etips.index') }}" class="custom-control custom-checkbox">
                        @if ( $filterVersion == 'todas')
                        <input checked type="radio" name="version" value="todas"
                        class="custom-control-input">
                        @else
                        <input type="radio" name="version" value="todas"
                        class="custom-control-input">
                        @endif
                        <label for="" class="custom-control-indicator">Todas</label>
                    </a>
                </div>
                @foreach($version_global as $item )
                    <div class="form-group">
                        <a href="{{ route('etips.filter.version', $item->name ) }}" class="custom-control custom-checkbox">
                            @if ($item->name == $filterVersion)
                            <input type="radio" checked name="version" value="{{ $item->name }}"
                            class="custom-control-input">
                            @else
                            <input type="radio" name="version" value="{{ $item->name }}"
                            class="custom-control-input">
                            @endif
                            <label for="" class="custom-control-indicator">{{ $item->name }}</label>
                        </a>
                    </div>
                @endforeach
            </article>
        </section>
    </div>
</div>