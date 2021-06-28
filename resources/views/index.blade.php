@extends('template')

@section('content')
<main>
    <section class="why-us" id="reason">
        <article class="reason">
            <i class="lni lni-user"></i>
            <h2 class="title">Cria as tuas dicas</h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet sequi architecto, animi saepe.</p>
        </article>
        <article class="reason">
            <i class="lni lni-network"></i>
            <h2 class="title">Acesso as dicas de outros usuários</h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet sequi architecto, animi saepe.</p>
        </article>
        <article class="reason">
            <i class="lni lni-funnel"></i>
            <h2 class="title">Filtragem</h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet sequi architecto, animi saepe.</p>
        </article>
    </section>
    <!-- END WHY US-->
    <main class="content">
        <h2 class="title">Dicas</h2>
        <p class="filter-type">12 resultado(s) encontrado(s) na filtragem</p>
        <section class="tips">
            @forelse ( $tips as $tip )
            <article class="item">
                <p>Tipo: <span class="info">{{  $tip->type }}</span></p>
                <p>Marca: <span class="info">{{  $tip->brand }}</span></p>
                <p>Modelo: <span class="info">{{  $tip->model }}</span></p>
                <p>Versão: <span class="info">
                    @if($tip_version_global->where('tip_id',  $tip->id )->first())
                        {{ $version_global->where('id', $tip_version_global->where('tip_id',  $tip->id )->first()->version_id)->first()->name }}
                    @else
                        
                    @endif
                </span></p>
                <div class="writter">
                    <p>Escrito por {{  $tip->writter }}</p>
                    <div class="cover">
                        <img src="image/default.png" alt="evaristo-paulo">
                    </div>
                </div>
            </article>
            @empty
                
            @endforelse
            
        </section>
    </main>
    @endsection
