<div class="row">
    <b>Разделы</b>
</div>
<div class="row">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link mt-4 {{ url()->full() === route('dashboard_index') ? 'bg-primary text-white border border-primary rounded-pill' : '' }}" href="{{ route('dashboard_index') }}">Дашборд</a>
        </li>
        <li class="nav-item">
            <a class="nav-link my-2 {{ url()->full() === route('clients.index') ? 'my-2 bg-primary text-white border border-primary rounded-pill' : '' }}" href="{{ route('clients.index') }}">Клиенты</a>
        </li>
        <li class="nav-item">
            <a class="nav-link my-2 {{ url()->full() === route('hosts.index') ? 'my-2 bg-primary text-white border border-primary rounded-pill' : '' }}" href="{{ route('hosts.index') }}">Хосты</a>
        </li>
        <li class="nav-item">
            <a class="nav-link my-2 {{ url()->full() === route('projects.index') ? 'my-2 bg-primary text-white border border-primary rounded-pill' : '' }}" href="{{ route('projects.index') }}">Проекты</a>
        </li>
        <li class="nav-item mt-5">
            <a class="nav-link my-2" href="{{ route('logout') }}">Выйти</a>
        </li>
    </ul>
</div>
