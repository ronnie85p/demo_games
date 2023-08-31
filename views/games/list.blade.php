<div class="row">
    <div class="col">
        <a class="btn btn-light active" href="/games/">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
            </svg> Игры</a>
        <a class="btn btn-light" href="/games/create">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg> Добавить
        </a>
    </div>
</div>
<hr />

<form class="mb-4" method="GET" onchange="this.submit()">
    <div class="row">
        <div class="col-2">
            <label class="form-label">Жанр</label>
            <select class="form-control" name="genre_id">
                <option value="">Все</option>
                @foreach($genres as $g)
                    <option value="{{ $g->id }}"{{ $_GET['genre_id'] == $g->id ? ' selected' : ''}}>{{ $g->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>

@if (count($items))
    <div class="row">
        @foreach( $items as $item )
            <div class="col-3 mb-4">
                <a class="text-decoration-none" style="color: inherit" href="/games/{{ $item['id'] }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="h5 flex-grow-1 text-truncate">{{ $item['name'] }}</div>
                                <div>
                                    <small class="text-muted" title="Жанр">{{ $item['genre']['name'] }}</small>
                                </div>
                            </div>

                            <div class="text-dark text-truncate">{{ $item['description'] }}</div>
                        </div>
                        <div class="card-footer">
                            <div class="text-muted">
                                <div class="d-flex">
                                    <small class="flex-grow-1 text-truncate" title="Дата добавления: {{ $item['created_at'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                        </svg> {{ $item['created_at'] }}
                                    </small> 

                                    <small class="text-truncate" title="Автор: {{ $item['author'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                        </svg> {{ $item['author'] }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@else
    <div class="text-muted text-center">
        Список пуст
    </div>
@endif