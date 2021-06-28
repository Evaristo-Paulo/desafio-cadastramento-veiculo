<header>
    <div class="header-detail">
        <ul class="group info">
            <li class="item">
                <i class="lni lni-envelope"></i> evaripaulo@gmail.com
            </li>
            <li class="item">
                <i class="lni lni-map-marker"></i> Centralidade do Sequele, Luanda, Angola
            </li>
            @auth
            <li class="item user">
                <i class="lni lni-user"></i> {{ Auth::user()->name }}
            </li>
            @endauth
        </ul>
        <ul class="group auth">
            <li class="item">
                @auth
                <a href="javascript:void(0);">{{ Auth::user()->name }}</a>
                @else
                <a href="javascript:void(0);" class="login">Login</a>
                @endauth
            </li>
            <li class="item">
                @auth
                <a href="{{ route('etips.logout') }}">Sair</a>
                @else
                <a href="javascript:void(0);" class="create">Criar Conta</a>
                @endauth
            </li>
        </ul>
    </div>
    <nav>
        <div class="logo">
            <img src="{{ asset('image/logo.png') }}" alt="logo">
        </div>
        <ul class="nav-group">
            <li class="item">
                <a href="{{ route('etips.index') }}">Home</a>
            </li>
            <li class="item">
                <a href="#reason">Nosso Diferencial</a>
            </li>
            <li class="item dropdown-menu">
                <a href="{{ route('etips.register') }}">Registar Dica</a>
            </li>
        </ul>
        <a href="{{ route('etips.mytips') }}" class="link-btn">Minhas Dicas</a>
        <div class="menu-icon-mobile">
            <!-- NÃO USOU-SE UMA DIV JUNTAMENTE COM O BEFORE/AFTER
                PARA PUDER PERMITIR ANIMAÇÃO AO ABRIR/FECHAR O MENU POSTERIORMENTE -->
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </nav>
</header>
