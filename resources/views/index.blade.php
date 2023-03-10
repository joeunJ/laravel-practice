@extends('layout')

@section('content')
  <section class='book-table'>
    <h1 class='my-4'>올해의 추천</h1>
    <form action='/search' method='GET' class='d-flex mb-4 search-select-container justify-content-between'>
      <div class='flex-column justify-content-between container'>
        <div class='d-flex'>
          <label for='search' class='flex-shrink-0 me-3'>카테고리 : </label>
          <select name='selected_category' class='form-select form-select-sm mb-4 flex-grow-1' id='search' aria-lfabel='.form-select-sm example'>
              <option value=''>카테고리 선택</option>
              @foreach($category_names as $category)
                <option value='{{ $category }}' {{ request() -> get('selected_category') === $category ? 'selected' : null }}>{{ $category }}</option>
              @endforeach
          </select>
        </div>
        <div class='d-flex'>
            <label for='search' class='flex-shrink-0 me-3'>브랜드 : </label>
            <select name='selected_brand' class='form-select form-select-sm flex-grow-1' id='search' aria-label='.form-select-sm example'>
              <option value=''>브랜드 선택</option>
              @foreach($brands as $brand)
                <option value='{{ $brand -> id }}' {{ request() -> get('selected_brand') == ($brand->id) ? 'selected' : null }}>{{ $brand -> brand_name }}</option>
              @endforeach
            </select>
        </div>
      </div>
      <button type='submit' class='btn btn-light'>검색</button>
    </form>

    <table class='table table-hover'>
      <thead>
        <tr>
          <td>No.</td>
          <td>제목</td>
          <td>저자</td>
          <td>페이지</td>
          <td>가격</td>
          <td>카테고리</td>
          <td>브랜드</td>
          <td>수정</td>
        </tr>
      </thead>
      <tbody class='table-group-divider'>
        @foreach($books as $book)
          <tr>
            <td>{{$book->id}}</td>
            <td>{{$book->title}}</td>
            <td>
              @if(!$book->author)
                -
              @else
                {{ $book->author }}
              @endif
            </td>
            <td>{{$book->page}}</td>
            <td>{{$book->price}}</td>
            <td>{{$book->category->name}}</td>
            <td>{{$book->category->brand->brand_name}}</td>
            <td>
              @if($user_recommends -> where('book_id', $book->id) -> first())
                <button type='button' class='btn btn-light' 
                    onclick='location.href = "/book/{{ $book -> id }}/edit"'
                >수정</button>
              @endif 
            </td>
            <td>
              <button type='button' class='active-log-search-btn btn btn-outline-secondary' data-route='/book/{{ $book -> id }}/log' data-bs-toggle='modal' data-bs-target='#exampleModal'>로그 조회</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>
  <section class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h2 class='modal-title' id='exampleModalLabel'>로그내역</h2>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div>
        <div class='modal-body'>
        <table class='table table-hover'>
          <thead>
            <tr>
              <td>일/시</td>
              <td>내역</td>
            </tr>
          </thead>
          <tbody id='log-table' class='table-group-divider'></tbody>
        </table>
        </div>
      </div>
    </div>
  </section>
  <script src='assets/logModal.js'></script>
@endsection