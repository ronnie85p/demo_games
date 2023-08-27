<div class="row mb-4">
    <div class="col">
        <a class="btn btn-light" href="#" onclick="event.preventDefault(); window.history.back()"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
            </svg> Назад</a>
        <a class="btn btn-light" href="/games/list">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg> Игры</a>
    </div>
</div>

<h1 class="h4">Новая игра</h1>

<hr />
<form class="needs-validation" method="POST" novalidate>
    <div class="row mb-2">
        <div class="col-2">
            Название
        </div>
        <div class="col">
            <input class="form-control{{ $errors['name'] ? ' is-invalid' : '' }}" name="name" value="{{ $data['name'] }}" autocomplete="off" />
            <small class="invalid-feedback">
                {{ $errors['name'] }}
            </small>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-2">
            Описание
        </div>
        <div class="col">
            <textarea class="form-control{{ $errors['description'] ? ' is-invalid' : '' }}" name="description">{{ $data['description'] }}</textarea>
            <small class="invalid-feedback">
                {{ $errors['description'] }}
            </small>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-2">
            Жанр
        </div>
        <div class="col">
            <select class="form-control{{ $errors['genre'] ? ' is-invalid' : '' }}" name="genre_id">
                @foreach($genres as $g)
                    <option value="{{ $g->id }}"{{ $data['genre_id'] == $g->id ? ' selected' : '' }}>{{ $g->name }}</option>
                @endforeach
            </select>
            <small class="invalid-feedback">
                {{ $errors['genre'] }}
            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            Автор
        </div>
        <div class="col">
            <input class="form-control{{ $errors['author'] ? ' is-invalid' : '' }}" name="author" value="{{ $data['author'] }}" autocomplete="off" />
            <small class="invalid-feedback">
                {{ $errors['author'] }}
            </small>
        </div>
    </div>

    <hr />
    <button class="btn btn-primary">Добавить</button>
</form>