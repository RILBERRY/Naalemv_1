<div class="CateContainer" id="CC">
    <h2 class="closer"onclick="Closer()"><i class="fas fa-times"></i></h2>
    <h3 class="Cateheading">Categories</h3>
    <div class="cardHolder">
        @foreach($allCategories as $category)
        <div class="card" onClick="AddNewItem('{{$category->id}}')">
            <input type="hidden" id="name{{$category->id}}" value="{{$category->cate_name}}">
            <input type="hidden" id="price{{$category->id}}" value="{{$category->unit_price}}">
            <img src="img/{{$category -> img_path}}" alt="" srcset="" class="cardImg">
            <div class="cardDetail">
                <p>{{$category -> cate_name}}</p>
                <p>MVR {{$category -> unit_price}}/PER EACH</p>
            </div>
        </div>
        @endforeach 
    </div>
    <div class="addButton" onclick="PopUpContainer('category')">
        <h3>+ New Category</h3>
    </div>
</div>