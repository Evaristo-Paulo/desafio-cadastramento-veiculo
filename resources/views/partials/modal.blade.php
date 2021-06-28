<div class="modalLogin modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="title">Formulário de login</h2>
        </div>
        <form class="modal-body" method="POST" action="{{ route('etips.login') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="email">Senha</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-btn">
            <button class="btn" type="submit">Login</button>
            </div>
        </form>
    </div>
</div>
<div class="modalCreate modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="title">Formulário de cadastramento</h2>
        </div>
        <form id="ajaxSend" class="modal-body" method="POST" action="{{ route('etips.user.register') }}">
            {{ csrf_field() }}
            <div class="custom-spinner">
                <img src="{{ asset('image/logo.png') }}" alt="logo">
            </div>
            <div class="alert alert-success">
                Cadastrado com sucesso
                <p>Faça Login</p>
            </div>
            <div class="alert alert-danger">
                Erro ao cadastrar
            </div>
            <div class="form-group">
                <label for="rname">Nome Completo</label>
                <input type="text" name="name" id="rname">
            </div>
            <div class="form-group">
                <label for="remail">Email</label>
                <input type="email" name="email" id="remail">
            </div>
            <div class="form-group">
                <label for="rpassword">Senha</label>
                <input type="password" name="password" id="rpassword">
            </div>
            <div class="form-btn">
            <button class="btn" type="submit">Criar</button>
            </div>
        </form>
    </div>
</div>
